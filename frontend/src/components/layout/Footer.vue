<template>
  <footer class="bg-background text-foreground mt-10 border-t border-border">
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8">

      <!-- Marca -->
      <div>
        <h2 class="text-2xl font-bold text-[var(--color-red-600)] mb-4">FastFix</h2>
        <p class="text-sm">
          Reparaciones profesionales de dispositivos electrónicos.<br />
          Calidad, garantía y confianza en cada arreglo.
        </p>
      </div>

      <!-- Enlaces útiles -->
      <div>
        <h3 class="text-lg font-semibold mb-4">Enlaces</h3>
        <ul class="space-y-2 text-sm">
          <li><router-link to="/about" class="hover:text-[var(--color-red-500)] transition">Sobre nosotros</router-link>
          </li>
          <li><router-link to="/contact" class="hover:text-[var(--color-red-500)] transition">Contacto</router-link>
          </li>
          <li><router-link to="/terms" class="hover:text-[var(--color-red-500)] transition">Términos y
              condiciones</router-link></li>
          <li><router-link to="/privacy" class="hover:text-[var(--color-red-500)] transition">Política de
              privacidad</router-link></li>
        </ul>
      </div>

      <!-- Redes sociales -->
      <div>
        <h3 class="text-lg font-semibold mb-4">Síguenos</h3>
        <div class="flex items-center space-x-4">
          <a href="https://facebook.com" target="_blank" aria-label="Facebook"
            class="text-foreground hover:text-[var(--color-blue-500)] transition">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://twitter.com" target="_blank" aria-label="Twitter"
            class="text-foreground hover:text-[var(--color-sky-400)] transition">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="https://instagram.com" target="_blank" aria-label="Instagram"
            class="text-foreground hover:text-[var(--color-pink-500)] transition">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </div>

    </div>

    <!-- Copyright -->
    <div class="text-center text-xs py-4 border-t border-border">
      © {{ currentYear }} FastFix. Todos los derechos reservados.
    </div>
  </footer>
</template>

<script setup>
const currentYear = new Date().getFullYear()
</script>

<style scoped>
i {
  font-size: 1.2rem;
  transition: color 0.3s;
}
</style>
