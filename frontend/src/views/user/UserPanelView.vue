<template>
  <section class="min-h-screen bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 p-8">
    <div class="max-w-7xl mx-auto">
      <!-- Encabezado -->
      <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white animate-fade-in-down">
          👋 Bienvenido de nuevo
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 mt-2 animate-fade-in">
          Accede a toda tu información desde un solo lugar.
        </p>
      </div>

      <!-- Resumen estadístico -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div v-for="card in resumen" :key="card.label"
             class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition hover:scale-105 hover:shadow-lg">
          <p class="text-sm text-gray-500 dark:text-gray-300">{{ card.label }}</p>
          <p :class="['text-3xl font-bold', card.color]">{{ card.valor }}</p>
        </div>
      </div>

      <!-- Tarjetas de acceso -->
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="card in secciones" :key="card.titulo"
             class="relative bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 hover:ring-2 hover:ring-blue-500 transition-all duration-300 group overflow-hidden">
          <div class="flex items-center gap-3 mb-4">
            <div class="text-3xl">{{ card.icono }}</div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ card.titulo }}</h2>
          </div>
          <p class="text-gray-600 dark:text-gray-300 mb-5">{{ card.descripcion }}</p>
          <router-link :to="card.enlace"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded transition">
            Ver todos
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </router-link>

          <!-- Fondo animado al pasar -->
          <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition bg-gradient-to-br from-blue-300 to-purple-400 rounded-2xl pointer-events-none"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const resumen = ref([
  { label: 'Pedidos', valor: 0, color: 'text-blue-600' },
  { label: 'Favoritos', valor: 0, color: 'text-red-500' },
  { label: 'Reparaciones', valor: 0, color: 'text-yellow-500' },
  { label: 'Facturas', valor: 0, color: 'text-green-500' }
])

onMounted(async () => {
  try {
    const res = await api.get('/me')
    const userId = res.data.id

    const [orders, favorites, repairs, invoices] = await Promise.all([
      api.get('/orders'),
      api.get('/favorites'),
      api.get('/repairs'),
      api.get('/invoices')
    ])

    resumen.value = [
      { label: 'Pedidos', valor: orders.data.length, color: 'text-blue-600' },
      { label: 'Favoritos', valor: favorites.data.favorites.length, color: 'text-red-500' },
      { label: 'Reparaciones', valor: repairs.data.length, color: 'text-yellow-500' },
      { label: 'Facturas', valor: invoices.data.length, color: 'text-green-500' }
    ]
  } catch (error) {
    console.error('Error al cargar estadísticas del usuario:', error)
  }
})

const secciones = [
  {
    titulo: 'Pedidos realizados',
    icono: '📦',
    descripcion: 'Consulta todos tus pedidos, estado y detalles.',
    enlace: '/user/orders'
  },
  {
    titulo: 'Productos favoritos',
    icono: '❤️',
    descripcion: 'Accede rápidamente a tus productos guardados.',
    enlace: '/user/favorites'
  },
  {
    titulo: 'Reparaciones',
    icono: '🔧',
    descripcion: 'Revisa el estado de tus solicitudes técnicas.',
    enlace: '/user/repairs'
  },
  {
    titulo: 'Dirección',
    icono: '👤',
    descripcion: 'Modifica tus datos personales de dirección.',
    enlace: '/user/address'
  },
  {
    titulo: 'Mis presupuestos',
    icono: '🧾',
    descripcion: 'Consulta tus presupuestos y revisa su estado.',
    enlace: '/user/budgets'
  },
  {
    titulo: 'Facturas',
    icono: '📄',
    descripcion: 'Consulta y descarga tus facturas generadas.',
    enlace: '/user/invoices'
  }
]
</script>

<style scoped>
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-down {
  animation: fadeInDown 0.6s ease-out both;
}

.animate-fade-in {
  animation: fadeIn 0.8s ease-out both;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
