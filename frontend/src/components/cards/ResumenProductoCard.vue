<template>
  <div
    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md hover:shadow-lg transition mt-1"
  >
    <div class="flex items-center gap-4 flex-1">
      <img
        :src="getImageUrl(imagen)"
        class="w-16 h-16 rounded object-cover shadow"
        alt="Producto"
      />
      <div>
        <p class="font-bold text-gray-900 dark:text-white text-lg">
          {{ nombre }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ marca }}</p>
        <p v-if="!compacto" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mt-1">
          Precio: €{{ formatPrice(precio) }}
        </p>
      </div>
    </div>

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

const baseURL = 'http://localhost:8000'
const getImageUrl = (filename) =>
  !filename
    ? `${baseURL}/images/default.jpg`
    : filename.startsWith('http')
      ? filename
      : `${baseURL}/images/${filename}`

const formatPrice = (value) =>
  new Intl.NumberFormat('es-ES', {
    style: 'decimal',
    minimumFractionDigits: 2,
  }).format(value)
</script>
