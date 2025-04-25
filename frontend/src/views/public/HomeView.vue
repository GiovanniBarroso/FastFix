<template>
  <div class="pt-20">
    <!-- Hero -->
    <section class="bg-blue-50 dark:bg-gray-800 text-center py-20">
      <h1 class="text-4xl sm:text-5xl font-bold text-blue-600 dark:text-white mb-4">
        Bienvenido a FastFix
      </h1>
      <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
        Reparamos tu dispositivo con garantía, rapidez y calidad.
      </p>
      <router-link to="/product-list" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded transition">
        Ver productos
      </router-link>
    </section>

    <!-- Servicios -->
    <section class="py-16 bg-white dark:bg-gray-900 text-center">
      <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-10">¿Qué reparamos?</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 px-6">
        <div class="card">📱 Móviles</div>
        <div class="card">💻 Ordenadores</div>
        <div class="card">🎮 Consolas</div>
        <div class="card">📱 Tablets</div>
      </div>
    </section>

    <!-- Confianza -->
    <section class="bg-blue-100 dark:bg-gray-800 py-16 text-center">
      <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-10">¿Por qué elegirnos?</h2>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 px-6">
        <div class="card">⚡ Servicio rápido</div>
        <div class="card">✅ Garantía 100%</div>
        <div class="card">💬 Soporte personalizado</div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 text-center bg-white dark:bg-gray-900">
      <h2 class="text-2xl text-gray-800 dark:text-white mb-4">
        ¿Tienes una avería? Solicita presupuesto sin compromiso
      </h2>
      <router-link
        to="/budget-request"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded transition"
      >
        Solicitar presupuesto
      </router-link>
    </section>
  </div>
</template>

<style scoped>
.card {
  @apply bg-white dark:bg-gray-700 text-gray-800 dark:text-white p-6 rounded shadow hover:shadow-lg transition;
}
</style>
