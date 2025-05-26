<template>
  <section class="py-14 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
      <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-8 text-center">
        🛒 Tu carrito de compras
      </h1>

      <div v-if="cart.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Resumen de productos</h2>
          <button @click="vaciarCarrito"
            class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-sm text-gray-800 dark:text-white px-4 py-2 rounded transition">
            Vaciar carrito
          </button>
        </div>

        <table class="min-w-full text-sm text-left text-gray-800 dark:text-gray-200">
          <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium">
            <tr>
              <th class="p-4">#</th>
              <th class="p-4">Producto</th>
              <th class="p-4">Precio</th>
              <th class="p-4">Cantidad</th>
              <th class="p-4">Subtotal</th>
              <th class="p-4 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in cart" :key="item.id"
              class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 flex items-center gap-4">
                <img :src="getImageUrl(item.product.image)" class="w-14 h-14 rounded object-cover" alt="Producto" />
                <div>
                  <span class="block font-semibold text-gray-800 dark:text-white">{{ item.product.name }}</span>
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ item.product.brand?.name }}</span>
                </div>
              </td>
              <td class="p-4">€{{ parseFloat(item.product.price).toFixed(2) }}</td>
              <td class="p-4">
                <div class="flex items-center gap-2">
                  <button @click="cambiarCantidad(item, -1)"
                    class="px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 active:scale-95 transition-all duration-150"
                    :disabled="item.quantity <= 1">
                    −
                  </button>
                  <span class="w-6 text-center font-semibold">{{ item.quantity }}</span>
                  <button @click="cambiarCantidad(item, 1)"
                    class="px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 active:scale-95 transition-all duration-150">
                    +
                  </button>
                </div>
              </td>
              <td class="p-4 font-semibold text-blue-600 dark:text-blue-400">
                €{{ (parseFloat(item.product.price) * item.quantity).toFixed(2) }}
              </td>
              <td class="p-4 text-center">
                <button @click="eliminarDelCarrito(item.id)"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs">
                  Eliminar todo
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16">
        <p class="text-lg mb-2">Tu carrito está vacío.</p>
        <p class="text-sm">Agrega productos desde la tienda para comenzar tu compra.</p>
      </div>

      <div v-if="cart.length" class="flex flex-col sm:flex-row justify-between items-center mt-10 gap-6">
        <span class="text-2xl font-bold text-gray-800 dark:text-white">
          Total: €{{ total.toFixed(2) }}
        </span>
        <BaseButton :loading="loading" @click="finalizarCompra" fullWidth class="sm:w-auto">
          Finalizar compra
        </BaseButton>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'
import BaseButton from '@/views/components/BaseButton.vue'

const cart = ref([])
const loading = ref(false)

const getCart = async () => {
  try {
    const response = await api.get('/cart')
    cart.value = response.data.cart
  } catch (error) {
    console.error('Error al obtener el carrito:', error)
  }
}

const cambiarCantidad = async (item, delta) => {
  const nuevaCantidad = item.quantity + delta
  if (nuevaCantidad <= 0) return eliminarDelCarrito(item.id)
  try {
    await api.put(`/cart/${item.id}`, { quantity: nuevaCantidad })
    item.quantity = nuevaCantidad
  } catch (error) {
    console.error('Error al actualizar cantidad', error)
  }
}

const eliminarDelCarrito = async (id) => {
  try {
    await api.delete(`/cart/${id}`)
    cart.value = cart.value.filter((item) => item.id !== id)
  } catch (error) {
    console.error('Error al eliminar del carrito', error)
  }
}

const vaciarCarrito = async () => {
  try {
    await api.post('/cart/clear')
    cart.value = []
  } catch (error) {
    console.error('Error al vaciar carrito', error)
  }
}

const finalizarCompra = async () => {
  loading.value = true
  try {
    const response = await api.post('/orders')
    cart.value = []
    alert('✅ Compra realizada correctamente. Pedido ID: ' + response.data.order.id)
  } catch (error) {
    alert('❌ Error al finalizar la compra. Intenta de nuevo.')
  } finally {
    loading.value = false
  }
}

const baseURL = 'http://localhost:8000'
const getImageUrl = (filename) => {
  if (!filename) return `${baseURL}/images/default.jpg`
  return filename.startsWith('http') ? filename : `${baseURL}/images/${filename}`
}

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + parseFloat(item.product.price) * item.quantity, 0)
)

onMounted(getCart)
</script>
