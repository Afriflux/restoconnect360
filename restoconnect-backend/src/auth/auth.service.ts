import { Injectable, UnauthorizedException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { PrismaService } from '../prisma/prisma.service';
import * as bcrypt from 'bcryptjs';

@Injectable()
export class AuthService {
  constructor(
    private prisma: PrismaService,
    private jwtService: JwtService,
  ) {}

  async validateUser(email: string, password: string): Promise<any> {
    const user = await this.prisma.user.findUnique({
      where: { email },
      include: { commerce: true, team: true }
    });

    if (user && await bcrypt.compare(password, user.password)) {
      const { password: _, ...result } = user;
      return result;
    }
    return null;
  }

  async login(user: any) {
    const payload = { 
      email: user.email, 
      sub: user.id, 
      role: user.role,
      commerceId: user.commerceId,
      teamId: user.teamId
    };
    
    return {
      access_token: this.jwtService.sign(payload),
      user: {
        id: user.id,
        email: user.email,
        role: user.role,
        profile: user.profile,
        commerce: user.commerce,
        team: user.team
      }
    };
  }

  async register(userData: {
    email: string;
    password: string;
    role: string;
    commerceId?: string;
    teamId?: string;
    profile?: any;
  }) {
    const hashedPassword = await bcrypt.hash(userData.password, 10);
    
    const user = await this.prisma.user.create({
      data: {
        email: userData.email,
        password: hashedPassword,
        role: userData.role,
        commerceId: userData.commerceId,
        teamId: userData.teamId,
        profile: userData.profile || {},
        permissions: this.getDefaultPermissions(userData.role)
      },
      include: { commerce: true, team: true }
    });

    const { password: _, ...result } = user;
    return result;
  }

  private getDefaultPermissions(role: string): any {
    const permissions = {
      super_admin: {
        canManagePlatform: true,
        canManageCommerces: true,
        canManageUsers: true,
        canViewAnalytics: true,
        canManageBranding: true
      },
      commerce_admin: {
        canManageCommerce: true,
        canManageProducts: true,
        canManageOrders: true,
        canManageStaff: true,
        canViewCommerceAnalytics: true
      },
      staff: {
        canManageOrders: true,
        canManageProducts: true,
        canViewOrders: true
      },
      delivery: {
        canManageDeliveries: true,
        canUpdateLocation: true,
        canViewDeliveryOrders: true
      },
      customer: {
        canPlaceOrders: true,
        canViewOwnOrders: true
      }
    };

    return permissions[role] || {};
  }

  async createCommerce(commerceData: {
    name: string;
    type: string;
    tenantId: string;
    plan?: string;
    branding?: any;
  }) {
    return await this.prisma.commerce.create({
      data: {
        name: commerceData.name,
        type: commerceData.type,
        tenantId: commerceData.tenantId,
        plan: commerceData.plan || 'starter',
        branding: commerceData.branding || {
          colors: {
            primary: '#3B82F6',
            secondary: '#6B7280',
            accent: '#F59E0B'
          },
          logos: {},
          fonts: {
            heading: 'Inter, sans-serif',
            body: 'Inter, sans-serif'
          }
        },
        features: {},
        paymentProviders: {},
        delegatedCollection: false,
        commissionRate: 3.0
      }
    });
  }
}
