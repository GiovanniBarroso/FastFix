<template>
  <transition name="fade-card" @after-leave="emit('removed')">
    <div
      v-if="visible"
      class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden hover:shadow-lg transition"
    >
      <!-- Imagen -->
      <div
        class="w-full h-48 bg-white flex items-center justify-center overflow-hidden rounded-b-none"
      >
        <img
          :src="getImageUrl(favorite.product.imagen)"
          class="h-full object-contain"
          alt="Producto favorito"
        />
      </div>

      <!-- Contenido -->
      <div class="p-4">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
          {{ favorite.product.nombre }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
          {{ favorite.product.descripcion }}
        </p>
        <div class="mt-4 flex justify-between items-center">
          <span class="text-lg font-bold text-gray-900 dark:text-white">
            €{{ parseFloat(favorite.product.precio).toFixed(2) }}
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
  </transition>
</template>

<script setup>
import api from '@/services/api'
import { useToast } from 'vue-toastification'
import { ref, defineProps, defineEmits } from 'vue'

const props = defineProps({
  favorite: {
    type: Object,
    required: true,
  },
})

const { favorite } = props // ✅ desestructuración
console.log('Imagen recibida:', favorite.product.imagen) // ✅ sin error

const emit = defineEmits(['removed'])
const toast = useToast()
const visible = ref(true)

const removeFromFavorites = async () => {
  try {
    await api.delete(`/favorites/${favorite.id}`)
    toast.success('✅ Producto eliminado de favoritos.')
    visible.value = false
  } catch (error) {
    toast.error('❌ Error al eliminar favorito.')
    console.error(error)
  }
}

const getImageUrl = (filename) => {
  if (!filename) return '/images/default.jpg'
  return `/products/${filename}`
}
</script>

<style scoped>
/* 🎬 Animación suave de desaparición */
.fade-card-leave-active {
  transition:
    opacity 0.4s ease,
    transform 0.4s ease;
}
.fade-card-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
