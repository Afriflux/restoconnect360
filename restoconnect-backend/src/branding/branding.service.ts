import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';

@Injectable()
export class BrandingService {
  constructor(private prisma: PrismaService) {}
  
  // Super Admin - Configuration globale
  async updatePlatformBranding(data: {
    colors: {
      primary: string;
      secondary: string;
      accent: string;
    };
    logos: {
      main: string;
      icon: string;
      favicon: string;
    };
    texts: {
      platformName: string;
      tagline: string;
      footer: string;
    };
  }) {
    return await this.prisma.platform.upsert({
      where: { id: 'default' },
      update: {
        whiteLabelConfig: data
      },
      create: {
        id: 'default',
        whiteLabelConfig: data,
        features: {}
      }
    });
  }
  
  // Commerce - Configuration individuelle
  async updateCommerceBranding(commerceId: string, data: {
    colors?: {
      primary?: string;
      secondary?: string;
      accent?: string;
      background?: string;
      text?: string;
    };
    logos?: {
      main?: string;
      icon?: string;
      favicon?: string;
      banner?: string;
    };
    fonts?: {
      heading?: string;
      body?: string;
    };
    customCSS?: string;
  }) {
    const commerce = await this.prisma.commerce.findUnique({
      where: { id: commerceId },
      select: { branding: true }
    });
    
    const updatedBranding = {
      ...commerce.branding as object,
      ...data
    };
    
    return await this.prisma.commerce.update({
      where: { id: commerceId },
      data: {
        branding: updatedBranding
      }
    });
  }
  
  // Générer CSS dynamique
  generateCustomCSS(branding: any): string {
    return `
      :root {
        --primary-color: ${branding.colors?.primary || '#3B82F6'};
        --secondary-color: ${branding.colors?.secondary || '#6B7280'};
        --accent-color: ${branding.colors?.accent || '#F59E0B'};
        --background-color: ${branding.colors?.background || '#FFFFFF'};
        --text-color: ${branding.colors?.text || '#111827'};
        --font-heading: ${branding.fonts?.heading || 'Inter, sans-serif'};
        --font-body: ${branding.fonts?.body || 'Inter, sans-serif'};
      }
      
      .btn-primary {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s;
      }
      
      .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
      }
      
      .commerce-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
      }
      
      h1, h2, h3 {
        font-family: var(--font-heading);
        color: var(--primary-color);
        font-weight: 700;
      }
      
      body {
        font-family: var(--font-body);
        color: var(--text-color);
        background-color: var(--background-color);
        line-height: 1.6;
      }
      
      .card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1rem;
      }
      
      ${branding.customCSS || ''}
    `;
  }
  
  // Récupérer branding d'un commerce
  async getCommerceBranding(commerceId: string) {
    const commerce = await this.prisma.commerce.findUnique({
      where: { id: commerceId },
      select: { branding: true, name: true }
    });
    
    return {
      ...commerce.branding as object,
      commerceName: commerce.name
    };
  }
  
  // Récupérer branding global de la plateforme
  async getPlatformBranding() {
    const platform = await this.prisma.platform.findUnique({
      where: { id: 'default' }
    });
    
    return platform?.whiteLabelConfig || {
      colors: {
        primary: '#3B82F6',
        secondary: '#6B7280',
        accent: '#F59E0B'
      },
      logos: {
        main: '',
        icon: '',
        favicon: ''
      },
      texts: {
        platformName: 'RestoConnect360',
        tagline: 'Plateforme Multi-Commerces Horeca/CHR',
        footer: '© 2025 RestoConnect360 - Zone UEMOA'
      }
    };
  }
}
