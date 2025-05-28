<template>
  <div class=" bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- HERO SECTION -->
    <section
      class="relative py-32 px-6 text-center overflow-hidden bg-gradient-to-tr from-gray-900 to-gray-700 text-white shadow-2xl animate-fade">
      <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-6xl font-extrabold leading-tight tracking-tight">
          <span class="block mb-4">Bienvenido a</span>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-400">FastFix</span>
        </h1>
        <p class="text-2xl mt-6 text-gray-300">
          Reparaciones profesionales con calidad, rapidez y garantía de excelencia.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-5">
          <router-link
            to="/products"
            class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white text-lg font-bold rounded-full transition duration-300 transform hover:scale-105 shadow-xl"
          >
            Ver productos
          </router-link>
          <template v-if="auth.isAuthenticated()">
            <router-link
              :to="auth.isAdmin() ? '/admin' : '/user-panel'"
              :class="[
                'px-8 py-4 text-white text-lg font-bold rounded-full transition duration-300 transform hover:scale-105 shadow-xl',
                auth.isAdmin() ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700'
              ]"
            >
              {{ auth.isAdmin() ? 'Ir al panel de admin' : 'Ir al panel de usuario' }}
            </router-link>
          </template>
        </div>
      </div>
      <div class="absolute inset-0 opacity-10 bg-[url('/images/bg-circuit.svg')] bg-cover bg-center"></div>
    </section>

    <!-- ¿QUÉ REPARAMOS? -->
    <section class="py-20 bg-gradient-to-t from-gray-100 via-white to-gray-100 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800">
      <div class="text-center mb-16 animate-fade-up">
        <h2 class="text-4xl font-bold mb-4">¿Qué reparamos?</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Expertos en una amplia variedad de dispositivos</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 px-8">
        <div v-for="(item, i) in reparaciones" :key="i"
          class="group bg-white/80 dark:bg-white/10 backdrop-blur-md border border-gray-200 dark:border-gray-600 p-8 rounded-3xl shadow-2xl text-center transition-transform transform hover:-translate-y-2 hover:scale-105 duration-300 animate-fade-up">
          <div class="text-6xl mb-4 group-hover:scale-125 transition-transform duration-300">{{ item.icono }}</div>
          <h3 class="text-xl font-semibold group-hover:text-red-500">{{ item.titulo }}</h3>
        </div>
      </div>
    </section>

    <!-- ¿POR QUÉ ELEGIRNOS? -->
    <section class="py-20 bg-white dark:bg-gray-900">
      <div class="text-center mb-16 animate-fade-up">
        <h2 class="text-4xl font-bold mb-4">¿Por qué elegirnos?</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Tu tranquilidad es nuestro compromiso</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 px-8">
        <div v-for="(item, i) in razones" :key="i"
          class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 text-center shadow-2xl transition-all duration-300 transform hover:scale-105 animate-fade-up">
          <div class="text-5xl mb-4">{{ item.icono }}</div>
          <h3 class="text-2xl font-bold text-red-500">{{ item.titulo }}</h3>
          <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ item.descripcion }}</p>
        </div>
      </div>
    </section>

    <!-- TESTIMONIOS -->
    <section class="py-20 bg-gray-100 dark:bg-gray-800">
      <div class="text-center mb-16 animate-fade-up">
        <h2 class="text-4xl font-bold mb-4">Opiniones reales</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Nuestros clientes hablan por nosotros</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
        <div v-for="(testimonio, i) in testimonios" :key="i"
          class="relative bg-white dark:bg-gray-700 p-6 rounded-3xl shadow-xl text-sm hover:shadow-2xl transform hover:scale-[1.03] transition duration-300 animate-fade-up">
          <svg class="absolute -top-5 -left-5 w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7.17 6A5.001 5.001 0 002 11v5a1 1 0 001 1h5a1 1 0 001-1v-5a5.001 5.001 0 00-1.83-3.89zM16.83 6A5.001 5.001 0 0011 11v5a1 1 0 001 1h5a1 1 0 001-1v-5a5.001 5.001 0 00-1.17-3.89z" />
          </svg>
          <p class="mb-4 italic text-gray-800 dark:text-gray-200">“{{ testimonio.texto }}”</p>
          <div class="font-bold text-red-600">{{ testimonio.nombre }}</div>
          <div class="text-gray-500 dark:text-gray-400 text-xs">{{ testimonio.rol }}</div>
        </div>
      </div>
    </section>

    <!-- CTA FINAL -->
    <section class="py-24 bg-gradient-to-br from-red-600 to-red-500 text-white text-center px-6 animate-fade-up">
      <div class="max-w-3xl mx-auto">
        <h2 class="text-4xl font-black mb-4">¿Necesitas reparar tu dispositivo?</h2>
        <p class="text-lg mb-8">
          Solicita presupuesto sin compromiso y recibe atención personalizada hoy mismo.
        </p>
        <router-link to="/budget"
          class="inline-block bg-white text-red-600 hover:bg-gray-100 text-base font-semibold px-6 py-3 rounded-full transition transform hover:scale-105 shadow-lg">
          Solicitar presupuesto
        </router-link>
      </div>
    </section>

  </div>
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