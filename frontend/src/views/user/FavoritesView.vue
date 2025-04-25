<template>
    <section class="py-10 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-6 text-center">
          ❤️ Tus favoritos
        </h1>
  
        <div v-if="favorites.length" class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          <FavoriteCard
            v-for="(product, index) in favorites"
            :key="index"
            :product="product"
          />
        </div>
  
        <div v-else class="text-center text-gray-600 dark:text-gray-400 mt-20">
          No tienes productos en favoritos.
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  import FavoriteCard from '@/components/products/FavoriteCard.vue'
  
  const favorites = [
    {
      nombre: 'Cargador Anker 20W',
      precio: 14.99,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Carga rápida para tus dispositivos.'
    },
    {
      nombre: 'Funda Spigen Ultra',
      precio: 12.99,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Protección total para tu móvil.'
    },
    {
      nombre: 'Cristal templado',
      precio: 5.00,
      imagen: 'https://via.placeholder.com/300x200',
      descripcion: 'Pantalla segura ante caídas.'
    }
  ]
  </script>
  