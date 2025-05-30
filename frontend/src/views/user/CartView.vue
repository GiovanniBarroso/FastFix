<template>
  <section
    class="py-25 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-950 min-h-screen"
  >
    <div class="max-w-6xl mx-auto px-4">
      <!-- Título principal mejorado -->
      <div class="text-center mb-14" data-aos="fade-up">
        <h1
          class="text-5xl sm:text-6xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 bg-clip-text text-transparent tracking-tight drop-shadow-md dark:drop-shadow-[0_2px_4px_rgba(255,255,255,0.15)]"
        >
          🛒 Tu carrito de compras
        </h1>
        <p
          class="mt-4 text-lg sm:text-xl text-gray-700 dark:text-gray-300 font-medium max-w-xl mx-auto"
        >
          Gestiona tus productos antes de finalizar la compra
        </p>
      </div>

      <!-- Contenedor del carrito -->
      <div v-if="cart.length" class="space-y-6" data-aos="fade-up" data-aos-delay="100">
        <!-- Cabecera del listado -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
          <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Resumen de productos</h2>
          <button
            @click="mostrarModal = true"
            class="inline-flex items-center gap-2 border border-red-400 text-red-500 dark:text-red-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-red-100 dark:hover:bg-red-800 transition"
          >
            🗑️ Vaciar carrito
          </button>
        </div>

        <!-- Lista de productos -->
        <ResumenProductoCard
          v-for="(item, index) in cart"
          :key="item.id"
          :nombre="item.product.nombre"
          :marca="item.product.brand?.nombre"
          :precio="item.product.precio"
          :imagen="item.product.image"
          :data-aos="'fade-up'"
          :data-aos-delay="150 + index * 100"
        >
          <template #acciones>
            <div class="flex items-center gap-3">
              <!-- Botón - -->
              <button
                @click="cambiarCantidad(item, -1)"
                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-lg font-bold text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 active:scale-95 transition"
                :disabled="item.cantidad <= 1"
              >
                −
              </button>

              <!-- Cantidad -->
              <span class="w-8 text-center font-semibold text-gray-900 dark:text-white">
                {{ item.cantidad }}
              </span>

              <!-- Botón + -->
              <button
                @click="cambiarCantidad(item, 1)"
                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-lg font-bold text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 active:scale-95 transition"
              >
                +
              </button>

              <!-- Precio total -->
              <p class="text-lg font-bold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                €{{ formatPrice(item.product.precio * item.cantidad) }}
              </p>

              <!-- Eliminar -->
              <button
                @click="eliminarDelCarrito(item.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs shadow-sm"
                title="Eliminar producto"
              >
                🗑️
              </button>
            </div>
          </template>
        </ResumenProductoCard>

        <!-- Total + Finalizar compra -->
        <div
          class="flex flex-col sm:flex-row justify-between items-center gap-6 bg-white/80 dark:bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-6"
          data-aos="zoom-in"
          data-aos-delay="200"
        >
          <!-- Total -->
          <div class="text-center sm:text-left">
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-1">Total del pedido</p>
            <div class="text-3xl font-extrabold text-gray-900 dark:text-white">
              €{{ formatPrice(total) }}
            </div>
          </div>

          <!-- Botón de pago -->
          <BaseButton
            :loading="loading"
            @click="finalizarCompra"
            class="w-full sm:w-auto bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-indigo-600 text-white px-6 py-3 text-base rounded-full font-semibold shadow-lg transition-all duration-200 active:scale-95"
          >
            Finalizar compra
          </BaseButton>
        </div>
      </div>

      <!-- Mensaje de carrito vacío -->
      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-20" data-aos="fade-in">
        <p class="text-lg mb-2">Tu carrito está vacío.</p>
        <p class="text-sm">Agrega productos desde la tienda para comenzar tu compra.</p>
      </div>
    </div>
  </section>

  <CartConfirmModal v-model="mostrarModal" @confirm="vaciarCarrito" />
</template>

<script setup>
import ResumenProductoCard from '@/components/cards/ResumenProductoCard.vue'
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import BaseButton from '@/views/components/BaseButton.vue'

import { useCartStore } from '@/stores/cartStore'
const cartStore = useCartStore()

const cart = computed(() => cartStore.items)
const loading = ref(false)
const router = useRouter()

const cambiarCantidad = async (item, delta) => {
  const nuevaCantidad = item.cantidad + delta
  if (nuevaCantidad <= 0) return eliminarDelCarrito(item.id)
  try {
    await api.put(`/cart/${item.id}`, { cantidad: nuevaCantidad })
    cartStore.updateItemCantidad(item.id, nuevaCantidad)
  } catch (error) {
    console.error('Error al actualizar cantidad', error)
  }
}

const eliminarDelCarrito = async (id) => {
  try {
    await api.delete(`/cart/${id}`)
    cartStore.removeItem(id)
  } catch (error) {
    console.error('Error al eliminar del carrito', error)
  }
}

const vaciarCarrito = async () => {
  try {
    await api.post('/cart/clear')
    cartStore.clearCart()
  } catch (error) {
    console.error('Error al vaciar carrito', error)
  }
}

const finalizarCompra = async () => {
  loading.value = true
  try {
    const productos = cart.value.map((item) => ({
      id: item.product.id,
      cantidad: item.cantidad,
      precio: parseFloat(item.product.precio),
    }))

    const response = await api.post('/orders', { productos })
    const orderId = response.data?.order?.id

    if (!orderId) throw new Error('No se recibió el ID del pedido')
    router.push({ name: 'CheckoutConfirm', query: { order_id: orderId } })
  } catch (error) {
    console.error('❌ Error al finalizar la compra:', error.response?.data || error)
    alert('❌ Error al finalizar la compra. Intenta de nuevo.')
  } finally {
    loading.value = false
  }
}

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + parseFloat(item.product.precio) * item.cantidad, 0),
)

const formatPrice = (value) =>
  new Intl.NumberFormat('es-ES', { style: 'decimal', minimumFractionDigits: 2 }).format(value)

onMounted(async () => {
  try {
    const response = await api.get('/cart')
    cartStore.setCart(response.data.cart)
  } catch (error) {
    console.error('Error al obtener el carrito:', error)
  }
})

import CartConfirmModal from '@/components/modals/CartConfirmModal.vue'
const mostrarModal = ref(false)
</script>
