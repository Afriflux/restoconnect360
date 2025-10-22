import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';
import * as QRCode from 'qrcode';

@Injectable()
export class QRService {
  constructor(private prisma: PrismaService) {}
  
  async generateQRCode(params: {
    type: 'menu' | 'table' | 'order' | 'invoice' | 'loyalty' | 'checkin';
    commerceId: string;
    entityId?: string;
    metadata?: any;
  }) {
    // Créer code unique
    const code = this.generateUniqueCode(params);
    
    // URL selon le type
    const url = this.generateURL(params.type, code);
    
    // Générer QR Code image
    const qrImage = await QRCode.toDataURL(url, {
      errorCorrectionLevel: 'H',
      margin: 1,
      width: 300,
      color: {
        dark: '#000000',
        light: '#FFFFFF'
      }
    });
    
    // Sauvegarder en DB
    const qr = await this.prisma.qRCode.create({
      data: {
        type: params.type,
        commerceId: params.commerceId,
        entityId: params.entityId,
        code: code,
        metadata: params.metadata || {},
        analytics: { scans: 0, devices: [] }
      }
    });
    
    return {
      id: qr.id,
      code: code,
      url: url,
      imageUrl: qrImage,
      type: params.type
    };
  }
  
  // QR Menu dynamique
  async generateMenuQR(commerceId: string, tableNumber?: string) {
    return this.generateQRCode({
      type: 'menu',
      commerceId,
      entityId: tableNumber,
      metadata: { 
        tableNumber,
        generatedAt: new Date() 
      }
    });
  }
  
  // QR Table pour commande
  async generateTableQR(commerceId: string, tableId: string) {
    return this.generateQRCode({
      type: 'table',
      commerceId,
      entityId: tableId,
      metadata: {
        tableId,
        capacity: 4 // Par défaut
      }
    });
  }
  
  // QR Commande pour tracking
  async generateOrderQR(orderId: string) {
    const order = await this.prisma.order.findUnique({
      where: { id: orderId },
      include: { commerce: true }
    });
    
    return this.generateQRCode({
      type: 'order',
      commerceId: order.commerceId,
      entityId: orderId,
      metadata: {
        orderNumber: order.orderNumber,
        total: order.total
      }
    });
  }
  
  // QR Facture pour paiement
  async generateInvoiceQR(invoiceId: string) {
    const invoice = await this.prisma.invoice.findUnique({
      where: { id: invoiceId },
      include: { commerce: true }
    });
    
    return this.generateQRCode({
      type: 'invoice',
      commerceId: invoice.commerceId,
      entityId: invoiceId,
      metadata: {
        number: invoice.number,
        amount: invoice.total,
        status: invoice.status
      }
    });
  }
  
  // Tracking scans
  async trackScan(code: string, device: string, location?: string) {
    const qr = await this.prisma.qRCode.findFirst({
      where: { code }
    });
    
    if (!qr) return null;
    
    // Update analytics
    const analytics = qr.analytics as any;
    analytics.scans = (analytics.scans || 0) + 1;
    analytics.lastScan = new Date();
    analytics.devices = analytics.devices || [];
    
    if (!analytics.devices.includes(device)) {
      analytics.devices.push(device);
    }
    
    await this.prisma.qRCode.update({
      where: { id: qr.id },
      data: { analytics }
    });
    
    return qr;
  }
  
  private generateUniqueCode(params: any): string {
    const timestamp = Date.now().toString(36);
    const random = Math.random().toString(36).substring(2, 8);
    const type = params.type.substring(0, 3).toUpperCase();
    
    return `${type}-${timestamp}-${random}`.toUpperCase();
  }
  
  private generateURL(type: string, code: string): string {
    const baseUrl = process.env.APP_URL || 'http://localhost:3000';
    
    switch(type) {
      case 'menu':
        return `${baseUrl}/menu/${code}`;
      case 'table':
        return `${baseUrl}/order/table/${code}`;
      case 'order':
        return `${baseUrl}/track/${code}`;
      case 'invoice':
        return `${baseUrl}/invoice/${code}`;
      case 'loyalty':
        return `${baseUrl}/loyalty/${code}`;
      case 'checkin':
        return `${baseUrl}/checkin/${code}`;
      default:
        return `${baseUrl}/qr/${code}`;
    }
  }
}
