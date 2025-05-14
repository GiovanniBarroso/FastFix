<template>
  <footer class="bg-gray-900 text-gray-100 mt-16">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 sm:grid-cols-3 gap-10">

      <!-- Marca -->
      <div>
        <h2 class="text-3xl font-extrabold text-red-500 mb-4">FastFix</h2>
        <p class="text-sm text-gray-300 leading-relaxed">
          Reparación de dispositivos electrónicos con profesionalismo y garantía.
          <br />
          Servicio rápido, seguro y transparente.
        </p>
      </div>

      <!-- Enlaces -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Enlaces rápidos</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li><router-link to="/about" class="hover:text-red-400 transition">Sobre nosotros</router-link></li>
          <li><router-link to="/contact" class="hover:text-red-400 transition">Contacto</router-link></li>
          <li><router-link to="/terms" class="hover:text-red-400 transition">Términos y condiciones</router-link></li>
          <li><router-link to="/privacy" class="hover:text-red-400 transition">Política de privacidad</router-link></li>
        </ul>
      </div>

      <!-- Redes sociales -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Síguenos</h3>
        <div class="flex items-center gap-4">
          <!-- Facebook -->
          <a href="https://facebook.com" target="_blank" aria-label="Facebook"
            class="bg-gray-700 hover:bg-blue-600 p-2 rounded-full transition">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.408.593 24 1.325 24H12.82V14.706h-3.442v-3.622h3.442V8.413c0-3.404 2.07-5.252 5.096-5.252 1.45 0 2.698.108 3.062.156v3.55l-2.103.001c-1.65 0-1.97.785-1.97 1.935v2.536h3.94l-.513 3.622h-3.427V24h6.719C23.406 24 24 23.408 24 22.674V1.326C24 .593 23.406 0 22.675 0z" />
            </svg>
          </a>

          <!-- Twitter -->
          <a href="https://twitter.com" target="_blank" aria-label="Twitter"
            class="bg-gray-700 hover:bg-sky-500 p-2 rounded-full transition">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M24 4.557a9.83 9.83 0 01-2.828.775 4.932 4.932 0 002.165-2.723c-.951.566-2.005.974-3.127 1.195a4.916 4.916 0 00-8.384 4.482A13.942 13.942 0 011.671 3.149a4.918 4.918 0 001.523 6.573 4.902 4.902 0 01-2.229-.616v.06a4.916 4.916 0 003.946 4.827 4.996 4.996 0 01-2.224.084 4.923 4.923 0 004.6 3.417A9.867 9.867 0 010 19.54a13.94 13.94 0 007.548 2.212c9.057 0 14.01-7.513 14.01-14.01 0-.213-.005-.425-.014-.636A10.025 10.025 0 0024 4.557z" />
            </svg>
          </a>

          <!-- Instagram -->
          <a href="https://instagram.com" target="_blank" aria-label="Instagram"
            class="bg-gray-700 hover:bg-pink-500 p-2 rounded-full transition">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.344 3.608 1.32.976.975 1.258 2.242 1.32 3.608.058 1.266.07 1.646.07 4.84s-.012 3.574-.07 4.84c-.062 1.366-.344 2.633-1.32 3.608-.975.976-2.242 1.258-3.608 1.32-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.344-3.608-1.32-.976-.975-1.258-2.242-1.32-3.608C2.175 15.574 2.163 15.194 2.163 12s.012-3.574.07-4.84c.062-1.366.344-2.633 1.32-3.608C4.528 2.577 5.795 2.295 7.161 2.233 8.427 2.175 8.807 2.163 12 2.163zm0-2.163C8.737 0 8.332.012 7.052.07 5.721.128 4.519.348 3.447 1.42c-1.072 1.072-1.292 2.274-1.35 3.605C2.012 6.747 2 7.152 2 12s.012 5.253.07 6.573c.058 1.331.278 2.533 1.35 3.605 1.072 1.072 2.274 1.292 3.605 1.35C8.747 23.988 9.152 24 12 24s3.253-.012 4.573-.07c1.331-.058 2.533-.278 3.605-1.35 1.072-1.072 1.292-2.274 1.35-3.605.058-1.32.07-1.725.07-6.573s-.012-5.253-.07-6.573c-.058-1.331-.278-2.533-1.35-3.605C19.106.348 17.904.128 16.573.07 15.253.012 14.848 0 12 0zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998zm6.406-11.845a1.44 1.44 0 11-2.881 0 1.44 1.44 0 012.881 0z" />
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Footer bottom -->
    <div class="text-center text-xs text-gray-400 py-4 border-t border-gray-800">
      © {{ currentYear }} FastFix. Todos los derechos reservados.
    </div>
  </footer>
</template>

<script setup>
const currentYear = new Date().getFullYear()
</script>
