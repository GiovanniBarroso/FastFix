<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Título -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-4">❤️ Tus favoritos</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">
          Estos son los productos que has marcado como favoritos.
        </p>
      </div>

      <!-- Grid -->
      <div v-if="favorites.length" class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <FavoriteCard v-for="(fav, index) in favorites" :key="index" :product="fav.product" />
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-400 mt-20 text-lg">
        Aún no tienes productos en tu lista de favoritos. 🌟
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import FavoriteCard from '@/components/products/FavoriteCard.vue'

// Datos de prueba manuales
const favorites = ref([
  {
    product: {
      nombre: 'Auriculares inalámbricos Pro',
      marca: 'SoundMax',
      precio: 59.99,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Calidad de sonido envolvente con cancelación de ruido activa.'
    }
  },
  {
    product: {
      nombre: 'Power Bank 20000mAh',
      marca: 'VoltUp',
      precio: 24.95,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Carga múltiples dispositivos con alta velocidad.'
    }
  },
  {
    product: {
      nombre: 'Soporte para portátil ajustable',
      marca: 'ErgoLift',
      precio: 19.99,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Mejora tu postura y la ventilación del equipo.'
    }
  },
  {
    product: {
      nombre: 'Cable USB-C magnético',
      marca: 'MagneticLine',
      precio: 7.49,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Conexión rápida y sin desgaste del conector.'
    }
  }
])
</script>
