<template>
  <div
    class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-emerald-500 via-green-600 to-emerald-700 text-white text-center p-6"
  >
    <div class="text-6xl mb-6 animate-bounce">✅</div>
    <h1 class="text-3xl md:text-5xl font-extrabold drop-shadow-xl">¡Pago realizado con éxito!</h1>
    <p class="mt-4 text-lg md:text-xl opacity-90">
      Gracias por tu compra en <span class="font-bold text-yellow-300">FastFix</span>. Tu pedido ha
      sido confirmado.
    </p>
    <router-link
      to="/"
      class="mt-8 px-6 py-3 bg-white text-green-700 font-semibold text-lg rounded-full shadow-lg hover:bg-green-100 transition"
    >
      Volver al inicio
    </router-link>
  </div>
</template>
<script setup>
import { onMounted } from 'vue'
import { useCartStore } from '@/stores/cartStore'

const cartStore = useCartStore()

onMounted(() => {
  cartStore.clearCart()
  localStorage.removeItem('cart') // Opcional, si quieres forzar limpieza local
})
</script>
