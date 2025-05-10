<template>
  <section class="py-10 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
      <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-8">
        🛒 Carrito de compras
      </h1>

      <div v-if="cart.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <button @click="vaciarCarrito"
          class="bg-gray-500 hover:bg-gray-600 text-white text-xs px-3 py-1 rounded transition">
          Vaciar carrito
        </button>
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
          <thead class="bg-yellow-400 text-gray-900 font-semibold">
            <tr>
              <th class="p-4">#</th>
              <th class="p-4">Producto</th>
              <th class="p-4">Precio</th>
              <th class="p-4">Cantidad</th>
              <th class="p-4">Subtotal</th>
              <th class="p-4">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in cart" :key="item.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 flex items-center gap-4">
                <img :src="item.imagen" class="w-12 h-12 rounded object-cover" alt="Producto" />
                <span class="font-medium text-gray-800 dark:text-white">{{ item.nombre }}</span>
              </td>
              <td class="p-4">€{{ item.precio.toFixed(2) }}</td>
              <td class="p-4">{{ item.cantidad }}</td>
              <td class="p-4 font-semibold text-blue-600 dark:text-blue-400">
                €{{ (item.precio * item.cantidad).toFixed(2) }}
              </td>
              <td class="p-4">
                <button @click="eliminarDelCarrito(item.id)"
                  class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition">
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-500 mt-10">
        Tu carrito está vacío.
      </div>

      <div v-if="cart.length" class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
        <span class="text-xl font-bold text-gray-800 dark:text-white">
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
import axios from '@/utils/axios'
import BaseButton from '@/views/components/BaseButton.vue'

const cart = ref([])
const loading = ref(false)

const getCart = async () => {
  try {
    const response = await axios.get('/cart')
    cart.value = response.data.cart || []
  } catch (error) {
    console.error('Error al obtener el carrito', error)
  }
}

const eliminarDelCarrito = async (id) => {
  try {
    await axios.delete(`/cart/${id}`)
    cart.value = cart.value.filter(item => item.id !== id)
  } catch (error) {
    console.error('Error al eliminar del carrito', error)
  }
}

const finalizarCompra = async () => {
  loading.value = true
  try {
    const response = await axios.post('/orders')
    cart.value = []
    alert('✅ Compra realizada correctamente. Pedido ID: ' + response.data.order.id)
  } catch (error) {
    alert('❌ Error al finalizar la compra. Intenta de nuevo.')
    console.error(error)
  } finally {
    loading.value = false
  }
}


const vaciarCarrito = async () => {
  try {
    await axios.post('/cart/clear')
    cart.value = []
  } catch (error) {
    console.error('Error al vaciar carrito', error)
  }
}


const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.precio * item.cantidad, 0)
)

onMounted(getCart)
</script>
