<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md backdrop-saturate-150 flex items-center justify-center px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
  >
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-2xl">
      <h2
        id="modal-title"
        class="text-2xl font-bold mb-8 flex items-center gap-2 text-gray-800 dark:text-white"
      >
        🧾 Detalle del Pedido <template v-if="order">#{{ order.id }}</template>
      </h2>

      <div v-if="order" class="space-y-5 text-gray-800 dark:text-gray-200">
        <!-- Información principal -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-6">
          <div><strong>Cliente:</strong> {{ order.user?.nombre || '—' }}</div>
          <div><strong>Fecha:</strong> {{ formatDate(order.fecha_pedido) }}</div>
          <div><strong>Dirección:</strong> {{ order.address?.direccion || '—' }}</div>
          <div>
            <strong>Total:</strong>
            <span class="font-bold font-mono">€{{ parseFloat(order.total || 0).toFixed(2) }}</span>
          </div>
          <div class="sm:col-span-2">
            <strong>Estado:</strong>
            <span
              :class="statusClass(order.estado)"
              class="ml-2 px-3 py-1 rounded-full text-xs font-semibold capitalize inline-block"
            >
              {{ traducirEstado(order.estado) }}
            </span>
          </div>
        </div>

        <!-- Productos -->
        <div>
          <strong>Productos:</strong>
          <div class="divide-y divide-gray-300 dark:divide-gray-600 mt-3">
            <div
              v-for="prod in order.products"
              :key="prod.id"
              class="py-2 flex justify-between items-center"
            >
              <div>
                <div class="font-medium">{{ prod.nombre || '—' }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                  Cantidad: x{{ prod.pivot?.cantidad || 0 }}
                </div>
              </div>
              <div class="text-sm font-mono whitespace-nowrap">
                €{{ parseFloat(prod.pivot?.precio || 0).toFixed(2) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-gray-500 dark:text-gray-400 text-center py-8">
        Cargando pedido...
      </div>

      <div class="flex justify-end gap-4 pt-8">
        <button
          @click="close"
          class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded font-semibold"
        >
          Cerrar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import api from '@/services/api'

const props = defineProps({
  show: Boolean,
  orderId: Number
})

const emit = defineEmits(['close'])

const order = ref(null)

const close = () => {
  order.value = null
  emit('close')
}

watch(
  () => props.show,
  async (visible) => {
    if (visible && props.orderId) {
      order.value = null
      try {
        const res = await api.get(`/orders/${props.orderId}`)
        order.value = res.data
      } catch (error) {
        console.error('Error al cargar el pedido:', error)
      }
    }
  }
)

const formatDate = (fecha) =>
  fecha ? new Date(fecha).toLocaleDateString('es-ES') : '—'

const traducirEstado = (estado) => {
  const map = {
    pendiente: 'En proceso',
    pagado: 'Entregado',
    enviado: 'Enviado',
    cancelado: 'Cancelado'
  }
  return map[estado] || estado
}

const statusClass = (estado) => ({
  pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
  pagado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
  enviado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
  cancelado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white'
}[estado] || 'bg-gray-100 dark:bg-gray-700')
</script>
