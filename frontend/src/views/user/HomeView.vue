<template>
  <section class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-3xl font-extrabold mb-4 text-center text-gray-900 dark:text-white">📊 Panel de Usuario</h1>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-8">
        Accede fácilmente a tus pedidos, garantías, productos favoritos y reparaciones.
      </p>

      <div class="grid gap-6 md:grid-cols-2">
        <!-- Tarjeta genérica -->
        <div
          v-for="card in secciones"
          :key="card.titulo"
          class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg transform transition duration-300 hover:scale-[1.02] hover:shadow-2xl hover:ring-1 hover:ring-blue-400"
        >
          <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">{{ card.icono }} {{ card.titulo }}</h2>
          <p class="text-gray-600 dark:text-gray-300">{{ card.descripcion }}</p>
          <router-link
            :to="card.enlace"
            class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200"
          >
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
    titulo: 'Últimos pedidos',
    icono: '📦',
    descripcion: 'Consulta el historial de tus compras y revisa el estado de tus pedidos.',
    enlace: '/orders'
  },
  {
    titulo: 'Garantías activas',
    icono: '🛡️',
    descripcion: 'Visualiza los productos con garantía vigente y su fecha de vencimiento.',
    enlace: '/guarantee'
  },
  {
    titulo: 'Favoritos',
    icono: '❤️',
    descripcion: 'Revisa los productos que has marcado como favoritos para encontrarlos fácilmente.',
    enlace: '/favorites'
  },
  {
    titulo: 'Reparaciones recientes',
    icono: '🔧',
    descripcion: 'Consulta tus solicitudes de reparación más recientes y su estado.',
    enlace: '/repairs'
  }
]
</script>
