<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-100">
    <div class="max-w-6xl mx-auto px-6 space-y-24">

      <!-- Encabezado -->
      <div class="text-center">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">👥 Sobre nosotros</h1>
      </div>

      <!-- Introducción -->
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <img
          src="/reparacion.jpg"
          alt="Equipo FastFix"
          class="rounded-2xl shadow-lg w-full object-cover transition-transform duration-300 hover:scale-105"
        />
        <div>
          <h2 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-6">
            FastFix: Reparaciones y confianza desde el primer clic
          </h2>
          <p class="text-lg leading-relaxed mb-4 text-gray-700 dark:text-gray-300">
            En <strong class="font-semibold text-gray-900 dark:text-white">FastFix</strong> somos un equipo apasionado por la tecnología y el buen servicio. Nacimos con una misión clara:
            hacer que la reparación de dispositivos sea rápida, económica y transparente para todos.
          </p>
          <p class="text-lg leading-relaxed mb-4 text-gray-700 dark:text-gray-300">
            Contamos con técnicos especializados, herramientas de última generación y un sistema que permite seguir el
            proceso de tu reparación desde el primer momento, estés donde estés.
          </p>
          <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
            Nuestro compromiso es tu tranquilidad. <span class="text-red-600 dark:text-red-400 font-medium">Gracias por confiar en FastFix 💙</span>
          </p>
        </div>
      </div>

      <!-- Nuestros valores -->
      <div>
        <h2 class="text-3xl font-bold text-center mb-10 text-gray-900 dark:text-white">Nuestros valores</h2>
        <div class="grid sm:grid-cols-3 gap-8">
          <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105">
            <div class="text-red-600 dark:text-red-400 text-4xl mb-3">🛠️</div>
            <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">Calidad técnica</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
              Trabajamos con los mejores materiales y herramientas.
            </p>
          </div>

          <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105">
            <div class="text-red-600 dark:text-red-400 text-4xl mb-3">🤝</div>
            <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">Transparencia</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
              Informamos cada paso de tu reparación en tiempo real.
            </p>
          </div>

          <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105">
            <div class="text-red-600 dark:text-red-400 text-4xl mb-3">🚀</div>
            <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">Rapidez</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
              Sabemos que tu tiempo importa. Reparaciones express.
            </p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
// Página estática sin lógica JS por ahora
</script>
