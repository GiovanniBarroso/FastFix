<template>
  <section class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 px-6">
    <div class="text-center">
      <div class="text-7xl font-bold text-red-500 mb-6 animate-pulse">🚫</div>
      <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-4">
        Acceso denegado
      </h1>
      <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
        No tienes permisos para acceder a esta sección del panel de administración.
      </p>
      <router-link
        to="/"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-all"
      >
        Volver al inicio
      </router-link>
    </div>
  </section>
</template>

<script setup>
// No necesitas lógica específica aquí
</script>

<style scoped>
.animate-pulse {
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.1);
    opacity: 0.7;
  }
}
</style>
