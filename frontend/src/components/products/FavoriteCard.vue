<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden hover:shadow-lg transition">
    <img
      :src="getImageUrl(favorite.product.image)"
      class="w-full h-48 object-cover"
      alt="Producto favorito"
    />
    <div class="p-4">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
        {{ favorite.product.name }}
      </h3>
      <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
        {{ favorite.product.description }}
      </p>
      <div class="mt-4 flex justify-between items-center">
        <span class="text-lg font-bold text-gray-900 dark:text-white">
          €{{ parseFloat(favorite.product.price).toFixed(2) }}
        </span>
        <button
          @click="removeFromFavorites"
          class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm"
        >
          Eliminar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import api from '@/services/api'
import { useToast } from 'vue-toastification'

const props = defineProps({
  favorite: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['eliminado'])

const toast = useToast()

const removeFromFavorites = async () => {
  try {
    await api.delete(`/favorites/${props.favorite.id}`)
    toast.success('✅ Producto eliminado de favoritos.')
    emit('eliminado') // para refrescar la lista
  } catch (error) {
    toast.error('❌ Error al eliminar favorito.')
    console.error(error)
  }
}

const baseURL = 'http://localhost:8000'
const getImageUrl = (filename) => {
  if (!filename) return `${baseURL}/images/default.jpg`
  return filename.startsWith('http') ? filename : `${baseURL}/images/${filename}`
}
</script>
