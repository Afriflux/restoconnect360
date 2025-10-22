import { Controller, Post, Body, UseGuards, Request, Get } from '@nestjs/common';
import { AuthService } from './auth.service';
import { LocalAuthGuard } from './local-auth.guard';
import { JwtAuthGuard } from './jwt-auth.guard';

@Controller('auth')
export class AuthController {
  constructor(private authService: AuthService) {}

  @UseGuards(LocalAuthGuard)
  @Post('login')
  async login(@Request() req) {
    return this.authService.login(req.user);
  }

  @Post('register')
  async register(@Body() userData: {
    email: string;
    password: string;
    role: string;
    commerceId?: string;
    teamId?: string;
    profile?: any;
  }) {
    return this.authService.register(userData);
  }

  @Post('register-commerce')
  async registerCommerce(@Body() data: {
    commerce: {
      name: string;
      type: string;
      tenantId: string;
      plan?: string;
      branding?: any;
    };
    admin: {
      email: string;
      password: string;
      profile?: any;
    };
  }) {
    // Créer le commerce
    const commerce = await this.authService.createCommerce(data.commerce);
    
    // Créer l'admin du commerce
    const admin = await this.authService.register({
      email: data.admin.email,
      password: data.admin.password,
      role: 'commerce_admin',
      commerceId: commerce.id,
      profile: data.admin.profile
    });

    return {
      commerce,
      admin
    };
  }

  @UseGuards(JwtAuthGuard)
  @Get('profile')
  getProfile(@Request() req) {
    return req.user;
  }

  @UseGuards(JwtAuthGuard)
  @Post('refresh')
  refreshToken(@Request() req) {
    return this.authService.login(req.user);
  }
}
