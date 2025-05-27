<template>
  <section class="py-14 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
      <h1
        class="text-4xl font-extrabold text-gray-900 dark:text-white text-center mb-10 tracking-tight"
      >
        🛒 Tu carrito de compras
      </h1>

      <div
        v-if="cart.length"
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 transition"
      >
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
          <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Resumen de productos</h2>
          <button
            @click="mostrarModal = true"
            class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-800 text-red-600 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium transition"
          >
            🗑️ Vaciar carrito
          </button>
        </div>

        <ResumenProductoCard
          v-for="(item, index) in cart"
          :key="item.id"
          :nombre="item.product.nombre"
          :marca="item.product.brand?.nombre"
          :precio="item.product.precio"
          :imagen="item.product.image"
        >
          <template #acciones>
            <div class="flex items-center gap-2">
              <button
                @click="cambiarCantidad(item, -1)"
                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-lg font-bold text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 active:scale-95 transition"
                :disabled="item.cantidad <= 1"
                title="Disminuir"
              >
                −
              </button>
              <span class="w-8 text-center font-semibold text-gray-900 dark:text-white">
                {{ item.cantidad }}
              </span>
              <button
                @click="cambiarCantidad(item, 1)"
                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-lg font-bold text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 active:scale-95 transition"
                title="Aumentar"
              >
                +
              </button>
            </div>

            <p class="text-blue-600 dark:text-blue-400 font-bold whitespace-nowrap">
              €{{ formatPrice(item.product.precio * item.cantidad) }}
            </p>

            <button
              @click="eliminarDelCarrito(item.id)"
              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs shadow-sm"
              title="Eliminar producto"
            >
              🗑️
            </button>
          </template>
        </ResumenProductoCard>
      </div>

      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16">
        <p class="text-lg mb-2">Tu carrito está vacío.</p>
        <p class="text-sm">Agrega productos desde la tienda para comenzar tu compra.</p>
      </div>

      <div
        v-if="cart.length"
        class="mt-10 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col sm:flex-row items-center justify-between gap-6"
      >
        <div class="text-2xl font-extrabold text-gray-900 dark:text-white">
          Total: <span class="text-blue-600 dark:text-blue-400">€{{ formatPrice(total) }}</span>
        </div>

        <BaseButton
          :loading="loading"
          @click="finalizarCompra"
          class="w-full sm:w-auto bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-3 text-base rounded-lg font-semibold shadow-lg transition-all duration-200 active:scale-95"
        >
          Finalizar compra
        </BaseButton>
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

const getCart = async () => {
  try {
    const response = await api.get('/cart')
    cart.value = response.data.cart
  } catch (error) {
    console.error('Error al obtener el carrito:', error)
  }
}

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

const baseURL = 'http://localhost:8000'
const getImageUrl = (filename) =>
  !filename
    ? `${baseURL}/images/default.jpg`
    : filename.startsWith('http')
      ? filename
      : `${baseURL}/images/${filename}`

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
