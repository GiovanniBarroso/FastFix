<template>
  <div
    class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 mt-3"
  >
    <!-- Imagen + Info -->
    <div class="flex items-center gap-5 flex-1">
      <img
  :src="getImageUrl(imagen)"
  class="w-20 h-20 rounded-xl object-contain bg-white p-1 shadow-md border border-gray-200 dark:border-gray-700"
  alt="Producto"
/>
      <div>
        <p class="font-black text-gray-900 dark:text-white text-lg leading-tight">
          {{ nombre }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ marca }}</p>
        <p v-if="!compacto" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mt-1">
          Precio unitario:
          <span class="text-gray-900 dark:text-white">€{{ formatPrice(precio) }}</span>
        </p>
      </div>
    </div>

    <!-- Acciones -->
    <div
      v-if="$slots.acciones"
      class="flex items-center gap-3 justify-between sm:justify-end w-full sm:w-auto"
    >
      <slot name="acciones" />
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  nombre: String,
  marca: String,
  precio: Number,
  imagen: String,
  compacto: {
    type: Boolean,
    default: false,
  },
})

const getImageUrl = (filename) => {
  if (!filename) return '/images/default.jpg'
  return `/products/${filename}`
}

const formatPrice = (value) =>
  new Intl.NumberFormat('es-ES', {
    style: 'decimal',
    minimumFractionDigits: 2,
  }).format(value)
</script>
