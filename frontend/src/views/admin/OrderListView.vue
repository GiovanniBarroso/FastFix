<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonAdmin />
      </div>

      <!-- Título -->
      <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-10">
        🧾 Lista de Pedidos
      </h1>

      <!-- Filtro por estado -->
      <div class="flex justify-center mb-8 gap-2 flex-wrap">
        <button
          v-for="estado in ['todos', 'pendiente', 'pagado', 'enviado', 'cancelado']"
          :key="estado"
          @click="filtroEstado = estado"
          :class="[
            'px-4 py-1 rounded-full text-xs font-semibold capitalize transition',
            filtroEstado === estado
              ? 'bg-yellow-500 text-white shadow'
              : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white'
          ]"
        >
          {{ estado }}
        </button>
      </div>

      <!-- Tabla -->
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
              <td class="p-4 font-medium">{{ order.user?.nombre || '—' }}</td>
              <td class="p-4">{{ formatDate(order.fecha_pedido) }}</td>
              <td class="p-4 font-mono font-bold">€{{ parseFloat(order.total).toFixed(2) }}</td>
              <td class="p-4">
                <span
                  class="px-3 py-1 rounded-full text-xs font-semibold capitalize"
                  :class="statusClass(order.estado)"
                >
                  {{ traducirEstado(order.estado) }}
                </span>
              </td>
              <td class="p-4">
                <button
                  @click="openModal(order.id)"
                  class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-1 rounded transition font-semibold flex items-center gap-1"
                >
                  🔍 Ver detalle
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sin resultados -->
      <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-10">
        No hay pedidos registrados con este estado.
      </div>
    </div>

    <!-- Modal -->
    <OrderFormModal :show="showModal" :order-id="selectedOrderId" @close="closeModal" />
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'
import OrderFormModal from '@/components/orders/OrderFormModal.vue'
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

const orders = ref([])
const filtroEstado = ref('todos')

const showModal = ref(false)
const selectedOrderId = ref(null)

const openModal = (id) => {
  selectedOrderId.value = id
  showModal.value = true
}

const closeModal = () => {
  selectedOrderId.value = null
  showModal.value = false
}

const formatDate = (fecha) => {
  if (!fecha) return '—'
  const date = new Date(fecha)
  return isNaN(date) ? '—' : date.toLocaleDateString('es-ES')
}

const traducirEstado = (estado) => ({
  pendiente: 'En proceso',
  pagado: 'Entregado',
  enviado: 'Enviado',
  cancelado: 'Cancelado'
}[estado] || estado)

const statusClass = (estado) => ({
  pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
  pagado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
  enviado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
  cancelado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
}[estado] || 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white')

const filteredOrders = computed(() => {
  return filtroEstado.value === 'todos'
    ? orders.value
    : orders.value.filter(o => o.estado === filtroEstado.value)
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
