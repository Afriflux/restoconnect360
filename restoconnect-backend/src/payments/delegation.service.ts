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
      Object.keys(commerce.paymentProviders as object).length > 0;
    
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
    
    // Enregistrer paiement avec commission
    return await this.prisma.payment.create({
      data: {
        commerceId: data.commerceId,
        type: 'order',
        entityId: data.orderId,
        amount: data.amount,
        currency: 'XOF',
        provider: data.method,
        transactionId: `DELEGATED-${Date.now()}`,
        isDelegated: true,
        commission: commission,
        netAmount: netAmount,
        status: 'pending',
        metadata: {
          delegatedAt: new Date(),
          originalAmount: data.amount
        }
      }
    });
  }
  
  // Appel de fonds automatique (paiement aux commerces)
  async processFundCalls() {
    const commerces = await this.prisma.commerce.findMany({
      where: {
        delegatedCollection: true,
      }
    });
    
    for (const commerce of commerces) {
      // Calculer montant à verser
      const payments = await this.prisma.payment.findMany({
        where: {
          commerceId: commerce.id,
          isDelegated: true,
          status: 'completed',
          // transferredAt: null // Pas encore transféré
        }
      });
      
      const totalToTransfer = payments.reduce(
        (sum, p) => sum + p.netAmount.toNumber(), 
        0
      );
      
      if (totalToTransfer > 0) {
        // Marquer comme transféré
        await this.prisma.payment.updateMany({
          where: {
            id: { in: payments.map(p => p.id) }
          },
          data: {
            metadata: {
              ...payments[0].metadata as object,
              transferredAt: new Date()
            }
          }
        });
        
        console.log(`Transfert de ${totalToTransfer} XOF vers ${commerce.name}`);
      }
    }
  }
}
