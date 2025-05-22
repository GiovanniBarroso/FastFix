<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen text-gray-800 dark:text-gray-100">
    <div class="max-w-7xl mx-auto px-6">

      <!-- Botón de volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>
      
      <!-- Encabezado -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">
          🔧 Servicios de reparación
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Reparamos tus dispositivos de forma rápida, segura y garantizada. Consulta tus solicitudes registradas:
        </p>
      </div>

      <!-- Reparaciones -->
      <div v-if="repairs.length" class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
        <div
          v-for="r in repairs"
          :key="r.id"
          @click="toggleDetalle(r.id)"
          class="cursor-pointer bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 transform transition-transform duration-300 hover:scale-105 hover:shadow-xl"
          :class="{
            'border-yellow-500': r.status === 'pendiente',
            'border-blue-500': r.status === 'en progreso',
            'border-green-500': r.status === 'terminado',
            'border-gray-500': r.status === 'entregado',
          }"
        >
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold">
              {{ r.device_type }} - {{ r.name }}
            </h2>
            <span
              class="text-xs font-semibold px-2 py-1 rounded-full capitalize"
              :class="estadoColor(r.status)"
            >
              {{ r.status }}
            </span>
          </div>

          <p class="text-sm text-gray-600 dark:text-gray-300">
            {{ r.problem_description }}
          </p>

          <transition name="fade">
            <div v-if="detalleVisible === r.id" class="mt-4 space-y-1 text-sm text-gray-700 dark:text-gray-300">
              <p><strong>Notas:</strong> {{ r.repair_notes || '—' }}</p>
              <p><strong>Garantía:</strong> {{ traducirGarantia(r.garantia) }}</p>
              <p><strong>Precio:</strong> {{ r.repair_cost ? `€${r.repair_cost}` : 'Pendiente' }}</p>
              <p><strong>Recibido:</strong> {{ formatDate(r.received_at) }}</p>
              <p><strong>Entregado:</strong> {{ formatDate(r.delivered_at) || '—' }}</p>
              <p class="text-xs italic text-gray-400">Haz clic para ocultar detalles.</p>
            </div>
          </transition>
        </div>
      </div>

      <!-- Sin resultados -->
      <div v-else class="text-center text-red-600 dark:text-red-400 mt-10">
        <h2 class="text-2xl font-semibold">❌ No tienes solicitudes de reparación registradas.</h2>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const repairs = ref([])
const detalleVisible = ref(null)

const formatDate = (fecha) => {
  if (!fecha) return null
  return new Date(fecha).toLocaleDateString('es-ES')
}

const traducirGarantia = (valor) => {
  switch (valor) {
    case '3m': return '3 meses'
    case '6m': return '6 meses'
    default: return 'Sin garantía'
  }
}

const estadoColor = (estado) => ({
  pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-white',
  'en progreso': 'bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-white',
  terminado: 'bg-green-100 text-green-800 dark:bg-green-600 dark:text-white',
  entregado: 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-white',
}[estado] || 'bg-gray-100 text-gray-800')

const toggleDetalle = (id) => {
  detalleVisible.value = detalleVisible.value === id ? null : id
}

onMounted(async () => {
  try {
    const response = await api.get('/repairs')
    repairs.value = response.data
  } catch (error) {
    console.error('Error al cargar reparaciones:', error)
  }
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
