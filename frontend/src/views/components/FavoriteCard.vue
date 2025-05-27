<template>
  <div
    class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
  >
    <!-- Imagen o fallback -->
    <img
      v-if="favorite.product && favorite.product.imagen"
      :src="getImageUrl(favorite.product.imagen)"
      alt="Producto favorito"
      class="w-full h-40 object-cover rounded-t-xl"
    />
    <div
      v-else
      class="w-full h-40 flex items-center justify-center bg-gray-100 dark:bg-gray-700 text-gray-500 text-sm italic"
    >
      Sin imagen
    </div>

    <div class="p-4">
      <!-- Nombre -->
      <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
        {{ favorite.product?.nombre || 'Producto no disponible' }}
      </h3>

      <!-- Descripción -->
      <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
        {{ favorite.product?.descripcion || 'Sin descripción disponible.' }}
      </p>

      <div class="flex justify-between items-center">
        <!-- Precio o error -->
        <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
          <template v-if="favorite.product && favorite.product.precio">
            €{{ parseFloat(favorite.product.precio).toFixed(2) }}
          </template>
          <template v-else>
            No disponible
          </template>
        </span>

        <!-- Botón quitar -->
        <button
          @click="$emit('removed', favorite.id)"
          class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-full hover:bg-red-600 transition"
        >
          Eliminar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  favorite: {
    type: Object,
    required: true
  }
})

defineEmits(['removed'])

const baseURL = 'http://localhost:8000'

const getImageUrl = (filename) => {
  if (!filename) return `${baseURL}/images/default.jpg`
  return filename.startsWith('http') ? filename : `${baseURL}/images/${filename}`
}
</script>
