<template>
  <section class="relative py-24 bg-gradient-to-b from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 min-h-screen text-gray-800 dark:text-gray-100">
    <div class="absolute inset-0 bg-[url('/images/bg-circuit.svg')] bg-cover bg-center opacity-5 dark:opacity-10"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-32">

      <!-- HERO SOBRE NOSOTROS -->
      <div class="text-center space-y-6 animate-fade-up">
        <h1 class="text-7xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-400">
          Sobre nosotros
        </h1>
        <p class="text-xl max-w-2xl mx-auto text-gray-600 dark:text-gray-300">
          Más que reparaciones, somos personas cuidando de tu tecnología.
        </p>
      </div>

      <!-- INTRODUCCIÓN DESTACADA -->
      <div class="grid md:grid-cols-2 gap-16 items-center">
        <div class="relative animate-fade-up">
          <img
            src="/images/about-us.jpg"
            alt="Equipo FastFix"
            class="rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] w-full object-cover border-4 border-white dark:border-gray-800"
          />
          <div class="absolute -bottom-6 -right-6 bg-white dark:bg-gray-900 px-5 py-2 rounded-full text-sm shadow-lg border border-gray-300 dark:border-gray-700">
            🛠️ Expertos certificados
          </div>
        </div>

        <div class="space-y-6 animate-fade-up">
          <h2 class="text-3xl font-extrabold text-red-600 dark:text-red-400">
            FastFix: Reparaciones con alma, precisión y rapidez
          </h2>
          <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
            En <span class="font-semibold text-gray-900 dark:text-white">FastFix</span> combinamos pasión por la tecnología con un servicio al cliente que realmente escucha. Nuestra visión es que nadie debería esperar semanas ni pagar de más por un servicio técnico honesto y eficaz.
          </p>
          <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
            Transparencia en cada paso, seguimiento en tiempo real y soluciones personalizadas. Así entendemos la reparación moderna.
          </p>
          <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
            Gracias por hacernos parte de tu historia tecnológica. <span class="text-red-600 dark:text-red-400 font-semibold">#TeamFastFix 💙</span>
          </p>
        </div>
      </div>

      <!-- VALORES CON ICONOS INTERACTIVOS -->
      <div class="space-y-10 animate-fade-up">
        <h2 class="text-4xl font-bold text-center">Nuestros valores</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">

          <div
            class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 p-8 rounded-3xl shadow-2xl text-center hover:shadow-[0_0_20px_rgba(239,68,68,0.4)] hover:-translate-y-1 transition-all duration-300">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform">🛠️</div>
            <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Calidad técnica</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
              Diagnóstico preciso. Reparación impecable. Garantía real.
            </p>
          </div>

          <div
            class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 p-8 rounded-3xl shadow-2xl text-center hover:shadow-[0_0_20px_rgba(59,130,246,0.4)] hover:-translate-y-1 transition-all duration-300">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform">🤝</div>
            <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Transparencia</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
              Sin letras pequeñas, sin sorpresas. Solo confianza.
            </p>
          </div>

          <div
            class="group bg-white/90 dark:bg-white/5 backdrop-blur-md border border-gray-200 dark:border-gray-700 p-8 rounded-3xl shadow-2xl text-center hover:shadow-[0_0_20px_rgba(34,197,94,0.4)] hover:-translate-y-1 transition-all duration-300">
            <div class="text-6xl mb-4 group-hover:scale-110 transition-transform">🚀</div>
            <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Rapidez</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
              Tu tiempo es valioso. Por eso somos veloces y eficientes.
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

<style scoped>
@keyframes fade-up {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fade-up 0.8s ease-out both;
}
</style>