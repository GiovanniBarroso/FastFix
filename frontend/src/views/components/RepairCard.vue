<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img :src="repair.imagen" alt="servicio" class="w-full h-48 object-cover" />
    <div class="p-4">
      <h2 class="text-lg font-bold text-gray-800 dark:text-white truncate">{{ repair.servicio }}</h2>
      <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 mb-4">{{ repair.descripcion }}</p>
      <div class="flex justify-between items-center">
        <span class="text-blue-600 dark:text-blue-400 font-bold">
          Desde €{{ repair.precio.toFixed(2) }}
        </span>
        <button class="bg-green-600 hover:bg-green-700 text-white text-xs py-2 px-4 rounded-md transition">
          Solicitar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps(['repair'])
</script>
