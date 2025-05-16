<template>
  <div
    class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
  >
    <img :src="product.imagen" alt="Producto favorito" class="w-full h-40 object-cover rounded-t-xl" />
    <div class="p-4">
      <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
        {{ product.nombre }}
      </h3>
      <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
        {{ product.descripcion }}
      </p>
      <div class="flex justify-between items-center">
        <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
          €{{ product.precio.toFixed(2) }}
        </span>
        <button
          @click="$emit('removed', product.id)"
          class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-full hover:bg-red-600 transition"
        >
          Quitar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps(['product'])
defineEmits(['removed'])
</script>
