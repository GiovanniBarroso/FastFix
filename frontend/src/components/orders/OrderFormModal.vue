<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm backdrop-saturate-150 flex items-center justify-center px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
  >
    <div
      class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-2xl border border-gray-200 dark:border-gray-700 animate-fade-up"
    >
      <!-- Título -->
      <h2
        id="modal-title"
        class="text-2xl font-extrabold mb-6 flex items-center gap-2 text-gray-800 dark:text-white"
      >
        🧾 Detalle del Pedido <template v-if="order">#{{ order.id }}</template>
      </h2>

      <!-- Si el pedido está cargado -->
      <div v-if="order" class="space-y-8 text-gray-800 dark:text-gray-200">
        <!-- 🧩 Información principal -->
        <div>
          <h3 class="text-lg font-bold mb-3 text-indigo-600 dark:text-indigo-400">
            Información del pedido
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-6 text-sm">
            <div><strong>👤 Cliente:</strong> {{ order.user?.nombre || '—' }}</div>
            <div><strong>📅 Fecha:</strong> {{ formatDate(order.fecha_pedido) }}</div>
            <div>
              <strong>💰 Total:</strong>
              <span class="font-bold font-mono text-green-600 dark:text-green-400">
                €{{ parseFloat(order.total || 0).toFixed(2) }}
              </span>
            </div>
            <div class="sm:col-span-2">
              <br /><strong>📝 Estado:</strong>
              <span
                :class="statusClass(order.estado)"
                class="ml-2 px-3 py-1 rounded-full text-xs font-semibold capitalize inline-block"
              >
                {{ traducirEstado(order.estado) }}
              </span>
            </div>
          </div>
        </div>

        <!-- 📦 Productos -->
        <div>
          <h3 class="text-lg font-bold mb-3 text-indigo-600 dark:text-indigo-400">
            Productos incluidos
          </h3>
          <div class="divide-y divide-gray-300 dark:divide-gray-600 rounded-xl overflow-hidden">
            <div
              v-for="prod in order.products"
              :key="prod.id"
              class="flex justify-between items-center px-4 py-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition"
            >
              <div>
                <div class="font-semibold">{{ prod.nombre || '—' }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                  Cantidad: x{{ prod.pivot?.cantidad || 0 }}
                </div>
              </div>
              <div class="text-sm font-mono text-green-600 dark:text-green-400 whitespace-nowrap">
                €{{ parseFloat(prod.pivot?.precio || 0).toFixed(2) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Cargando... -->
      <div v-else class="text-center text-gray-500 dark:text-gray-400 py-8">
        ⏳ Cargando pedido...
      </div>

      <!-- Botón de cierre -->
      <div class="flex justify-end pt-8">
        <button
          @click="close"
          class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg font-semibold flex items-center gap-2 transition"
        >
          ❌ Cerrar
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
  orderId: Number,
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
  },
)

const formatDate = (fecha) => (fecha ? new Date(fecha).toLocaleDateString('es-ES') : '—')

const traducirEstado = (estado) => {
  const map = {
    pendiente: 'Pendiente',
    pagado: 'Pagado',
    cancelado: 'Cancelado',
  }
  return map[estado] || estado
}

const statusClass = (estado) =>
  ({
    pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
    pagado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
    cancelado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
  })[estado] || 'bg-gray-100 dark:bg-gray-700'
</script>
