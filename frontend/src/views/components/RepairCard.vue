<template>
    <div class=" dark:bg-gray-800 -2xl -md  transition overflow-hidden">
      <img :src="repair.imagen" alt="servicio" class="w-full h-48 object-cover" />
      <div class="p-4">
        <h2 class="text-lg font-bold   truncate">{{ repair.servicio }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 mb-3">{{ repair.descripcion }}</p>
        <div class="flex justify-between items-center">
          <span class="text-blue-600 dark:text-blue-400 font-bold">Desde €{{ repair.precio.toFixed(2) }}</span>
          <button
            class="bg-green-600 hover:bg-green-700 text-white text-xs    transition"
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
  