<template>
  <div
    class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-red-600 via-rose-700 to-red-800 text-white text-center p-6">
    <div class="text-6xl mb-6 animate-pulse">❌</div>
    <h1 class="text-3xl md:text-5xl font-extrabold drop-shadow-xl">Error al procesar el pago</h1>
    <p class="mt-4 text-lg md:text-xl opacity-90">Hubo un problema al confirmar tu pago. Por favor, inténtalo de nuevo
      más tarde o contacta con soporte.</p>
    <router-link to="/carrito"
      class="mt-8 px-6 py-3 bg-white text-red-700 font-semibold text-lg rounded-full shadow-lg hover:bg-red-100 transition">
      Volver al carrito
    </router-link>
  </div>
</template>
