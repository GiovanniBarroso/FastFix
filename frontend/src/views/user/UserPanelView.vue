<template>
  <section class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Encabezado -->
      <h1 class="text-3xl font-extrabold mb-2 text-center text-gray-900 dark:text-white">
        👋 Bienvenido de nuevo
      </h1>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-8">
        Accede a toda tu información desde un solo lugar.
      </p>

      <!-- Resumen estadístico -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
          <p class="text-sm text-gray-500 dark:text-gray-300">Pedidos</p>
          <p class="text-2xl font-bold text-blue-600">14</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
          <p class="text-sm text-gray-500 dark:text-gray-300">Favoritos</p>
          <p class="text-2xl font-bold text-red-500">8</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
          <p class="text-sm text-gray-500 dark:text-gray-300">Reparaciones</p>
          <p class="text-2xl font-bold text-yellow-500">3</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
          <p class="text-sm text-gray-500 dark:text-gray-300">Facturas</p>
          <p class="text-2xl font-bold text-green-500">7</p>
        </div>
      </div>

      <!-- Tarjetas de acceso -->
      <div class="grid gap-6 md:grid-cols-2">
        <div v-for="card in secciones" :key="card.titulo"
          class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg transform transition duration-300 hover:scale-[1.02] hover:shadow-2xl hover:ring-1 hover:ring-blue-400">
          <div class="flex items-center mb-3">
            <div class="text-2xl mr-3">{{ card.icono }}</div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ card.titulo }}</h2>
          </div>
          <p class="text-gray-600 dark:text-gray-300">{{ card.descripcion }}</p>
          <router-link :to="card.enlace"
            class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">
            Ver todos
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
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
