<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Título -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">🔧 Mis reparaciones</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">Consulta el estado de tus dispositivos en reparación.</p>
      </div>

      <!-- Tabla de reparaciones -->
      <div v-if="repairs.length" class="overflow-x-auto rounded-xl shadow-md bg-white dark:bg-gray-800">
        <table class="min-w-full text-sm text-gray-800 dark:text-gray-100">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="text-left px-6 py-4">#</th>
              <th class="text-left px-6 py-4">Dispositivo</th>
              <th class="text-left px-6 py-4">Problema</th>
              <th class="text-left px-6 py-4">Estado</th>
              <th class="text-left px-6 py-4">Fecha recibido</th>
              <th class="text-left px-6 py-4">Garantía</th>
              <th class="text-left px-6 py-4">Coste</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(repair, index) in repairs"
              :key="repair.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="px-6 py-4 font-medium">{{ index + 1 }}</td>
              <td class="px-6 py-4 font-semibold text-blue-600 dark:text-blue-400">{{ repair.nombre }}</td>
              <td class="px-6 py-4">{{ repair.problem_description }}</td>
              <td class="px-6 py-4">
                <span :class="['px-3 py-1 text-xs font-semibold rounded-full capitalize', estadoColor(repair.status)]">
                  {{ traducirEstado(repair.status) }}
                </span>
              </td>
              <td class="px-6 py-4">{{ formatDate(repair.received_at) }}</td>
              <td class="px-6 py-4 capitalize">{{ traducirGarantia(repair.garantia) }}</td>
              <td class="px-6 py-4 font-mono">€{{ parseFloat(repair.repair_cost || 0).toFixed(2) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sin reparaciones -->
      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg">
        Aún no tienes reparaciones registradas.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const repairs = ref([])

const fetchRepairs = async () => {
  try {
    const { data } = await api.get('/repairs')
    repairs.value = data
  } catch (error) {
    console.error('❌ Error al cargar reparaciones:', error)
  }
}

const formatDate = (fecha) => new Date(fecha).toLocaleDateString('es-ES')

const traducirEstado = (estado) => {
  const estados = {
    pendiente: 'Pendiente',
    'en progreso': 'En progreso',
    terminado: 'Terminado',
    entregado: 'Entregado',
  }
  return estados[estado] || estado
}

const traducirGarantia = (garantia) => {
  const map = {
    sin: 'Sin garantía',
    '3m': '3 meses',
    '6m': '6 meses'
  }
  return map[garantia] || garantia
}

const estadoColor = (estado) => ({
  pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
  'en progreso': 'bg-orange-100 text-orange-800 dark:bg-orange-600 dark:text-white',
  terminado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
  entregado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
}[estado] || 'bg-gray-100 dark:bg-gray-700')

onMounted(fetchRepairs)
</script>
