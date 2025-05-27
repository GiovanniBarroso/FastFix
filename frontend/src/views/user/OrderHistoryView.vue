<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Título -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">📦 Historial de pedidos</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">Consulta tus compras realizadas en FastFix.</p>
      </div>

      <!-- Tabla -->
      <div v-if="orders.length" class="overflow-x-auto rounded-xl shadow-md bg-white dark:bg-gray-800">
        <table class="min-w-full text-sm text-gray-800 dark:text-gray-100">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="text-left px-6 py-4">#</th>
              <th class="text-left px-6 py-4">Fecha</th>
              <th class="text-left px-6 py-4">Total</th>
              <th class="text-left px-6 py-4">Estado</th>
              <th class="text-left px-6 py-4">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(order, index) in orders" :key="order.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
              <td class="px-6 py-4 font-medium">{{ index + 1 }}</td>
              <td class="px-6 py-4">{{ formatDate(order.created_at) }}</td>
              <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400">
                €{{ parseFloat(order.total).toFixed(2) }}
              </td>
              <td class="px-6 py-4">
                <span :class="['px-3 py-1 text-xs font-semibold rounded-full capitalize', estadoColor(order.estado)]">
                  {{ traducirEstado(order.estado) }}
                </span>
              </td>
              <td class="px-6 py-4">
                <button @click="abrirModal(order)"
                  class="text-sm px-4 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition font-semibold">
                  Ver detalle
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg">
        Aún no tienes pedidos realizados.
      </div>

      <!-- Modal Detalle -->
      <transition name="fade">
  <div
    v-if="detallePedido"
    class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md backdrop-saturate-150 flex items-center justify-center px-4"
  >
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-2xl w-full p-6 relative">
      <!-- Botón cerrar -->
      <button
        @click="detallePedido = null"
        class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl font-bold"
      >
        ×
      </button>

      <!-- Título -->
      <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white flex items-center gap-2">
        🧾 Detalle del Pedido #{{ detallePedido.id }}
      </h2>

      <!-- Info general -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-800 dark:text-gray-200 text-sm mb-6">
        <div><strong>📅 Fecha:</strong> {{ formatDate(detallePedido.created_at) }}</div>
        <div><strong>💶 Total:</strong> €{{ parseFloat(detallePedido.total).toFixed(2) }}</div>
        <div class="sm:col-span-2">
          <strong>📦 Estado:</strong>
          <span
            :class="estadoColor(detallePedido.estado)"
            class="ml-2 px-3 py-1 rounded-full text-xs font-semibold capitalize inline-block"
          >
            {{ traducirEstado(detallePedido.estado) }}
          </span>
        </div>
      </div>

      <!-- Productos -->
      <div class="border-t border-gray-300 dark:border-gray-700 pt-4">
        <h3 class="font-semibold text-lg mb-3 text-gray-900 dark:text-white">🛒 Productos adquiridos:</h3>
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
  <li
    v-for="prod in detallePedido.products"
    :key="prod.id"
    class="py-4 flex items-center gap-4 bg-gray-50 dark:bg-gray-900 px-4 rounded-lg my-2"
  >
    <img
      :src="prod.imagen"
      alt="Imagen del producto"
      class="w-16 h-16 object-cover rounded-md border border-gray-300 dark:border-gray-600"
    />
    <div class="flex-1">
      <div class="font-semibold text-gray-800 dark:text-gray-100">{{ prod.nombre }}</div>
      <div class="text-xs text-gray-600 dark:text-gray-400">
        x{{ prod.pivot.cantidad }} &nbsp; • &nbsp; €/u {{ parseFloat(prod.pivot.precio).toFixed(2) }}
      </div>
    </div>
    <div class="font-mono text-sm font-bold text-gray-900 dark:text-white text-right">
      €{{ (prod.pivot.precio * prod.pivot.cantidad).toFixed(2) }}
    </div>
  </li>
</ul>

      </div>
    </div>
  </div>
</transition>


    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const orders = ref([])
const detallePedido = ref(null)

const fetchOrders = async () => {
  try {
    const response = await api.get('/orders')
    orders.value = response.data
  } catch (error) {
    console.error('❌ Error al cargar pedidos:', error)
  }
}

const abrirModal = (order) => {
  detallePedido.value = order
}

const formatDate = (fecha) => new Date(fecha).toLocaleDateString('es-ES')

const traducirEstado = (estado) => {
  const estados = {
    pendiente: 'En proceso',
    pagado: 'Entregado',
    enviado: 'Enviado',
    cancelado: 'Cancelado',
  }
  return estados[estado] || estado
}

const estadoColor = (estado) => ({
  pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
  pagado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
  enviado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
  cancelado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
}[estado] || 'bg-gray-100 dark:bg-gray-700')

onMounted(fetchOrders)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
