<template>
  <section class="py-14 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
      <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-8 text-center">
        🛒 Tu carrito de compras
      </h1>

      <div v-if="cart.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Resumen de productos</h2>
          <button
            @click="vaciarCarrito"
            class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-sm text-gray-800 dark:text-white px-4 py-2 rounded transition"
          >
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
            <tr
              v-for="(item, index) in cart"
              :key="item.id"
              class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 flex items-center gap-4">
                <img :src="item.imagen" class="w-14 h-14 rounded object-cover" alt="Producto" />
                <div>
                  <span class="block font-semibold text-gray-800 dark:text-white">{{ item.nombre }}</span>
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ item.marca }}</span>
                </div>
              </td>
              <td class="p-4">€{{ item.precio.toFixed(2) }}</td>
              <td class="p-4">{{ item.cantidad }}</td>
              <td class="p-4 font-semibold text-blue-600 dark:text-blue-400">
                €{{ (item.precio * item.cantidad).toFixed(2) }}
              </td>
              <td class="p-4 text-center">
                <button
                  @click="eliminarDelCarrito(item.id)"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs"
                >
                  Eliminar
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
    cart.value = response.data.cart?.length ? response.data.cart : mockProducts
  } catch {
    cart.value = mockProducts // Modo prueba si falla o backend sin conexión
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

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.precio * item.cantidad, 0)
)

//Prodcutos de prueba, falta enlazarlo con la bbdd
const mockProducts = [
  {
    id: 1,
    nombre: 'Funda antigolpes iPhone 14',
    marca: 'Spigen',
    precio: 12.99,
    cantidad: 1,
    imagen: 'https://via.placeholder.com/100x100'
  },
  {
    id: 2,
    nombre: 'Cable USB-C trenzado',
    marca: 'Baseus',
    precio: 6.5,
    cantidad: 2,
    imagen: 'https://via.placeholder.com/100x100'
  }
]

onMounted(getCart)
</script>
