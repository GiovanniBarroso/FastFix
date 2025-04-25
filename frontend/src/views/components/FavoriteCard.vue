<template>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden">
      <img :src="product.imagen" alt="producto" class="w-full h-48 object-cover" />
      <div class="p-4">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white truncate">{{ product.nombre }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 mb-3">{{ product.descripcion }}</p>
        <div class="flex justify-between items-center">
          <span class="text-blue-600 dark:text-blue-400 font-bold">€{{ product.precio.toFixed(2) }}</span>
          <button
            @click="removeFromFavorites"
            class="text-red-500 text-xs hover:underline"
          >
            Quitar
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps(['product'])
  
  const removeFromFavorites = () => {
    // Aquí luego se conectaría con backend o almacenamiento local
    alert('Producto eliminado de favoritos (simulado)')
  }
  </script>
  