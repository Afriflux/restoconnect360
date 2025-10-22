'use client';

export default function HomePage() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
      {/* Header */}
      <header className="bg-white/80 backdrop-blur-sm border-b sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center py-4">
            <div className="flex items-center space-x-3">
              <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
              </div>
              <div>
                <h1 className="text-xl font-bold text-gray-900">RestoConnect360</h1>
                <p className="text-sm text-gray-600">Zone UEMOA</p>
              </div>
            </div>
            <div className="flex items-center space-x-4">
              <div className="restoconnect-badge restoconnect-badge-green">
                <span className="mr-1">✓</span>
                Franc CFA (XOF)
              </div>
              <button className="restoconnect-button">
                Commencer Gratuitement
              </button>
            </div>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <div className="max-w-4xl mx-auto">
            <div className="restoconnect-badge restoconnect-badge-blue mb-4">
              🚀 Plateforme Multi-Commerces Horeca/CHR
            </div>
            <h1 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6 restoconnect-animate">
              RestoConnect360
            </h1>
            <p className="text-xl text-gray-600 mb-8 leading-relaxed restoconnect-animate">
              La plateforme complète pour tous les commerces de la restauration en Afrique de l'Ouest.
              <br />
              <span className="font-semibold text-blue-600">100% Digital • Paiements Africains • QR Codes Universels</span>
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center restoconnect-animate">
              <button className="restoconnect-button text-lg px-8 py-4">
                🏪 Créer Mon Commerce
              </button>
              <button className="restoconnect-button-secondary text-lg px-8 py-4">
                📊 Voir la Démo
              </button>
            </div>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div className="text-center">
              <div className="text-2xl mb-2">🌍</div>
              <div className="text-3xl font-bold text-gray-900 mb-1">8</div>
              <div className="text-sm text-gray-600">Pays UEMOA</div>
            </div>
            <div className="text-center">
              <div className="text-2xl mb-2">🏪</div>
              <div className="text-3xl font-bold text-gray-900 mb-1">20+</div>
              <div className="text-sm text-gray-600">Types Commerces</div>
            </div>
            <div className="text-center">
              <div className="text-2xl mb-2">📱</div>
              <div className="text-3xl font-bold text-gray-900 mb-1">100%</div>
              <div className="text-sm text-gray-600">Digital</div>
            </div>
            <div className="text-center">
              <div className="text-2xl mb-2">📱</div>
              <div className="text-3xl font-bold text-gray-900 mb-1">6+</div>
              <div className="text-sm text-gray-600">QR Code Types</div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Fonctionnalités Complètes</h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">Tout ce dont vous avez besoin pour gérer votre commerce de restauration</p>
          </div>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div className="space-y-4">
              <div className="restoconnect-card p-6 cursor-pointer transition-all hover:shadow-lg border-2 border-blue-500">
                <div className="flex items-center space-x-3 mb-4">
                  <div className="text-3xl">🏪</div>
                  <h3 className="font-semibold text-lg">Multi-Commerces Horeca/CHR</h3>
                </div>
                <p className="text-gray-600">Restaurants, cafés, bars, boulangeries, fast-food, food trucks... Tous les commerces de la restauration dans une seule plateforme.</p>
              </div>

              <div className="restoconnect-card p-6 cursor-pointer transition-all hover:shadow-md">
                <div className="flex items-center space-x-3 mb-4">
                  <div className="text-3xl">💳</div>
                  <h3 className="font-semibold text-lg">Paiements Africains</h3>
                </div>
                <p className="text-gray-600">Intégration native avec CinetPay, PayTech et Wave. Délégation de collecte avec commission automatique.</p>
              </div>

              <div className="restoconnect-card p-6 cursor-pointer transition-all hover:shadow-md">
                <div className="flex items-center space-x-3 mb-4">
                  <div className="text-3xl">📱</div>
                  <h3 className="font-semibold text-lg">100% Digital & QR Codes</h3>
                </div>
                <p className="text-gray-600">Factures numériques, QR codes universels pour menus, tables, commandes, factures et fidélité.</p>
              </div>

              <div className="restoconnect-card p-6 cursor-pointer transition-all hover:shadow-md">
                <div className="flex items-center space-x-3 mb-4">
                  <div className="text-3xl">⚡</div>
                  <h3 className="font-semibold text-lg">Automatisations Avancées</h3>
                </div>
                <p className="text-gray-600">Notifications automatiques, campagnes marketing, rappels de paiement et gestion des abonnements.</p>
              </div>
            </div>

            <div className="lg:sticky lg:top-8">
              <div className="restoconnect-card h-fit">
                <div className="p-6">
                  <div className="flex items-center space-x-3 mb-4">
                    <div className="text-blue-600">
                      <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                    </div>
                    <h3 className="text-2xl font-semibold">Multi-Commerces Horeca/CHR</h3>
                  </div>
                  <p className="text-gray-600 mb-6">Restaurants, cafés, bars, boulangeries, fast-food, food trucks... Tous les commerces de la restauration dans une seule plateforme.</p>
                  
                  <ul className="space-y-2">
                    <li className="flex items-center space-x-2">
                      <span className="text-green-500">✓</span>
                      <span className="text-sm">Gestion multi-succursales</span>
                    </li>
                    <li className="flex items-center space-x-2">
                      <span className="text-green-500">✓</span>
                      <span className="text-sm">Templates spécialisés par type</span>
                    </li>
                    <li className="flex items-center space-x-2">
                      <span className="text-green-500">✓</span>
                      <span className="text-sm">Branding personnalisé</span>
                    </li>
                    <li className="flex items-center space-x-2">
                      <span className="text-green-500">✓</span>
                      <span className="text-sm">Analytics par commerce</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Tarifs Transparents</h2>
            <p className="text-xl text-gray-600">Choisissez le plan qui correspond à votre commerce</p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {/* Starter Plan */}
            <div className="restoconnect-card relative">
              <div className="p-6 text-center">
                <h3 className="text-xl font-semibold mb-4">Starter</h3>
                <div className="mb-4">
                  <span className="text-4xl font-bold text-gray-900">0 XOF</span>
                  <span className="text-gray-600 ml-2">Gratuit</span>
                </div>
                <p className="text-sm text-gray-600 mb-6">Parfait pour débuter</p>
                
                <ul className="space-y-3 text-left mb-6">
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">1 commerce</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">50 commandes/mois</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">QR codes basiques</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">5% commission</span>
                  </li>
                </ul>
                
                <button className="restoconnect-button-secondary w-full">
                  Commencer
                </button>
              </div>
            </div>

            {/* Pro Plan */}
            <div className="restoconnect-card relative border-2 border-blue-500 shadow-lg scale-105">
              <div className="absolute -top-3 left-1/2 transform -translate-x-1/2">
                <div className="restoconnect-badge restoconnect-badge-blue">
                  Plus Populaire
                </div>
              </div>
              <div className="p-6 text-center">
                <h3 className="text-xl font-semibold mb-4">Pro</h3>
                <div className="mb-4">
                  <span className="text-4xl font-bold text-gray-900">15,000 XOF</span>
                  <span className="text-gray-600 ml-2">/mois</span>
                </div>
                <p className="text-sm text-gray-600 mb-6">Pour commerces en croissance</p>
                
                <ul className="space-y-3 text-left mb-6">
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">1 commerce + 2 succursales</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">Commandes illimitées</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">Tous QR codes</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">2% commission</span>
                  </li>
                </ul>
                
                <button className="restoconnect-button w-full">
                  Commencer
                </button>
              </div>
            </div>

            {/* Business Plan */}
            <div className="restoconnect-card relative">
              <div className="p-6 text-center">
                <h3 className="text-xl font-semibold mb-4">Business</h3>
                <div className="mb-4">
                  <span className="text-4xl font-bold text-gray-900">40,000 XOF</span>
                  <span className="text-gray-600 ml-2">/mois</span>
                </div>
                <p className="text-sm text-gray-600 mb-6">Pour entreprises établies</p>
                
                <ul className="space-y-3 text-left mb-6">
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">5 commerces</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">Succursales illimitées</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">White label complet</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">1% commission</span>
                  </li>
                </ul>
                
                <button className="restoconnect-button-secondary w-full">
                  Commencer
                </button>
              </div>
            </div>

            {/* Enterprise Plan */}
            <div className="restoconnect-card relative">
              <div className="p-6 text-center">
                <h3 className="text-xl font-semibold mb-4">Enterprise</h3>
                <div className="mb-4">
                  <span className="text-4xl font-bold text-gray-900">Sur devis</span>
                </div>
                <p className="text-sm text-gray-600 mb-6">Solution sur mesure</p>
                
                <ul className="space-y-3 text-left mb-6">
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">Commerces illimités</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">Infrastructure dédiée</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">SLA 99.99%</span>
                  </li>
                  <li className="flex items-center space-x-2">
                    <svg className="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm">0.5% commission</span>
                  </li>
                </ul>
                
                <button className="restoconnect-button-secondary w-full">
                  Nous Contacter
                </button>
              </div>
            </div>
          </div>
          
          <div className="mt-16 text-center">
            <p className="text-gray-600 mb-4">+ Commission sur transactions : 0.5% à 5% selon le plan</p>
            <p className="text-gray-600">+ Matériel POS/Kiosk : 10,000 XOF/mois ou 150,000 XOF à l'achat</p>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-blue-600">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl font-bold text-white mb-4">Prêt à Digitaliser Votre Commerce ?</h2>
          <p className="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
            Rejoignez les commerces qui ont choisi RestoConnect360 pour leur transformation digitale. Commencez gratuitement dès aujourd'hui !
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <button className="bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4 rounded-lg font-semibold transition-all">
              <svg className="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
              Créer Mon Compte
            </button>
            <button className="border border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-4 rounded-lg font-semibold transition-all">
              <svg className="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              En Savoir Plus
            </button>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-white py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                  <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <span className="text-xl font-bold">RestoConnect360</span>
              </div>
              <p className="text-gray-400">Plateforme Multi-Commerces Horeca/CHR pour la Zone UEMOA</p>
            </div>
            <div>
              <h3 className="font-semibold mb-4">Produit</h3>
              <ul className="space-y-2 text-gray-400">
                <li>Fonctionnalités</li>
                <li>Tarifs</li>
                <li>Intégrations</li>
                <li>API</li>
              </ul>
            </div>
            <div>
              <h3 className="font-semibold mb-4">Support</h3>
              <ul className="space-y-2 text-gray-400">
                <li>Documentation</li>
                <li>Centre d'aide</li>
                <li>Contact</li>
                <li>Status</li>
              </ul>
            </div>
            <div>
              <h3 className="font-semibold mb-4">Entreprise</h3>
              <ul className="space-y-2 text-gray-400">
                <li>À propos</li>
                <li>Carrières</li>
                <li>Blog</li>
                <li>Partenaires</li>
              </ul>
            </div>
          </div>
          <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>© 2025 RestoConnect360 - Zone UEMOA. Tous droits réservés.</p>
          </div>
        </div>
      </footer>
    </div>
  );
}