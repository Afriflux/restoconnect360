# 🚀 **RESTOCONNECT360 - ARCHITECTURE TECHNIQUE COMPLÈTE**

**Date :** 16 Octobre 2025  
**Source :** Spécifications techniques détaillées du client  
**Stack :** NestJS + Next.js + Prisma + PostgreSQL + Redis

---

## 🏗️ **STACK TECHNIQUE FINALE**

### **Frontend (Next.js 14)**
```json
{
  "dependencies": {
    "next": "14.0.0",
    "react": "18.0.0",
    "typescript": "5.0.0",
    "tailwindcss": "3.4.0",
    "@radix-ui/react-*": "latest",
    "zustand": "4.4.0",
    "@tanstack/react-query": "5.0.0",
    "recharts": "2.8.0",
    "qrcode.react": "3.1.0",
    "socket.io-client": "4.7.0"
  }
}
```

### **Backend (NestJS 10)**
```json
{
  "dependencies": {
    "@nestjs/core": "10.0.0",
    "@nestjs/common": "10.0.0",
    "@nestjs/platform-express": "10.0.0",
    "@nestjs/jwt": "10.0.0",
    "@nestjs/passport": "10.0.0",
    "@nestjs/bull": "10.0.0",
    "@prisma/client": "5.0.0",
    "prisma": "5.0.0",
    "bull": "4.12.0",
    "nodemailer": "6.9.0",
    "socket.io": "4.7.0",
    "qrcode": "1.5.0",
    "pdfkit": "0.14.0"
  }
}
```

### **Base de Données**
- **PostgreSQL 15** : DigitalOcean Managed
- **Redis 7** : Cache + Queue + Sessions
- **Prisma ORM** : Type-safe database access
- **CloudFlare R2** : Storage S3-compatible

---

## 🗄️ **SCHÉMA PRISMA MULTI-TENANCY**

