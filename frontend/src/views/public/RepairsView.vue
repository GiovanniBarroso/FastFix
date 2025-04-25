<template>
    <section class="py-10 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-6 text-center">
          🔧 Servicios de reparación
        </h1>
  
        <p class="text-center text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto">
          Reparamos tus dispositivos de forma rápida, segura y garantizada. Explora nuestros servicios disponibles:
        </p>
  
        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
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
  import RepairCard from '@/components/repairs/RepairCard.vue'
  
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
  