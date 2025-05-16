<template>
  <div
    class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden"
  >
    <img :src="repair.imagen" alt="servicio" class="w-full h-44 object-cover rounded-t-xl" />
    <div class="p-5">
      <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1 truncate">
        {{ repair.servicio }}
      </h2>
      <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        {{ repair.descripcion }}
      </p>
      <div class="flex justify-between items-center">
        <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
          Desde €{{ repair.precio.toFixed(2) }}
        </span>
        <button
          class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded-full hover:bg-blue-700 transition font-medium"
        >
          Solicitar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps(['repair'])
</script>