### **Architecture Multi-Tenancy**
```prisma
// prisma/schema.prisma
generator client {
  provider = "prisma-client-js"
}

datasource db {
  provider = "postgresql"
  url      = env("DATABASE_URL")
}

// ============= SUPER ADMIN =============
model Platform {
  id              String   @id @default(cuid())
  whiteLabelConfig Json    // Couleurs, logos, textes globaux
  features        Json     // Feature flags globaux
  teams           Team[]
  createdAt       DateTime @default(now())
}

model Team {
  id         String   @id @default(cuid())
  name       String
  members    User[]
  role       String   // admin, support, sales, etc
  platformId String
  platform   Platform @relation(fields: [platformId], references: [id])
}

// ============= COMMERCES =============
model Commerce {
  id              String    @id @default(cuid())
  tenantId        String    @unique
  name            String
  type            String    // restaurant, cafe, bar, etc
  
  // White Label & Branding
  branding        Json      // {colors, logos, icons, favicon, texts}
  templateId      String    
  customCSS       String?
  
  // Subscription
  plan            String    // starter, pro, business, enterprise
  subscriptionEnd DateTime?
  features        Json      // Feature flags par commerce
  
  // Hiérarchie
  parentId        String?   // Pour succursales
  parent          Commerce? @relation("Succursales", fields: [parentId], references: [id])
  succursales     Commerce[] @relation("Succursales")
  
  // Paiements
  paymentProviders Json     // CinetPay, PayTech, Wave configs
  delegatedCollection Boolean @default(false)
  commissionRate   Decimal  @default(3.0)
  
  // Relations
  users           User[]
  products        Product[]
  orders          Order[]
  qrCodes         QRCode[]
  deliveryDrivers DeliveryDriver[]
  automations     Automation[]
  invoices        Invoice[]
  
  createdAt       DateTime  @default(now())
  updatedAt       DateTime  @updatedAt
}

// ============= USERS =============
model User {
  id          String   @id @default(cuid())
  email       String   @unique
  password    String
  role        String   // super_admin, commerce_admin, staff, delivery, customer
  
  commerceId  String?
  commerce    Commerce? @relation(fields: [commerceId], references: [id])
  
  teamId      String?
  team        Team?     @relation(fields: [teamId], references: [id])
  
  permissions Json     // Permissions granulaires
  profile     Json     // Nom, téléphone, photo, etc
  
  orders      Order[]  @relation("CustomerOrders")
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
}

// ============= PRODUCTS =============
model Product {
  id          String   @id @default(cuid())
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  name        String
  description String?
  price       Decimal
  images      String[] // URLs CloudFlare R2
  category    String
  
  halal       Boolean  @default(false)
  available   Boolean  @default(true)
  stock       Int?
  
  variants    Json?    // Tailles, options, etc
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, category])
}

// ============= ORDERS =============
model Order {
  id          String   @id @default(cuid())
  orderNumber String   @unique
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  customerId  String
  customer    User     @relation("CustomerOrders", fields: [customerId], references: [id])
  
  // QR Codes
  tableQRId   String?
  orderQRCode String   @unique // Pour tracking
  
  // Items
  items       Json     // [{productId, quantity, price, variants}]
  subtotal    Decimal
  tax         Decimal
  total       Decimal
  
  // Status
  status      String   // pending, confirmed, preparing, ready, delivered, cancelled
  paymentStatus String // pending, paid, refunded
  
  // Delivery
  deliveryType String? // dine-in, takeaway, delivery
  driverId    String?
  driver      DeliveryDriver? @relation(fields: [driverId], references: [id])
  deliveryAddress Json?
  
  // Paiement
  paymentMethod String // cash, cinetpay, paytech, wave, delegated
  paymentProvider String?
  transactionId String?
  
  invoiceId   String?  @unique
  invoice     Invoice? @relation(fields: [invoiceId], references: [id])
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, status])
  @@index([customerId])
}

// ============= QR CODES =============
model QRCode {
  id          String   @id @default(cuid())
  type        String   // menu, table, order, invoice, loyalty, checkin
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  entityId    String?  // ID de la table, commande, etc
  code        String   @unique
  metadata    Json     // Données spécifiques au type
  analytics   Json     // Scans count, locations, devices
  
  active      Boolean  @default(true)
  expiresAt   DateTime?
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@unique([type, entityId, commerceId])
  @@index([commerceId, type])
}

// ============= DELIVERY =============
model DeliveryDriver {
  id          String   @id @default(cuid())
  userId      String   @unique
  user        User     @relation(fields: [userId], references: [id])
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  vehicle     String   // moto, voiture, velo
  plateNumber String?
  
  status      String   // available, busy, offline
  currentLocation Json? // {lat, lng, timestamp}
  
  orders      Order[]
  
  // Stats
  totalDeliveries Int   @default(0)
  rating      Decimal?
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
}

// ============= INVOICES =============
model Invoice {
  id          String   @id @default(cuid())
  number      String   @unique // INV-2024-001
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  orderId     String   @unique
  order       Order?
  
  // QR Code pour paiement/vérification
  qrCode      String   @unique
  qrCodeUrl   String   // Image QR
  
  // Données facture
  items       Json
  subtotal    Decimal
  tax         Decimal
  total       Decimal
  
  // PDF
  pdfUrl      String   // CloudFlare R2
  
  // Status
  status      String   // draft, sent, paid, cancelled
  paidAt      DateTime?
  
  // Metadata
  metadata    Json     // Infos commerce, client, etc
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, status])
}

// ============= AUTOMATISATIONS =============
model Automation {
  id          String   @id @default(cuid())
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  name        String
  type        String   // notification, campaign, subscription, report
  
  // Trigger
  trigger     Json     // {type: "order_created", conditions: {...}}
  
  // Actions
  actions     Json     // [{type: "send_sms", params: {...}}, ...]
  
  // Schedule (optionnel)
  schedule    String?  // Cron expression
  
  active      Boolean  @default(true)
  
  // Stats
  executions  Int      @default(0)
  lastRun     DateTime?
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, type, active])
}

// ============= SUBSCRIPTIONS =============
model Subscription {
  id          String   @id @default(cuid())
  
  commerceId  String   @unique
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  plan        String   // starter, pro, business, enterprise
  status      String   // active, cancelled, expired, trial
  
  currentPeriodStart DateTime
  currentPeriodEnd   DateTime
  
  autoRenew   Boolean  @default(true)
  
  // Paiement
  paymentMethod String?
  lastPayment   DateTime?
  nextPayment   DateTime?
  
  // Add-ons activés
  addons      Json     // [{id: "halal", active: true, price: 5000}, ...]
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
}

// ============= PAYMENTS =============
model Payment {
  id          String   @id @default(cuid())
  
  commerceId  String
  
  // Type
  type        String   // order, subscription, addon, equipment
  entityId    String   // ID commande, subscription, etc
  
  // Montant
  amount      Decimal
  currency    String   @default("XOF")
  
  // Provider
  provider    String   // cinetpay, paytech, wave, delegated, cash
  transactionId String?
  
  // Commission (si délégation)
  isDelegated Boolean  @default(false)
  commission  Decimal?
  netAmount   Decimal  // Montant après commission
  
  // Status
  status      String   // pending, completed, failed, refunded
  
  // Metadata
  metadata    Json
  
  // Dates
  paidAt      DateTime?
  refundedAt  DateTime?
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, status])
  @@index([provider, transactionId])
}

// ============= EQUIPMENT (POS/Kiosk) =============
model Equipment {
  id          String   @id @default(cuid())
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  type        String   // pos, kiosk, printer, scanner
  model       String
  serialNumber String  @unique
  
  // Location
  location    String   // Succursale, table, etc
  
  // Status
  status      String   // active, maintenance, inactive
  
  // Location/Vente
  ownership   String   // rented, owned, provided
  monthlyFee  Decimal?
  purchasePrice Decimal?
  
  // Maintenance
  lastMaintenance DateTime?
  nextMaintenance DateTime?
  
  metadata    Json
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, type, status])
}

// ============= CAMPAIGNS =============
model Campaign {
  id          String   @id @default(cuid())
  
  commerceId  String
  commerce    Commerce @relation(fields: [commerceId], references: [id])
  
  name        String
  type        String   // sms, email, whatsapp, push
  
  // Targeting
  targetAudience Json  // {segment: "all", filters: {...}}
  
  // Content
  subject     String?
  message     String
  mediaUrl    String?
  
  // Schedule
  scheduledAt DateTime?
  status      String   // draft, scheduled, sent, cancelled
  
  // Stats
  sent        Int      @default(0)
  delivered   Int      @default(0)
  opened      Int      @default(0)
  clicked     Int      @default(0)
  
  sentAt      DateTime?
  
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
  
  @@index([commerceId, status])
}

// ============= ANALYTICS =============
model Analytics {
  id          String   @id @default(cuid())
  
  commerceId  String
  date        DateTime
  
  // Métriques
  orders      Int      @default(0)
  revenue     Decimal  @default(0)
  customers   Int      @default(0)
  
  // Par canal
  dineIn      Int      @default(0)
  takeaway    Int      @default(0)
  delivery    Int      @default(0)
  
  // QR Stats
  qrScans     Json     // {menu: 10, table: 5, ...}
  
  // Top products
  topProducts Json
  
  metadata    Json
  
  createdAt   DateTime @default(now())
  
  @@unique([commerceId, date])
  @@index([commerceId, date])
}
```

