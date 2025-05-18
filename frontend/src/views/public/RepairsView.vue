<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen text-gray-800 dark:text-gray-100">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">
          🔧 Servicios de reparación
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Reparamos tus dispositivos de forma rápida, segura y garantizada. Explora nuestros servicios disponibles:
        </p>
      </div>

      <!-- Grid de servicios -->
      <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <RepairCard
          v-for="(repair, index) in repairs"
          :key="index"
          :repair="repair"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import RepairCard from '@/components/products/RepairCard.vue'

const repairs = [
  {
    servicio: 'Cambio de pantalla',
    descripcion: 'Reemplazo de pantallas rotas o dañadas.',
    precio: 79.99,
    imagen: 'https://via.placeholder.com/300x200'
  },
  {
    servicio: 'Cambio de batería',
    descripcion: 'Sustitución de batería para mayor duración.',
    precio: 49.99,
    imagen: 'https://via.placeholder.com/300x200'
  },
  {
    servicio: 'Reparación de conector de carga',
    descripcion: 'Solución de problemas de carga en tu dispositivo.',
    precio: 39.99,
    imagen: 'https://via.placeholder.com/300x200'
  },
  {
    servicio: 'Reparación de cámara',
    descripcion: 'Cámaras delanteras o traseras dañadas.',
    precio: 59.99,
    imagen: 'https://via.placeholder.com/300x200'
  }
]
</script>
