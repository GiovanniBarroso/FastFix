<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-8">
        🧾 Lista de Pedidos
      </h1>

      <!-- Filtro rápido por estado -->
      <div class="flex justify-center mb-6 space-x-3">
        <button
          v-for="estado in ['todos', 'pendiente', 'pagado', 'enviado', 'cancelado']"
          :key="estado"
          @click="filtroEstado = estado"
          :class="[filtroEstado === estado ? 'bg-yellow-400 dark:bg-yellow-500' : 'bg-gray-200 dark:bg-gray-700', 'px-3 py-1 rounded-full text-xs font-semibold capitalize']"
        >
          {{ estado }}
        </button>
      </div>

      <div v-if="filteredOrders.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-yellow-400 dark:bg-yellow-500 text-gray-900 uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Usuario</th>
              <th class="p-4 text-left">Fecha</th>
              <th class="p-4 text-left">Total</th>
              <th class="p-4 text-left">Estado</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(order, index) in filteredOrders"
              :key="order.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ order.user?.name || 'Sin nombre' }}</td>
              <td class="p-4">{{ formatDate(order.fecha_pedido) }}</td>
              <td class="p-4 font-mono font-bold">€{{ parseFloat(order.total).toFixed(2) }}</td>
              <td class="p-4">
                <span
                  :class="statusClass(order.estado)"
                  class="px-3 py-1 rounded-full text-xs font-semibold capitalize"
                >
                  {{ traducirEstado(order.estado) }}
                </span>
              </td>
              <td class="p-4">
                <button
                  @click="openModal(order.id)"
                  class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-1 rounded transition font-semibold flex items-center space-x-1"
                >
                  <span>🔍</span><span>Ver detalle</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-10">
        No hay pedidos registrados aún.
      </div>
    </div>

    <!-- Modal de detalle del pedido -->
    <OrderFormModal :show="showModal" :order-id="selectedOrderId" @close="closeModal" />
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'
import OrderFormModal from '@/components/orders/OrderFormModal.vue'

const orders = ref([])
const filtroEstado = ref('todos')

const showModal = ref(false)
const selectedOrderId = ref(null)

const openModal = (id) => {
  selectedOrderId.value = id
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedOrderId.value = null
}

const formatDate = (fecha) => new Date(fecha).toLocaleDateString('es-ES')

const traducirEstado = (estado) => {
  const map = {
    pendiente: 'En proceso',
    pagado: 'Entregado',
    enviado: 'Enviado',
    cancelado: 'Cancelado',
  }
  return map[estado] || estado
}

const statusClass = (estado) => ({
  pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
  pagado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
  enviado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
  cancelado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
}[estado] || 'bg-gray-100 dark:bg-gray-700')

const filteredOrders = computed(() => {
  return filtroEstado.value === 'todos'
    ? orders.value
    : orders.value.filter(order => order.estado === filtroEstado.value)
})

onMounted(async () => {
  try {
    const response = await api.get('/orders')
    orders.value = response.data
  } catch (error) {
    console.error('Error al cargar pedidos:', error)
  }
})
</script>
