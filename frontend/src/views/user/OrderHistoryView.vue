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
            <tr
              v-for="(order, index) in orders"
              :key="order.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="px-6 py-4 font-medium">{{ index + 1 }}</td>
              <td class="px-6 py-4">{{ formatDate(order.fecha_pedido) }}</td>
              <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400">
                €{{ parseFloat(order.total).toFixed(2) }}
              </td>
              <td class="px-6 py-4">
                <span
                  :class="['px-3 py-1 text-xs font-semibold rounded-full capitalize', estadoColor(order.estado)]"
                >
                  {{ traducirEstado(order.estado) }}
                </span>
              </td>
              <td class="px-6 py-4">
                <button
                  @click="abrirModal(order)"
                  class="text-sm px-4 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition font-semibold"
                >
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

      <!-- Modal -->
      <transition name="fade">
        <div v-if="detallePedido" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-xl w-full p-6 relative">
            <button @click="detallePedido = null" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-xl">×</button>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">📝 Detalle del pedido</h2>

            <p class="mb-2 text-gray-800 dark:text-gray-200"><strong>Fecha:</strong> {{ formatDate(detallePedido.fecha_pedido) }}</p>
            <p class="mb-2 text-gray-800 dark:text-gray-200"><strong>Total:</strong> €{{ parseFloat(detallePedido.total).toFixed(2) }}</p>
            <p class="mb-4 text-gray-800 dark:text-gray-200"><strong>Estado:</strong> {{ traducirEstado(detallePedido.estado) }}</p>

            <div class="border-t border-gray-300 dark:border-gray-600 pt-4">
              <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">🛍️ Productos:</h3>
              <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                <li v-for="prod in detallePedido.products" :key="prod.id">
                  - {{ prod.name }} x{{ prod.pivot.cantidad }} (€/u {{ prod.pivot.precio }})
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