---

## 💳 **SERVICE DÉLÉGATION DE COLLECTE**

### **DelegationService.ts**
```typescript
// backend/src/payments/delegation.service.ts
import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';

@Injectable()
export class DelegationService {
  constructor(private prisma: PrismaService) {}
  
  // Vérifier si un commerce doit passer par délégation
  async shouldUseDelegation(commerceId: string): Promise<boolean> {
    const commerce = await this.prisma.commerce.findUnique({
      where: { id: commerceId },
      select: { 
        delegatedCollection: true,
        paymentProviders: true 
      }
    });
    
    // Si pas de providers configurés OU délégation activée
    const hasProviders = commerce.paymentProviders && 
      Object.keys(commerce.paymentProviders).length > 0;
    
    return !hasProviders || commerce.delegatedCollection;
  }
  
  // Calculer commission
  calculateCommission(amount: number, rate: number = 3.5): {
    commission: number;
    netAmount: number;
  } {
    const commission = (amount * rate) / 100;
    const netAmount = amount - commission;
    
    return { commission, netAmount };
  }
  
  // Créer paiement avec délégation
  async createDelegatedPayment(data: {
    commerceId: string;
    orderId: string;
    amount: number;
    method: 'wave' | 'cinetpay' | 'paytech';
  }) {
    const commerce = await this.prisma.commerce.findUnique({
      where: { id: data.commerceId },
      select: { commissionRate: true }
    });
    
    const { commission, netAmount } = this.calculateCommission(
      data.amount,
      commerce.commissionRate.toNumber()
    );
    
    // Créer paiement sur notre compte
    const payment = await this.paymentGateway.initiate({
      provider: data.method,
      amount: data.amount,
      metadata: {
        commerceId: data.commerceId,
        orderId: data.orderId,
        isDelegated: true
      }
    });
    
    // Enregistrer paiement avec commission
    return await this.prisma.payment.create({
      data: {
        commerceId: data.commerceId,
        type: 'order',
        entityId: data.orderId,
        amount: data.amount,
        currency: 'XOF',
        provider: data.method,
        transactionId: payment.transactionId,
        isDelegated: true,
        commission: commission,
        netAmount: netAmount,
        status: 'pending',
        metadata: {}
      }
    });
  }
  
  // Appel de fonds automatique (paiement aux commerces)
  async processFundCalls() {
    // Tous les lundis à 9h (exemple)
    const commerces = await this.prisma.commerce.findMany({
      where: {
        delegatedCollection: true,
        // Avoir des paiements à verser
      }
    });
    
    for (const commerce of commerces) {
      // Calculer montant à verser
      const payments = await this.prisma.payment.findMany({
        where: {
          commerceId: commerce.id,
          isDelegated: true,
          status: 'completed',
          transferredAt: null // Pas encore transféré
        }
      });
      
      const totalToTransfer = payments.reduce(
        (sum, p) => sum + p.netAmount.toNumber(), 
        0
      );
      
      if (totalToTransfer > 0) {
        // Initier transfert
        await this.transferFunds(commerce, totalToTransfer);
        
        // Marquer comme transféré
        await this.prisma.payment.updateMany({
          where: {
            id: { in: payments.map(p => p.id) }
          },
          data: {
            transferredAt: new Date()
          }
        });
        
        // Notification au commerce
        await this.notificationService.send({
          type: 'email',
          to: commerce.email,
          subject: 'Virement effectué',
          message: `${totalToTransfer} XOF transférés sur votre compte`
        });
      }
    }
  }
}
```

