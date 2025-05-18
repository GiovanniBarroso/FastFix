<template>


  <!-- Hero -->
  <section
    class=" text-center py-24 px-6 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 animate-fade">
    <h1 class="text-white text-5xl sm:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
      Bienvenido a <span class="text-red-500 dark:text-red-400">FastFix</span>
    </h1>
    <p class="text-xl sm:text-2xl max-w-2xl mx-auto mb-10 text-gray-700 dark:text-gray-300">
      Reparaciones profesionales con calidad, rapidez y garantía de excelencia.
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <router-link to="/products"
        class="inline-block bg-red-600 hover:bg-red-700 text-white text-lg font-semibold px-8 py-4 rounded-full transition-transform transform hover:scale-105 shadow-lg">
        Ver productos
      </router-link>
      <template v-if="auth.isAuthenticated()">
        <router-link :to="auth.isAdmin() ? '/admin' : '/home'" :class="[
          'inline-block text-white text-lg font-semibold px-8 py-4 rounded-full transition-transform transform hover:scale-105 shadow-lg',
          auth.isAdmin()
            ? 'bg-yellow-500 hover:bg-yellow-600'
            : 'bg-blue-600 hover:bg-blue-700'
        ]">
          {{ auth.isAdmin() ? 'Ir al panel de admin' : 'Ir al panel de usuario' }}
        </router-link>
      </template>

    </div>
  </section>


  <!-- ¿Qué reparamos? -->
  <section class="py-20 bg-gray-100 dark:bg-gray-800">
    <div class="text-center mb-16 animate-fade-up">
      <h2 class="text-4xl font-bold mb-4">¿Qué reparamos?</h2>
      <p class="text-lg text-gray-600 dark:text-gray-300">Expertos en una amplia variedad de dispositivos</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 px-8">
      <div v-for="(item, i) in reparaciones" :key="i"
        class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-center animate-fade-up">
        <div class="text-5xl mb-4">{{ item.icono }}</div>
        <h3 class="text-xl font-semibold">{{ item.titulo }}</h3>
      </div>
    </div>
  </section>

  <!-- ¿Por qué elegirnos? -->
  <section class="py-20 bg-white dark:bg-gray-900">
    <div class="text-center mb-16 animate-fade-up">
      <h2 class="text-4xl font-bold mb-4">¿Por qué elegirnos?</h2>
      <p class="text-lg text-gray-600 dark:text-gray-300">Tu tranquilidad es nuestro compromiso</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 px-8">
      <div v-for="(item, i) in razones" :key="i"
        class="bg-gray-100 dark:bg-gray-800 p-8 rounded-xl border border-gray-200 dark:border-gray-700 text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl animate-fade-up">
        <div class="text-5xl mb-4">{{ item.icono }}</div>
        <h3 class="text-xl font-semibold">{{ item.titulo }}</h3>
        <p class="text-sm mt-2 text-gray-600 dark:text-gray-400">{{ item.descripcion }}</p>
      </div>
    </div>
  </section>

  <!-- Testimonios -->
  <section class="py-20 bg-gray-100 dark:bg-gray-800">
    <div class="text-center mb-16 animate-fade-up">
      <h2 class="text-4xl font-bold mb-4">Opiniones reales</h2>
      <p class="text-lg text-gray-600 dark:text-gray-300">Nuestros clientes hablan por nosotros</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 px-6">
      <div v-for="(testimonio, i) in testimonios" :key="i"
        class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow text-sm transition duration-300 transform hover:scale-105 animate-fade-up">
        <p class="mb-4">“{{ testimonio.texto }}”</p>
        <div class="font-semibold text-red-600">{{ testimonio.nombre }}</div>
        <div class="text-gray-500 dark:text-gray-400 text-xs">{{ testimonio.rol }}</div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-20 bg-gray-200 dark:bg-gray-800 text-center px-6 animate-fade-up">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-3xl font-bold mb-4">¿Necesitas reparar tu dispositivo?</h2>
      <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
        Solicita presupuesto sin compromiso y recibe atención personalizada hoy mismo. </p>
      <router-link to="/budget"
        class="inline-block bg-red-600 hover:bg-red-700 text-white text-base font-medium px-6 py-3 rounded-md transition transform hover:scale-105 shadow">
        Solicitar presupuesto
      </router-link>
    </div>
  </section>
</template>

<script setup>

import { useAuthStore } from '@/stores/authStore'

const auth = useAuthStore()

const reparaciones = [
  { icono: '📱', titulo: 'Móviles' },
  { icono: '💻', titulo: 'Ordenadores' },
  { icono: '🎮', titulo: 'Consolas' },
  { icono: '📱', titulo: 'Tablets' }
]

const razones = [
  { icono: '⚡', titulo: 'Servicio rápido', descripcion: 'Solucionamos averías en tiempo récord.' },
  { icono: '✅', titulo: 'Garantía 100%', descripcion: 'Confianza y respaldo en cada reparación.' },
  { icono: '💬', titulo: 'Soporte humano', descripcion: 'Atención clara y cercana, sin rodeos.' }
]

const testimonios = [
  { texto: 'Me salvaron el portátil en menos de 48h. Profesionales y muy amables.', nombre: 'Paco Jones', rol: 'Cliente verificado' },
  { texto: 'Poder seguir el estado de la reparación desde casa es genial para saber todo su proceso.', nombre: 'Lucho Portuano', rol: 'Cliente frecuente' },
  { texto: 'Muy buen trato y precios justos. Todo lo que buscaba. Recomiendo totalmente.', nombre: 'Débora Melontero', rol: 'Primera vez' }
]
</script>

<style scoped>
@keyframes fade-up {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }

  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fade {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

.animate-fade-up {
  animation: fade-up 0.8s ease-out both;
}

.animate-fade {
  animation: fade 0.6s ease-in-out both;
}
</style>
