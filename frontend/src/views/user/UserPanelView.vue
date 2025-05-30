<template>
  <section
    class="min-h-screen bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 py-20 px-6 text-gray-800 dark:text-gray-100"
  >
    <div class="max-w-7xl mx-auto">
      <!-- Título -->
      <div class="text-center mb-14" data-aos="fade-up">
        <h1
          class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-blue-400 dark:from-orange-300 dark:to-blue-500 animate-glow"
        >
          👋 Bienvenido de nuevo
        </h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
          Accede a toda tu información desde un solo lugar.
        </p>
      </div>

      <!-- Resumen -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        <div
          v-for="(card, index) in resumen"
          :key="card.label"
          class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-3xl p-8 text-center shadow-2xl hover:shadow-blue-400/20 hover:-translate-y-1 transition-all duration-300"
          data-aos="zoom-in-up"
          :data-aos-delay="index * 100"
        >
          <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">
            {{ card.icono }}
          </div>
          <p class="text-sm text-gray-600 dark:text-gray-300">{{ card.label }}</p>
          <p class="text-3xl font-bold mt-1 text-gray-800 dark:text-white">{{ card.valor }}</p>
        </div>
      </div>

      <!-- Secciones -->
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(card, i) in secciones"
          :key="card.titulo"
          class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-3xl p-8 text-left shadow-2xl hover:shadow-purple-400/20 hover:-translate-y-1 transition-all duration-300"
          data-aos="fade-up"
          :data-aos-delay="i * 100"
        >
          <div class="flex items-center gap-3 mb-4">
            <div class="text-3xl">{{ card.icono }}</div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ card.titulo }}</h2>
          </div>
          <p class="text-gray-600 dark:text-gray-300 mb-6">{{ card.descripcion }}</p>
          <router-link
            :to="card.enlace"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-purple-600 hover:to-blue-600 px-5 py-2.5 rounded-full shadow-md hover:shadow-lg transition"
          >
            Ver todos
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const resumen = ref([
  { label: 'Pedidos', valor: 0, icono: '📦' },
  { label: 'Favoritos', valor: 0, icono: '❤️' },
  { label: 'Reparaciones', valor: 0, icono: '🔧' },
  { label: 'Facturas', valor: 0, icono: '📄' },
])

onMounted(async () => {
  try {
    const [orders, favorites, repairs, invoices] = await Promise.allSettled([
      api.get('/orders'),
      api.get('/favorites'),
      api.get('/repairs'),
      api.get('/invoices'),
    ])

    resumen.value = [
      {
        label: 'Pedidos',
        valor: orders.status === 'fulfilled' ? orders.value.data.length : 0,
        icono: '📦',
      },
      {
        label: 'Favoritos',
        valor: favorites.status === 'fulfilled' ? favorites.value.data.favorites.length : 0,
        icono: '❤️',
      },
      {
        label: 'Reparaciones',
        valor: repairs.status === 'fulfilled' ? repairs.value.data.length : 0,
        icono: '🔧',
      },
      {
        label: 'Facturas',
        valor: invoices.status === 'fulfilled' ? invoices.value.data.length : 0,
        icono: '📄',
      },
    ]
  } catch (error) {
    console.error('❌ Error al cargar estadísticas del usuario:', error)
  }
})

const secciones = [
  {
    titulo: 'Pedidos realizados',
    icono: '📦',
    descripcion: 'Consulta todos tus pedidos, estado y detalles.',
    enlace: '/user/orders',
  },
  {
    titulo: 'Productos favoritos',
    icono: '❤️',
    descripcion: 'Accede rápidamente a tus productos guardados.',
    enlace: '/user/favorites',
  },
  {
    titulo: 'Reparaciones',
    icono: '🔧',
    descripcion: 'Revisa el estado de tus solicitudes técnicas.',
    enlace: '/user/repairs',
  },
  {
    titulo: 'Dirección',
    icono: '👤',
    descripcion: 'Modifica tus datos personales de dirección.',
    enlace: '/user/address',
  },
  {
    titulo: 'Mis presupuestos',
    icono: '🧾',
    descripcion: 'Consulta tus presupuestos y revisa su estado.',
    enlace: '/user/budgets',
  },
  {
    titulo: 'Facturas',
    icono: '📄',
    descripcion: 'Consulta y descarga tus facturas generadas.',
    enlace: '/user/invoices',
  },
]
</script>

<style scoped>
@keyframes glow {
  0% {
    text-shadow:
      0 0 5px rgba(124, 58, 237, 0.4),
      0 0 10px rgba(124, 58, 237, 0.3);
  }
  100% {
    text-shadow:
      0 0 12px rgba(139, 92, 246, 0.5),
      0 0 20px rgba(139, 92, 246, 0.4);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}
</style>