---

## 📱 **SERVICE QR CODES UNIVERSELLES**

### **QRService.ts**
```typescript
// backend/src/qr/qr.service.ts
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
    
    // Upload image vers CloudFlare R2
    const imageUrl = await this.uploadToR2(qrImage, `qr/${code}.png`);
    
    return {
      id: qr.id,
      code: code,
      url: url,
      imageUrl: imageUrl,
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
        capacity: await this.getTableCapacity(tableId)
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
    const baseUrl = process.env.APP_URL;
    
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
```

---

## 📄 **GÉNÉRATEUR DE FACTURES NUMÉRIQUES**

### **InvoiceGeneratorService.ts**
```typescript
// backend/src/invoices/invoice-generator.service.ts
import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';
import PDFDocument from 'pdfkit';
import * as QRCode from 'qrcode';

@Injectable()
export class InvoiceGeneratorService {
  constructor(
    private prisma: PrismaService,
    private qrService: QRService
  ) {}
  
  async generateInvoice(orderId: string): Promise<string> {
    // Récupérer données
    const order = await this.prisma.order.findUnique({
      where: { id: orderId },
      include: {
        commerce: true,
        customer: true,
        items: true
      }
    });
    
    // Créer facture
    const invoice = await this.prisma.invoice.create({
      data: {
        number: await this.generateInvoiceNumber(order.commerceId),
        commerceId: order.commerceId,
        orderId: order.id,
        items: order.items,
        subtotal: order.subtotal,
        tax: order.tax,
        total: order.total,
        status: 'sent',
        metadata: {
          commerce: order.commerce,
          customer: order.customer
        }
      }
    });
    
    // Générer QR Code
    const qr = await this.qrService.generateInvoiceQR(invoice.id);
    
    // Update invoice avec QR
    await this.prisma.invoice.update({
      where: { id: invoice.id },
      data: {
        qrCode: qr.code,
        qrCodeUrl: qr.imageUrl
      }
    });
    
    // Générer PDF
    const pdfBuffer = await this.createPDF(invoice, order, qr);
    
    // Upload vers R2
    const pdfUrl = await this.uploadToR2(
      pdfBuffer,
      `invoices/${invoice.number}.pdf`
    );
    
    // Update invoice
    await this.prisma.invoice.update({
      where: { id: invoice.id },
      data: { pdfUrl }
    });
    
    return pdfUrl;
  }
  
  private async createPDF(invoice: any, order: any, qr: any) {
    return new Promise<Buffer>((resolve, reject) => {
      const doc = new PDFDocument({
        size: 'A4',
        margin: 50
      });
      
      const buffers: Buffer[] = [];
      doc.on('data', buffers.push.bind(buffers));
      doc.on('end', () => resolve(Buffer.concat(buffers)));
      doc.on('error', reject);
      
      // Header avec branding
      const branding = order.commerce.branding;
      doc.fontSize(25)
         .fillColor(branding.colors.primary)
         .text('FACTURE', 50, 50);
      
      // Logo
      if (branding.logo) {
        doc.image(branding.logo, 450, 45, { width: 100 });
      }
      
      // Infos commerce
      doc.fontSize(10)
         .fillColor('#000000')
         .text(order.commerce.name, 50, 100)
         .text(order.commerce.address, 50, 115)
         .text(order.commerce.phone, 50, 130);
      
      // Numéro facture
      doc.fontSize(12)
         .text(`Facture N°: ${invoice.number}`, 400, 100)
         .fontSize(10)
         .text(`Date: ${new Date().toLocaleDateString('fr-FR')}`, 400, 115)
         .text(`Commande: ${order.orderNumber}`, 400, 130);
      
      // Client
      doc.fontSize(12)
         .text('Client:', 50, 180)
         .fontSize(10)
         .text(order.customer.name, 50, 195)
         .text(order.customer.email, 50, 210);
      
      // Table items
      const tableTop = 250;
      doc.fontSize(10)
         .text('Article', 50, tableTop)
         .text('Qté', 300, tableTop)
         .text('Prix Unit.', 360, tableTop)
         .text('Total', 460, tableTop);
      
      // Line
      doc.moveTo(50, tableTop + 15)
         .lineTo(550, tableTop + 15)
         .stroke();
      
      // Items
      let y = tableTop + 30;
      order.items.forEach((item: any) => {
        doc.text(item.name, 50, y)
           .text(item.quantity, 300, y)
           .text(`${item.price} XOF`, 360, y)
           .text(`${item.quantity * item.price} XOF`, 460, y);
        y += 20;
      });
      
      // Totals
      y += 20;
      doc.moveTo(50, y)
         .lineTo(550, y)
         .stroke();
      
      y += 15;
      doc.text('Sous-total:', 360, y)
         .text(`${invoice.subtotal} XOF`, 460, y);
      
      y += 20;
      doc.text('TVA:', 360, y)
         .text(`${invoice.tax} XOF`, 460, y);
      
      y += 20;
      doc.fontSize(12)
         .text('TOTAL:', 360, y)
         .text(`${invoice.total} XOF`, 460, y);
      
      // QR Code
      y += 60;
      doc.fontSize(10)
         .text('Scannez pour payer ou vérifier:', 50, y);
      
      // Ajouter image QR
      doc.image(qr.imageUrl, 50, y + 20, { width: 150 });
      
      // Footer
      doc.fontSize(8)
         .fillColor('#666666')
         .text(
           'Facture générée électroniquement par RestoConnect360',
           50,
           750,
           { align: 'center' }
         );
      
      doc.end();
    });
  }
  
  private async generateInvoiceNumber(commerceId: string): Promise<string> {
    const year = new Date().getFullYear();
    const count = await this.prisma.invoice.count({
      where: {
        commerceId,
        createdAt: {
          gte: new Date(`${year}-01-01`)
        }
      }
    });
    
    return `INV-${year}-${String(count + 1).padStart(4, '0')}`;
  }
}
```

