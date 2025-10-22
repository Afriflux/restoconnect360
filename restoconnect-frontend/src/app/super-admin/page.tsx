'use client';

import { useState, useEffect } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Badge } from '@/components/ui/badge';
import { 
  Users, 
  Store, 
  CreditCard, 
  QrCode, 
  Settings, 
  Palette,
  BarChart3,
  Globe,
  Zap,
  Shield
} from 'lucide-react';

interface PlatformStats {
  totalCommerces: number;
  activeCommerces: number;
  totalOrders: number;
  totalRevenue: number;
  totalUsers: number;
}

interface Commerce {
  id: string;
  name: string;
  type: string;
  plan: string;
  status: string;
  createdAt: string;
  tenantId: string;
}

export default function SuperAdminDashboard() {
  const [stats, setStats] = useState<PlatformStats>({
    totalCommerces: 0,
    activeCommerces: 0,
    totalOrders: 0,
    totalRevenue: 0,
    totalUsers: 0
  });

  const [commerces, setCommerces] = useState<Commerce[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Simuler le chargement des données
    setTimeout(() => {
      setStats({
        totalCommerces: 156,
        activeCommerces: 142,
        totalOrders: 2847,
        totalRevenue: 45678900, // XOF
        totalUsers: 892
      });

      setCommerces([
        {
          id: '1',
          name: 'Restaurant Le Gourmet',
          type: 'restaurant',
          plan: 'pro',
          status: 'active',
          createdAt: '2025-01-15',
          tenantId: 'le-gourmet-001'
        },
        {
          id: '2',
          name: 'Café Central',
          type: 'cafe',
          plan: 'starter',
          status: 'active',
          createdAt: '2025-01-20',
          tenantId: 'cafe-central-002'
        },
        {
          id: '3',
          name: 'Bar Le Sunset',
          type: 'bar',
          plan: 'business',
          status: 'active',
          createdAt: '2025-02-01',
          tenantId: 'bar-sunset-003'
        }
      ]);

      setLoading(false);
    }, 1000);
  }, []);

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('fr-FR', {
      style: 'currency',
      currency: 'XOF',
      minimumFractionDigits: 0
    }).format(amount);
  };

  const getPlanBadgeColor = (plan: string) => {
    switch (plan) {
      case 'starter': return 'bg-gray-100 text-gray-800';
      case 'pro': return 'bg-blue-100 text-blue-800';
      case 'business': return 'bg-green-100 text-green-800';
      case 'enterprise': return 'bg-purple-100 text-purple-800';
      default: return 'bg-gray-100 text-gray-800';
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Chargement du tableau de bord...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center py-6">
            <div>
              <h1 className="text-3xl font-bold text-gray-900">RestoConnect360</h1>
              <p className="text-gray-600">Super Admin Dashboard - Zone UEMOA</p>
            </div>
            <div className="flex items-center space-x-4">
              <Badge variant="outline" className="bg-green-50 text-green-700 border-green-200">
                <Globe className="w-4 h-4 mr-1" />
                8 Pays UEMOA
              </Badge>
              <Badge variant="outline" className="bg-blue-50 text-blue-700 border-blue-200">
                <Shield className="w-4 h-4 mr-1" />
                Super Admin
              </Badge>
            </div>
          </div>
        </div>
      </header>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Stats Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
          <Card>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">Commerces Total</CardTitle>
              <Store className="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stats.totalCommerces}</div>
              <p className="text-xs text-muted-foreground">
                {stats.activeCommerces} actifs
              </p>
            </CardContent>
          </Card>

          <Card>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">Commandes</CardTitle>
              <BarChart3 className="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stats.totalOrders.toLocaleString()}</div>
              <p className="text-xs text-muted-foreground">
                Ce mois
              </p>
            </CardContent>
          </Card>

          <Card>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">Revenus</CardTitle>
              <CreditCard className="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{formatCurrency(stats.totalRevenue)}</div>
              <p className="text-xs text-muted-foreground">
                Commission 1-5%
              </p>
            </CardContent>
          </Card>

          <Card>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">Utilisateurs</CardTitle>
              <Users className="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stats.totalUsers}</div>
              <p className="text-xs text-muted-foreground">
                Tous rôles confondus
              </p>
            </CardContent>
          </Card>

          <Card>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">QR Codes</CardTitle>
              <QrCode className="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">2,847</div>
              <p className="text-xs text-muted-foreground">
                Générés ce mois
              </p>
            </CardContent>
          </Card>
        </div>

        {/* Main Content */}
        <Tabs defaultValue="commerces" className="space-y-6">
          <TabsList className="grid w-full grid-cols-6">
            <TabsTrigger value="commerces">Commerces</TabsTrigger>
            <TabsTrigger value="branding">White Label</TabsTrigger>
            <TabsTrigger value="payments">Paiements</TabsTrigger>
            <TabsTrigger value="qr-codes">QR Codes</TabsTrigger>
            <TabsTrigger value="automations">Automatisations</TabsTrigger>
            <TabsTrigger value="settings">Paramètres</TabsTrigger>
          </TabsList>

          {/* Commerces Tab */}
          <TabsContent value="commerces" className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle>Gestion des Commerces</CardTitle>
                <CardDescription>
                  Gérez tous les commerces de la plateforme
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-4">
                  {commerces.map((commerce) => (
                    <div key={commerce.id} className="flex items-center justify-between p-4 border rounded-lg">
                      <div className="flex items-center space-x-4">
                        <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                          <Store className="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                          <h3 className="font-semibold">{commerce.name}</h3>
                          <p className="text-sm text-gray-600">
                            {commerce.type} • Tenant: {commerce.tenantId}
                          </p>
                          <p className="text-xs text-gray-500">
                            Créé le {new Date(commerce.createdAt).toLocaleDateString('fr-FR')}
                          </p>
                        </div>
                      </div>
                      <div className="flex items-center space-x-2">
                        <Badge className={getPlanBadgeColor(commerce.plan)}>
                          {commerce.plan.toUpperCase()}
                        </Badge>
                        <Badge variant="outline" className="bg-green-50 text-green-700 border-green-200">
                          {commerce.status}
                        </Badge>
                        <Button variant="outline" size="sm">
                          Gérer
                        </Button>
                      </div>
                    </div>
                  ))}
                </div>
              </CardContent>
            </Card>
          </TabsContent>

          {/* White Label Tab */}
          <TabsContent value="branding" className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Palette className="w-5 h-5" />
                  <span>Configuration White Label Globale</span>
                </CardTitle>
                <CardDescription>
                  Personnalisez l'apparence globale de la plateforme
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-4">
                    <h3 className="font-semibold">Couleurs</h3>
                    <div className="space-y-3">
                      <div>
                        <Label htmlFor="primary-color">Couleur Primaire</Label>
                        <Input id="primary-color" type="color" defaultValue="#3B82F6" />
                      </div>
                      <div>
                        <Label htmlFor="secondary-color">Couleur Secondaire</Label>
                        <Input id="secondary-color" type="color" defaultValue="#6B7280" />
                      </div>
                      <div>
                        <Label htmlFor="accent-color">Couleur Accent</Label>
                        <Input id="accent-color" type="color" defaultValue="#F59E0B" />
                      </div>
                    </div>
                  </div>

                  <div className="space-y-4">
                    <h3 className="font-semibold">Textes</h3>
                    <div className="space-y-3">
                      <div>
                        <Label htmlFor="platform-name">Nom de la Plateforme</Label>
                        <Input id="platform-name" defaultValue="RestoConnect360" />
                      </div>
                      <div>
                        <Label htmlFor="tagline">Slogan</Label>
                        <Input id="tagline" defaultValue="Plateforme Multi-Commerces Horeca/CHR" />
                      </div>
                      <div>
                        <Label htmlFor="footer">Texte Footer</Label>
                        <Input id="footer" defaultValue="© 2025 RestoConnect360 - Zone UEMOA" />
                      </div>
                    </div>
                  </div>
                </div>

                <div className="flex justify-end">
                  <Button className="bg-blue-600 hover:bg-blue-700">
                    <Palette className="w-4 h-4 mr-2" />
                    Sauvegarder la Configuration
                  </Button>
                </div>
              </CardContent>
            </Card>
          </TabsContent>

          {/* Payments Tab */}
          <TabsContent value="payments" className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <CreditCard className="w-5 h-5" />
                  <span>Gestion des Paiements</span>
                </CardTitle>
                <CardDescription>
                  Configurez les intégrations de paiement et la délégation de collecte
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <Card>
                    <CardHeader>
                      <CardTitle className="text-lg">CinetPay</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <Badge className="bg-green-100 text-green-800">Actif</Badge>
                      <p className="text-sm text-gray-600 mt-2">
                        Intégration complète pour l'Afrique de l'Ouest
                      </p>
                    </CardContent>
                  </Card>

                  <Card>
                    <CardHeader>
                      <CardTitle className="text-lg">PayTech</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <Badge className="bg-green-100 text-green-800">Actif</Badge>
                      <p className="text-sm text-gray-600 mt-2">
                        Solution sénégalaise de paiement
                      </p>
                    </CardContent>
                  </Card>

                  <Card>
                    <CardHeader>
                      <CardTitle className="text-lg">Wave</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <Badge className="bg-green-100 text-green-800">Actif</Badge>
                      <p className="text-sm text-gray-600 mt-2">
                        Mobile money populaire
                      </p>
                    </CardContent>
                  </Card>
                </div>

                <Card>
                  <CardHeader>
                    <CardTitle>Délégation de Collecte</CardTitle>
                    <CardDescription>
                      Commission automatique pour les commerces sans intégration directe
                    </CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-4">
                      <div className="flex items-center justify-between">
                        <span>Commerces avec délégation</span>
                        <Badge variant="outline">23 commerces</Badge>
                      </div>
                      <div className="flex items-center justify-between">
                        <span>Taux de commission moyen</span>
                        <Badge variant="outline">3.5%</Badge>
                      </div>
                      <div className="flex items-center justify-between">
                        <span>Montant délégué ce mois</span>
                        <Badge variant="outline">{formatCurrency(1234567)}</Badge>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </CardContent>
            </Card>
          </TabsContent>

          {/* QR Codes Tab */}
          <TabsContent value="qr-codes" className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <QrCode className="w-5 h-5" />
                  <span>Statistiques QR Codes</span>
                </CardTitle>
                <CardDescription>
                  Suivi des QR codes générés et scannés
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  <Card>
                    <CardHeader>
                      <CardTitle className="text-lg">QR Menus</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <div className="text-2xl font-bold">1,247</div>
                      <p className="text-sm text-gray-600">Générés</p>
                      <p className="text-sm text-green-600">+12% ce mois</p>
                    </CardContent>
                  </Card>

                  <Card>
                    <CardHeader>
                      <CardTitle className="text-lg">QR Tables</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <div className="text-2xl font-bold">892</div>
                      <p className="text-sm text-gray-600">Actives</p>
                      <p className="text-sm text-green-600">+8% ce mois</p>
                    </CardContent>
                  </Card>

                  <Card>
                    <CardHeader>
                      <CardTitle className="text-lg">QR Factures</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <div className="text-2xl font-bold">2,847</div>
                      <p className="text-sm text-gray-600">Générées</p>
                      <p className="text-sm text-green-600">+15% ce mois</p>
                    </CardContent>
                  </Card>
                </div>
              </CardContent>
            </Card>
          </TabsContent>

          {/* Automations Tab */}
          <TabsContent value="automations" className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Zap className="w-5 h-5" />
                  <span>Automatisations Actives</span>
                </CardTitle>
                <CardDescription>
                  Gestion des automatisations de la plateforme
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-4">
                  <div className="flex items-center justify-between p-4 border rounded-lg">
                    <div className="flex items-center space-x-3">
                      <Zap className="w-5 h-5 text-blue-600" />
                      <div>
                        <h3 className="font-semibold">Notification Nouvelle Commande</h3>
                        <p className="text-sm text-gray-600">SMS + WhatsApp automatique</p>
                      </div>
                    </div>
                    <Badge className="bg-green-100 text-green-800">Actif</Badge>
                  </div>

                  <div className="flex items-center justify-between p-4 border rounded-lg">
                    <div className="flex items-center space-x-3">
                      <Zap className="w-5 h-5 text-blue-600" />
                      <div>
                        <h3 className="font-semibold">Rappel Paiement</h3>
                        <p className="text-sm text-gray-600">Email automatique après 1h</p>
                      </div>
                    </div>
                    <Badge className="bg-green-100 text-green-800">Actif</Badge>
                  </div>

                  <div className="flex items-center justify-between p-4 border rounded-lg">
                    <div className="flex items-center space-x-3">
                      <Zap className="w-5 h-5 text-blue-600" />
                      <div>
                        <h3 className="font-semibold">Campagne Fidélité</h3>
                        <p className="text-sm text-gray-600">SMS après 5 visites</p>
                      </div>
                    </div>
                    <Badge className="bg-green-100 text-green-800">Actif</Badge>
                  </div>
                </div>
              </CardContent>
            </Card>
          </TabsContent>

          {/* Settings Tab */}
          <TabsContent value="settings" className="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Settings className="w-5 h-5" />
                  <span>Paramètres de la Plateforme</span>
                </CardTitle>
                <CardDescription>
                  Configuration générale de RestoConnect360
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-4">
                    <h3 className="font-semibold">Général</h3>
                    <div className="space-y-3">
                      <div>
                        <Label htmlFor="default-currency">Devise par défaut</Label>
                        <Input id="default-currency" value="XOF (Franc CFA)" disabled />
                      </div>
                      <div>
                        <Label htmlFor="default-language">Langue par défaut</Label>
                        <Input id="default-language" value="Français" disabled />
                      </div>
                      <div>
                        <Label htmlFor="timezone">Fuseau horaire</Label>
                        <Input id="timezone" value="Africa/Dakar" disabled />
                      </div>
                    </div>
                  </div>

                  <div className="space-y-4">
                    <h3 className="font-semibold">Fonctionnalités</h3>
                    <div className="space-y-3">
                      <div className="flex items-center justify-between">
                        <span>Multi-tenancy</span>
                        <Badge className="bg-green-100 text-green-800">Activé</Badge>
                      </div>
                      <div className="flex items-center justify-between">
                        <span>White Label</span>
                        <Badge className="bg-green-100 text-green-800">Activé</Badge>
                      </div>
                      <div className="flex items-center justify-between">
                        <span>QR Codes</span>
                        <Badge className="bg-green-100 text-green-800">Activé</Badge>
                      </div>
                      <div className="flex items-center justify-between">
                        <span>Délégation Collecte</span>
                        <Badge className="bg-green-100 text-green-800">Activé</Badge>
                      </div>
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>
          </TabsContent>
        </Tabs>
      </div>
    </div>
  );
}
