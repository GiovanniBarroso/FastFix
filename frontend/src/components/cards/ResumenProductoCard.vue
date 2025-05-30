<template>
  <div
    class="relative overflow-hidden flex flex-col sm:flex-row justify-between items-center gap-6 p-6 rounded-3xl shadow-xl bg-white/70 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300"
  >
    <!-- Imagen + Info -->
    <div class="flex items-center gap-5 flex-1 w-full">
      <img
        :src="getImageUrl(imagen)"
        class="w-24 h-24 rounded-2xl object-contain bg-white p-2 shadow-md border border-gray-300 dark:border-gray-600"
        alt="Producto"
      />
      <div class="space-y-1">
        <p class="text-sm uppercase text-gray-500 dark:text-gray-400 tracking-wide font-medium">
          {{ marca }}
        </p>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white leading-snug">
          {{ nombre }}
        </h3>
        <p v-if="!compacto" class="text-sm text-gray-600 dark:text-gray-300">
          Precio unitario:
          <span class="font-semibold text-gray-900 dark:text-white">€{{ formatPrice(precio) }}</span>
        </p>
      </div>
    </div>

    <!-- Acciones + Precio total -->
    <div
      v-if="$slots.acciones"
      class="flex flex-col sm:flex-row items-center justify-end gap-4 sm:gap-6 w-full sm:w-auto"
    >
      <div class="flex items-center gap-3">
        <slot name="acciones" />
      </div>
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