---

## 🎨 **SERVICE WHITE LABEL**

### **BrandingService.ts**
```typescript
// backend/src/white-label/branding.service.ts
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
    return await this.prisma.platform.update({
      where: { id: 'default' },
      data: {
        whiteLabelConfig: data
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
      ...commerce.branding,
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
        --primary-color: ${branding.colors.primary};
        --secondary-color: ${branding.colors.secondary};
        --accent-color: ${branding.colors.accent};
        --background-color: ${branding.colors.background};
        --text-color: ${branding.colors.text};
        --font-heading: ${branding.fonts.heading};
        --font-body: ${branding.fonts.body};
      }
      
      .btn-primary {
        background-color: var(--primary-color);
        color: white;
      }
      
      .commerce-header {
        background-color: var(--primary-color);
      }
      
      h1, h2, h3 {
        font-family: var(--font-heading);
        color: var(--primary-color);
      }
      
      body {
        font-family: var(--font-body);
        color: var(--text-color);
        background-color: var(--background-color);
      }
      
      ${branding.customCSS || ''}
    `;
  }
  
  // Upload assets
  async uploadAsset(
    file: Express.Multer.File,
    type: 'logo' | 'icon' | 'favicon' | 'banner'
  ): Promise<string> {
    // Optimiser image
    const optimized = await this.imageService.optimize(file);
    
    // Upload vers CloudFlare R2
    const url = await this.uploadToR2(
      optimized,
      `branding/${type}-${Date.now()}.${file.mimetype.split('/')[1]}`
    );
    
    return url;
  }
}
```

---

## 🤖 **MOTEUR D'AUTOMATISATION**

### **AutomationEngine.ts**
```typescript
// backend/src/automations/automation.engine.ts
import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';

