<template>
  <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <!-- HERO SECTION -->
    <section
      class="relative py-32 px-6 text-center overflow-hidden bg-gradient-to-tr from-gray-950 to-gray-800 text-white shadow-2xl"
      data-aos="fade"
    >
      <div class="relative z-10 max-w-5xl mx-auto space-y-6">
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-tight tracking-tight">
          <span class="block">Bienvenido a</span>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 drop-shadow-md">FastFix</span>
        </h1>
        <p class="text-xl sm:text-2xl text-gray-300 max-w-3xl mx-auto">
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
                auth.isAdmin() ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700',
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
    <section class="py-24 bg-gradient-to-t from-gray-100 via-white to-gray-100 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800">
      <div class="text-center mb-20" data-aos="fade-up">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-500 leading-tight sm:leading-[1.2]">
          ¿Qué reparamos?
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">Expertos en una amplia variedad de dispositivos</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 px-8">
        <div
          v-for="(item, i) in reparaciones"
          :key="i"
          class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 p-8 rounded-3xl shadow-2xl text-center hover:shadow-[0_0_20px_rgba(56,189,248,0.4)] hover:-translate-y-1 transition-all duration-300"
          data-aos="zoom-in-up"
        >
          <div class="text-6xl mb-4 group-hover:scale-125 transition-transform duration-300">{{ item.icono }}</div>
          <h3 class="text-xl font-semibold text-gray-800 dark:text-white group-hover:text-sky-400">{{ item.titulo }}</h3>
        </div>
      </div>
    </section>

    <!-- ¿POR QUÉ ELEGIRNOS? -->
    <section class="py-24 bg-white dark:bg-gray-900">
      <div class="text-center mb-20" data-aos="fade-up">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-500 leading-tight sm:leading-[1.2]">
          ¿Por qué elegirnos?
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">Tu tranquilidad es nuestro compromiso</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 px-8">
        <div
          v-for="(item, i) in razones"
          :key="i"
          class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 p-8 rounded-3xl shadow-2xl text-center hover:shadow-[0_0_20px_rgba(239,68,68,0.4)] hover:-translate-y-1 transition-all duration-300"
          data-aos="fade-up"
          :data-aos-delay="i * 100"
        >
          <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">{{ item.icono }}</div>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ item.titulo }}</h3>
          <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ item.descripcion }}</p>
        </div>
      </div>
    </section>

    <!-- TESTIMONIOS -->
    <section class="py-24 bg-gray-100 dark:bg-gray-800">
      <div class="text-center mb-20" data-aos="fade-up">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-500 leading-tight sm:leading-[1.2]">
          Opiniones reales
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">Nuestros clientes hablan por nosotros</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
        <div
          v-for="(testimonio, i) in testimonios"
          :key="i"
          class="relative bg-white dark:bg-gray-700 p-6 rounded-3xl shadow-xl text-sm hover:shadow-2xl transform hover:scale-[1.03] transition duration-300"
          data-aos="zoom-in"
          :data-aos-delay="i * 150"
        >
          <svg class="absolute -top-5 -left-5 w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7.17 6A5.001 5.001 0 002 11v5a1 1 0 001 1h5a1 1 0 001-1v-5a5.001 5.001 0 00-1.83-3.89zM16.83 6A5.001 5.001 0 0011 11v5a1 1 0 001 1h5a1 1 0 001-1v-5a5.001 5.001 0 00-1.17-3.89z"/>
          </svg>
          <p class="mb-4 italic text-gray-800 dark:text-gray-200">“{{ testimonio.texto }}”</p>
          <div class="font-bold text-red-600">{{ testimonio.nombre }}</div>
          <div class="text-gray-500 dark:text-gray-400 text-xs">{{ testimonio.rol }}</div>
        </div>
      </div>
    </section>

    <!-- CTA FINAL -->
    <section class="py-24 bg-gradient-to-br from-red-600 to-orange-500 text-white text-center px-6" data-aos="fade-up">
      <div class="max-w-3xl mx-auto">
        <h2 class="text-4xl font-black mb-4 drop-shadow">¿Necesitas reparar tu dispositivo?</h2>
        <p class="text-lg mb-8">Solicita presupuesto sin compromiso y recibe atención personalizada hoy mismo.</p>
        <router-link
          to="/budget"
          class="inline-block bg-white text-red-600 hover:bg-gray-100 text-base font-semibold px-6 py-3 rounded-full transition transform hover:scale-105 shadow-lg"
        >
          Solicitar presupuesto
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import AOS from 'aos'
import 'aos/dist/aos.css'
import { useAuthStore } from '@/stores/authStore'

const auth = useAuthStore()

onMounted(() => {
  AOS.init({
    duration: 800,
    once: true,
  })
})

const reparaciones = [
  { icono: '📱', titulo: 'Móviles' },
  { icono: '💻', titulo: 'Ordenadores' },
  { icono: '🎮', titulo: 'Consolas' },
  { icono: '📱', titulo: 'Tablets' },
]

const razones = [
  { icono: '⚡', titulo: 'Servicio rápido', descripcion: 'Solucionamos averías en tiempo récord.' },
  { icono: '✅', titulo: 'Garantía 100%', descripcion: 'Confianza y respaldo en cada reparación.' },
  { icono: '💬', titulo: 'Soporte humano', descripcion: 'Atención clara y cercana, sin rodeos.' },
]

const testimonios = [
  {
    texto: '¡Un servicio excelente! Recuperaron mi móvil en tiempo récord y quedó como nuevo.',
    nombre: 'Álvaro Crespillo',
    rol: 'Cliente satisfecho',
  },
  {
    texto: 'La atención al cliente fue impecable. Me explicaron todo el proceso con claridad.',
    nombre: 'Inés Valverde',
    rol: 'Cliente habitual',
  },
  {
    texto: 'Tenía dudas al principio, pero me sorprendieron gratamente. Volveré sin dudarlo.',
    nombre: 'Raúl Santisteban',
    rol: 'Cliente nuevo',
  },
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
