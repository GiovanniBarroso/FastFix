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
        <FavoriteCard
          v-for="fav in favorites"
          :key="fav.id"
          :product="fav.product"
          @eliminado="fetchFavorites"
        />
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-400 mt-20 text-lg">
        Aún no tienes productos en tu lista de favoritos. 🌟
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import FavoriteCard from '@/components/products/FavoriteCard.vue'

const favorites = ref([])

const fetchFavorites = async () => {
  try {
    const response = await api.get('/favorites')
    favorites.value = response.data.favorites
  } catch (error) {
    console.error('Error al cargar favoritos:', error)
  }
}

onMounted(fetchFavorites)
</script>