@Injectable()
export class AutomationEngine {
  constructor(private prisma: PrismaService) {}
  
  // Définir automatisation
  async createAutomation(commerceId: string, config: {
    name: string;
    type: 'notification' | 'campaign' | 'subscription' | 'report';
    trigger: {
      event: string; // order_created, payment_received, etc
      conditions?: any;
    };
    actions: Array<{
      type: 'send_email' | 'send_sms' | 'send_whatsapp' | 'update_status';
      params: any;
    }>;
    schedule?: string; // Cron expression
  }) {
    return await this.prisma.automation.create({
      data: {
        commerceId,
        ...config,
        active: true
      }
    });
  }
  
  // Exécuter automatisation
  async execute(trigger: string, data: any) {
    const automations = await this.prisma.automation.findMany({
      where: {
        active: true,
        trigger: {
          path: ['event'],
          equals: trigger
        }
      }
    });
    
    for (const automation of automations) {
      // Vérifier conditions
      if (!this.checkConditions(automation.trigger.conditions, data)) {
        continue;
      }
      
      // Exécuter actions
      for (const action of automation.actions) {
        await this.executeAction(action, data);
      }
      
      // Update stats
      await this.prisma.automation.update({
        where: { id: automation.id },
        data: {
          executions: { increment: 1 },
          lastRun: new Date()
        }
      });
    }
  }
  
  private async executeAction(action: any, data: any) {
    switch(action.type) {
      case 'send_email':
        await this.emailService.send({
          to: data.customer.email,
          subject: this.interpolate(action.params.subject, data),
          body: this.interpolate(action.params.body, data)
        });
        break;
        
      case 'send_sms':
        await this.smsService.send({
          to: data.customer.phone,
          message: this.interpolate(action.params.message, data)
        });
        break;
        
      case 'send_whatsapp':
        await this.whatsappService.send({
          to: data.customer.phone,
          template: action.params.template,
          params: data
        });
        break;
        
      case 'update_status':
        // Logic pour update status
        break;
    }
  }
  
  private interpolate(template: string, data: any): string {
    return template.replace(/\{\{(\w+)\}\}/g, (_, key) => {
      return data[key] || '';
    });
  }
  
  private checkConditions(conditions: any, data: any): boolean {
    if (!conditions) return true;
    
    // Exemple: conditions = { order.total: { gte: 10000 } }
    // Implémenter logique de vérification
    return true;
  }
}

