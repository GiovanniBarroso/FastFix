<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-10">
        🧾 Lista de Pedidos
      </h1>

      <div v-if="orders.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
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
              v-for="(order, index) in orders"
              :key="order.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ order.user?.name || 'Sin nombre' }}</td>
              <td class="p-4">{{ formatDate(order.fecha_pedido) }}</td>
              <td class="p-4 font-mono font-bold">€{{ parseFloat(order.total).toFixed(2) }}</td>
              <td class="p-4">
                <span
                  :class="[ 'px-3 py-1 rounded-full text-xs font-semibold',
                    traducirEstado(order.estado) === 'Entregado'
                      ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white'
                      : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white'
                  ]"
                >
                  {{ traducirEstado(order.estado) }}
                </span>
              </td>
              <td class="p-4">
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-1 rounded transition font-semibold"
                >
                  Ver detalle
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
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const orders = ref([])

const formatDate = (fecha) => {
  const date = new Date(fecha)
  return date.toLocaleDateString('es-ES')
}

const traducirEstado = (estado) => {
  const map = {
    pendiente: 'En proceso',
    pagado: 'Entregado',
    enviado: 'Enviado',
    cancelado: 'Cancelado'
  }
  return map[estado] || estado
}

onMounted(async () => {
  try {
    const response = await api.get('/orders')
    console.log('Pedidos cargados:', response.data)
    orders.value = response.data
  } catch (error) {
    console.error('Error al cargar pedidos:', error)
  }
})
</script>
