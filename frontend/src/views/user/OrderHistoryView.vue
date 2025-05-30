<template>
  <section class="py-12 bg-[#F8F9FA] dark:bg-[#1E2A38] min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón de volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#007BFF] to-[#5E6C77] animate-glow">
          📦 Historial de pedidos
        </h1>
      </div>

      <!-- Tabla de pedidos -->
      <div class="overflow-x-auto bg-white dark:bg-[#1E2A38] rounded-2xl shadow-xl animate-fade-up">
        <table class="min-w-full text-sm text-[#1E2A38] dark:text-[#F8F9FA]">
          <thead class="bg-gradient-to-r from-[#FFBF00] to-[#007BFF] text-[#1E2A38] dark:text-white">
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Fecha</th>
              <th class="p-4 text-left font-semibold tracking-wide">Estado</th>
              <th class="p-4 text-left font-semibold tracking-wide">Total</th>
              <th class="p-4 text-left font-semibold tracking-wide">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(order, index) in orders"
              :key="order.id"
              class="border-t border-[#E5E7EB] dark:border-[#5E6C77] hover:bg-[#F8F9FA] dark:hover:bg-[#2C3E50] transition">
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4">{{ formatDate(order.created_at) }}</td>
              <td class="p-4">
                <span
                  :class="estadoColor(order.estado)"
                  class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full shadow-sm">
                  {{ traducirEstado(order.estado) }}
                </span>
              </td>
              <td class="p-4 font-bold text-end text-[#007BFF]">€{{ order.total }}</td>
              <td class="p-4 text-center">
                <button
                  @click="abrirModal(order)"
                  class="bg-[#007BFF] hover:bg-[#005BB5] text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105">
                  📄 Ver detalle
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <transition name="fade">
      <div v-if="detallePedido" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-sm flex items-center justify-center px-4">
        <div class="bg-white dark:bg-[#1E2A38] rounded-2xl shadow-2xl max-w-2xl w-full p-6 relative animate-fade-up">
          <button @click="detallePedido = null" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl font-bold">
            ×
          </button>
          <h2 class="text-2xl font-bold mb-6 text-[#1E2A38] dark:text-[#F8F9FA] flex items-center gap-2">
            🧾 Detalle del Pedido #{{ detallePedido.id }}
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-[#1E2A38] dark:text-[#F8F9FA] text-sm mb-6">
            <div><strong>📅 Fecha:</strong> {{ formatDate(detallePedido.created_at) }}</div>
            <div><strong>💶 Total:</strong> €{{ parseFloat(detallePedido.total).toFixed(2) }}</div>
            <div class="sm:col-span-2">
              <strong>📦 Estado:</strong>
              <span :class="estadoColor(detallePedido.estado)" class="ml-2 px-3 py-1 rounded-full text-xs font-semibold capitalize inline-block">
                {{ traducirEstado(detallePedido.estado) }}
              </span>
            </div>
          </div>

          <div class="border-t border-gray-300 dark:border-[#5E6C77] pt-4">
            <h3 class="font-semibold text-lg mb-3 text-[#1E2A38] dark:text-[#F8F9FA]">
              🛒 Productos adquiridos:
            </h3>
            <ul class="space-y-4">
              <li
                v-for="prod in detallePedido.products"
                :key="prod.id"
                class="flex items-center gap-4 bg-[#F8F9FA] dark:bg-[#2C3E50] px-4 py-4 rounded-xl shadow-sm">
                <img :src="getImageUrl(prod.image)" alt="Imagen del producto" class="w-16 h-16 object-cover rounded-md border border-gray-300 dark:border-[#5E6C77]" />
                <div class="flex-1">
                  <div class="font-semibold text-[#1E2A38] dark:text-[#F8F9FA]">
                    {{ prod.nombre }}
                  </div>
                  <div class="text-xs text-[#5E6C77] dark:text-[#E5E7EB]">
                    x{{ prod.pivot.cantidad }} • €/u {{ parseFloat(prod.pivot.precio).toFixed(2) }}
                  </div>
                </div>
                <div class="font-mono text-sm font-bold text-right text-[#1E2A38] dark:text-[#F8F9FA]">
                  €{{ (prod.pivot.precio * prod.pivot.cantidad).toFixed(2) }}
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </transition>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const orders = ref([])
const detallePedido = ref(null)

const getImageUrl = (filename) => {
  if (!filename) return '/images/default.jpg'
  return `/products/${filename}`
}

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

const estadoColor = (estado) =>
  ({
    pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
    pagado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
    enviado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
    cancelado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
  })[estado] || 'bg-gray-100 dark:bg-gray-700'

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

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fadeIn 0.8s ease-out both;
}

@keyframes glow {
  0% {
    text-shadow: 0 0 5px rgba(0, 123, 255, 0.4), 0 0 10px rgba(0, 123, 255, 0.3);
  }
  100% {
    text-shadow: 0 0 12px rgba(255, 191, 0, 0.5), 0 0 20px rgba(255, 191, 0, 0.4);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}
</style>