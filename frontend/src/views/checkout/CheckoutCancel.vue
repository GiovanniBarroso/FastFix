<template>
  <div
    class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-rose-600 via-red-700 to-red-900 text-white text-center p-6">
    
    <div class="text-7xl mb-6 animate-bounce">❌</div>

    <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-xl tracking-tight">
      ¡Pago cancelado!
    </h1>

    <p class="mt-4 text-lg md:text-xl text-white/90 max-w-xl">
      Has cancelado el proceso de pago. Si fue un error, puedes volver al carrito y reintentar cuando lo desees.
    </p>

    <router-link
      to="/cart"
      class="mt-8 px-6 py-3 bg-white text-red-800 font-semibold text-lg rounded-full shadow-lg hover:bg-red-100 transition-all duration-300">
      Volver al carrito
    </router-link>
  </div>
</template>