// Exemples d'automatisations pré-configurées
export const DEFAULT_AUTOMATIONS = [
  {
    name: 'Notification Nouvelle Commande',
    type: 'notification',
    trigger: {
      event: 'order_created'
    },
    actions: [
      {
        type: 'send_sms',
        params: {
          message: 'Nouvelle commande {{orderNumber}} reçue ! Total: {{total}} XOF'
        }
      },
      {
        type: 'send_whatsapp',
        params: {
          template: 'order_confirmation',
          params: {
            orderNumber: '{{orderNumber}}',
            total: '{{total}}',
            items: '{{items}}'
          }
        }
      }
    ]
  },
  {
    name: 'Rappel Paiement',
    type: 'notification',
    trigger: {
      event: 'payment_pending',
      conditions: { delay: '1h' }
    },
    actions: [
      {
        type: 'send_email',
        params: {
          subject: 'Rappel de paiement - Commande {{orderNumber}}',
          body: 'Votre commande {{orderNumber}} attend votre paiement de {{total}} XOF'
        }
      }
    ]
  },
  {
    name: 'Campagne Fidélité',
    type: 'campaign',
    trigger: {
      event: 'customer_visit',
      conditions: { visits: { gte: 5 } }
    },
    actions: [
      {
        type: 'send_sms',
        params: {
          message: 'Merci pour votre fidélité ! Profitez de -20% sur votre prochaine commande avec le code FIDELITE20'
        }
      }
    ]
  }
];
```

---

## 🚀 **DÉPLOIEMENT ET CONFIGURATION**

### **Docker Compose pour Développement**
```yaml
# docker-compose.yml
version: '3.8'
services:
  postgres:
    image: postgres:15
    environment:
      POSTGRES_DB: restoconnect360
      POSTGRES_USER: postgres
      POSTGRES_PASSWORD: password
    ports:
      - "5432:5432"
    volumes:
      - postgres_data:/var/lib/postgresql/data

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data

  backend:
    build: ./backend
    ports:
      - "3001:3001"
    environment:
      - DATABASE_URL=postgresql://postgres:password@postgres:5432/restoconnect360
      - REDIS_URL=redis://redis:6379
    depends_on:
      - postgres
      - redis

  frontend:
    build: ./frontend
    ports:
      - "3000:3000"
    environment:
      - NEXT_PUBLIC_API_URL=http://localhost:3001
    depends_on:
      - backend

volumes:
  postgres_data:
  redis_data:
```

### **Scripts de Démarrage**
```json
// package.json
{
  "scripts": {
    "dev": "concurrently \"npm run dev:backend\" \"npm run dev:frontend\"",
    "dev:backend": "cd backend && npm run start:dev",
    "dev:frontend": "cd frontend && npm run dev",
    "build": "npm run build:backend && npm run build:frontend",
    "build:backend": "cd backend && npm run build",
    "build:frontend": "cd frontend && npm run build",
    "db:migrate": "cd backend && npx prisma migrate dev",
    "db:seed": "cd backend && npx prisma db seed",
    "db:studio": "cd backend && npx prisma studio"
  }
}
```

---

## 💰 **BUDGET DÉTAILLÉ**

### **Semaines 1-2 : Infrastructure**
- **DigitalOcean Droplet 4GB** : 24$/mois
- **CloudFlare Pro** : 20$/mois
- **PostgreSQL Managé** : 15$/mois
- **Redis Managé** : 10$/mois
- **R2 Storage** : 5$/mois
- **Domaine** : 15$/an
- **Total** : 75$/mois

### **Semaines 3-4 : Services**
- **SMS/WhatsApp API** : 50$
- **Sandbox paiements** : Gratuit
- **Testing devices** : Existant
- **Total** : 50$

### **Semaines 5-6 : Communication**
- **Email Service** : 20$/mois
- **WhatsApp Business API** : 50$ setup
- **Monitoring Sentry** : 26$/mois
- **Total** : 142$

### **Semaines 7-8 : Finalisation**
- **SSL Certificates** : Gratuit
- **CDN bandwidth** : ~30$
- **Marketing assets** : 13$/mois
- **Beta testers** : 40$
- **Total** : ~85$

---

## 🎯 **CONCLUSION**

Cette architecture technique complète avec NestJS + Next.js + Prisma est **parfaitement adaptée** pour RestoConnect360 :

### **Points Forts**
- **Stack moderne** : TypeScript partout
- **Multi-tenancy** : Architecture scalable
- **Paiements africains** : CinetPay + PayTech + Wave
- **QR codes universels** : 6 types différents
- **Factures numériques** : PDF + QR automatiques
- **White label complet** : Contrôle total du branding
- **Automatisations** : Moteur configurable
- **Infrastructure** : Services managés + CDN

### **Prêt pour l'Implémentation**
- **Schéma Prisma** : Complet et optimisé
- **Services NestJS** : Architecture modulaire
- **Frontend Next.js** : PWA + TypeScript
- **Déploiement** : Docker + CI/CD

**Voulez-vous que je commence l'implémentation immédiatement ?** 🚀

Je peux créer tous les fichiers de configuration et commencer le développement de cette architecture de pointe !
