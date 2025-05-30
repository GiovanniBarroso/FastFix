<template>
  <footer class="bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 text-gray-100 pt-14 pb-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-12 border-b border-gray-800 pb-10">
      <!-- Marca y descripción -->
      <div class="space-y-3" data-aos="fade-up">
        <div class="flex items-center gap-3">
          <img src="/logoFastFix.png" alt="FastFix logo" class="w-10 h-10 rounded-full shadow-lg" />
          <h2 class="text-3xl font-black bg-gradient-to-r from-red-500 to-yellow-400 text-transparent bg-clip-text tracking-tight">
            FastFix
          </h2>
        </div>
        <p class="text-sm text-gray-400 leading-relaxed">
          Servicio técnico profesional para móviles, ordenadores y consolas. <br />
          Atención cercana, resultados rápidos.
        </p>
      </div>

      <!-- Navegación -->
      <div class="space-y-3" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-lg font-semibold text-white">Navegación</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li><router-link to="/about" class="hover:text-red-400 transition">Sobre nosotros</router-link></li>
          <li><router-link to="/contact" class="hover:text-red-400 transition">Contacto</router-link></li>
          <li><button @click="showTermsModal = true" class="hover:text-red-400 transition">Términos y condiciones</button></li>
          <li><button @click="showPrivacyModal = true" class="hover:text-red-400 transition">Política de privacidad</button></li>
        </ul>
      </div>

      <!-- Servicios destacados -->
      <div class="space-y-3" data-aos="fade-up" data-aos-delay="200">
        <h3 class="text-lg font-semibold text-white">Servicios</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li>Reparación de smartphones</li>
          <li>Reparación de portátiles</li>
          <li>Servicio a domicilio</li>
          <li>Venta de accesorios</li>
        </ul>
      </div>

      <!-- Redes sociales -->
      <div class="space-y-4" data-aos="fade-up" data-aos-delay="300">
        <h3 class="text-lg font-semibold text-white">¡Conéctate!</h3>
        <p class="text-sm text-gray-400">Síguenos en redes para ofertas, tips y novedades.</p>
        <div class="flex gap-4">
          <a
            href="https://facebook.com"
            target="_blank"
            aria-label="Facebook"
            class="bg-gray-800 hover:bg-blue-600 p-3 rounded-full transition duration-300 hover:scale-110"
          >
            <img src="/icons/facebook.webp" alt="Facebook" class="w-5 h-5" />
          </a>
          <a
            href="https://twitter.com"
            target="_blank"
            aria-label="Twitter"
            class="bg-gray-800 hover:bg-sky-500 p-3 rounded-full transition duration-300 hover:scale-110"
          >
            <img src="/icons/twitter.png" alt="Twitter" class="w-5 h-5" />
          </a>
          <a
            href="https://instagram.com"
            target="_blank"
            aria-label="Instagram"
            class="bg-gray-800 hover:bg-pink-500 p-3 rounded-full transition duration-300 hover:scale-110"
          >
            <img src="/icons/instagram.png" alt="Instagram" class="w-5 h-5" />
          </a>
        </div>
      </div>
    </div>

    <!-- Footer inferior -->
    <div class="text-center text-xs text-gray-500 pt-6 border-t border-gray-800 mt-10 animate-fade-in">
      © {{ currentYear }} FastFix. Todos los derechos reservados.
    </div>

    <!-- Modales -->
    <TermsModal :show="showTermsModal" @close="showTermsModal = false" />
    <PrivacyModal :show="showPrivacyModal" @close="showPrivacyModal = false" />
  </footer>
</template>

<script setup>
import { ref } from 'vue'
import TermsModal from '@/components/modals/TermsModal.vue'
import PrivacyModal from '@/components/modals/PrivacyModal.vue'

const showTermsModal = ref(false)
const showPrivacyModal = ref(false)
const currentYear = new Date().getFullYear()
</script>