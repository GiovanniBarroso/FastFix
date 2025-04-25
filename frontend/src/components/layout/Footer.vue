<template>
  <footer class="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8">
      
      <!-- Marca -->
      <div>
        <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-2">FastFix</h2>
        <p class="text-sm">
          Reparaciones profesionales de dispositivos electrónicos.  
          Calidad, garantía y confianza en cada arreglo.
        </p>
      </div>

      <!-- Enlaces útiles -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Enlaces</h3>
        <ul class="space-y-1 text-sm">
          <li><router-link to="/about" class="hover:underline">Sobre nosotros</router-link></li>
          <li><router-link to="/contact" class="hover:underline">Contacto</router-link></li>
          <li><router-link to="/terms" class="hover:underline">Términos y condiciones</router-link></li>
          <li><router-link to="/privacy" class="hover:underline">Política de privacidad</router-link></li>
        </ul>
      </div>

      <!-- Redes sociales -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Síguenos</h3>
        <div class="flex space-x-4">
          <a href="https://facebook.com" target="_blank" aria-label="Facebook">
            <i class="fab fa-facebook-f hover:text-blue-600"></i>
          </a>
          <a href="https://twitter.com" target="_blank" aria-label="Twitter">
            <i class="fab fa-twitter hover:text-blue-400"></i>
          </a>
          <a href="https://instagram.com" target="_blank" aria-label="Instagram">
            <i class="fab fa-instagram hover:text-pink-500"></i>
          </a>
        </div>
      </div>

    </div>

    <!-- Copyright -->
    <div class="text-center text-xs py-4 border-t border-gray-300 dark:border-gray-700">
      © {{ currentYear }} FastFix. Todos los derechos reservados.
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue'
const currentYear = new Date().getFullYear()
</script>

<style scoped>
i {
  font-size: 1.2rem;
  transition: color 0.3s;
}
</style>
