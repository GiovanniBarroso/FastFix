<template>
    <router-link
      :to="to"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-base font-semibold bg-blue-100 hover:bg-blue-200 text-blue-800 dark:bg-blue-900 dark:hover:bg-blue-800 dark:text-blue-100 transition"
    >
      <span class="text-xl">←</span>
      <span>{{ label }}</span>
    </router-link>
  </template>
  
  <script setup>
  defineProps({
    to: {
      type: String,
      default: '/home' // ✅ Cambia aquí según cuál sea tu panel de usuario
    },
    label: {
      type: String,
      default: 'Volver al panel'
    }
  })
  </script>
  