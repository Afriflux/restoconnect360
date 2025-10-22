<template>
  <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <!-- Brand -->
        <div>
          <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
              <span class="text-white text-2xl font-bold">R</span>
            </div>
            <div>
              <div class="text-xl font-bold">RestoConnect360</div>
              <div class="text-xs text-gray-400">Votre partenaire digital</div>
            </div>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed mb-6">
            La solution complète pour tous vos établissements : restaurants, cafés, bars, boulangeries, food-trucks. POS, livraison GPS, paiements mobiles africains et bien plus.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm4.441 16.892c-2.102.144-6.784.144-8.883 0C5.282 16.736 5.017 15.622 5 12c.017-3.629.285-4.736 2.558-4.892 2.099-.144 6.782-.144 8.883 0C18.718 7.264 18.982 8.378 19 12c-.018 3.629-.285 4.736-2.559 4.892zM10 9.658l4.917 2.338L10 14.342V9.658z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Solutions -->
        <div>
          <h3 class="text-lg font-bold mb-6">Solutions</h3>
          <ul class="space-y-3">
            <li><router-link to="/pos" class="text-gray-400 hover:text-green-400 transition-colors">POS Multi-Support</router-link></li>
            <li><router-link to="/kiosk" class="text-gray-400 hover:text-green-400 transition-colors">Kiosque Digital</router-link></li>
            <li><router-link to="/driver" class="text-gray-400 hover:text-green-400 transition-colors">Livraison GPS</router-link></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Paiements Mobiles</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">WhatsApp Business</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Analytics</a></li>
          </ul>
        </div>

        <!-- Entreprise -->
        <div>
          <h3 class="text-lg font-bold mb-6">Entreprise</h3>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">À propos</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Tarifs</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Blog</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Carrières</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Partenaires</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Affiliés</a></li>
          </ul>
        </div>

        <!-- Support -->
        <div>
          <h3 class="text-lg font-bold mb-6">Support</h3>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Centre d'aide</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Documentation</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">API</a></li>
            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Statut</a></li>
            <li>
              <a href="mailto:contact@restoconnect360.com" class="text-gray-400 hover:text-green-400 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact
              </a>
            </li>
            <li>
              <a href="tel:+221781000064" class="text-gray-400 hover:text-green-400 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                +221 78 100 00 64
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="md:flex md:justify-between md:items-center">
          <div class="text-center md:text-left">
            <p class="text-gray-400 text-sm">
              © 2025 <span class="text-green-400 font-semibold">RestoConnect360</span>. Tous droits réservés.
            </p>
          </div>
          <div class="mt-4 md:mt-0 flex justify-center md:justify-end space-x-6">
            <a href="#" class="text-gray-400 hover:text-green-400 text-sm transition-colors">Confidentialité</a>
            <a href="#" class="text-gray-400 hover:text-green-400 text-sm transition-colors">Conditions</a>
            <a href="#" class="text-gray-400 hover:text-green-400 text-sm transition-colors">Cookies</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
</script>

