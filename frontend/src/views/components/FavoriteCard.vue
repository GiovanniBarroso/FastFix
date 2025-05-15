<template>
  <section class="py-10 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-4xl font-extrabold mb-6 text-center">
        ❤️ Tus favoritos
      </h1>

      <div v-if="favorites.length" class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <FavoriteCard v-for="(fav, index) in favorites" :key="index" :favorite="fav" @removed="removeFavorite" />
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-400 mt-20">
        No tienes productos en favoritos.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import FavoriteCard from '@/components/products/FavoriteCard.vue'

const favorites = ref([])

const loadFavorites = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await api.get(
      import.meta.env.VITE_API_URL + '/favorites',
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    )
    favorites.value = response.data
  } catch (error) {
    console.error('Error al cargar favoritos:', error)
  }
}

const removeFavorite = (id) => {
  favorites.value = favorites.value.filter(fav => fav.id !== id)
}

onMounted(loadFavorites)
</script>
