<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">🔧 Servicios de reparación</h1>
        <button
          @click="abrirModal()"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition"
        >
          + Añadir servicio
        </button>
      </div>

      <!-- Tabla de servicios -->
      <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-purple-500 dark:bg-purple-600 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Nombre</th>
              <th class="p-4 text-left">Descripción</th>
              <th class="p-4 text-left">Precio</th>
              <th class="p-4 text-left">Duración</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(reparacion, index) in reparaciones"
              :key="reparacion.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ reparacion.device_type }} {{ reparacion.model }}</td>
              <td class="p-4 max-w-md truncate" :title="reparacion.problem_description">
                {{ reparacion.problem_description }}
              </td>
              <td class="p-4 font-mono">€{{ reparacion.repair_cost !== null ? reparacion.repair_cost : '—' }}</td>
              <td class="p-4">{{ formatDuracion(reparacion.received_at, reparacion.delivered_at) }}</td>
              <td class="p-4 flex gap-2">
                <button
                  @click="abrirModal(reparacion)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-xs font-semibold"
                >
                  Editar
                </button>
                <button
                  @click="eliminarReparacion(reparacion.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-xs font-semibold"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <RepairFormModal
      :show="showModal"
      :repairToEdit="repairToEdit"
      @close="cerrarModal"
      @saved="fetchReparaciones"
    />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import RepairFormModal from '@/components/repairs/RepairFormModal.vue'

const reparaciones = ref([])
const showModal = ref(false)
const repairToEdit = ref(null)

const fetchReparaciones = async () => {
  try {
    const response = await api.get('/repairs')
    reparaciones.value = response.data
  } catch (error) {
    console.error('Error al cargar servicios de reparación:', error)
  }
}

const abrirModal = (reparacion = null) => {
  repairToEdit.value = reparacion
  showModal.value = true
}

const cerrarModal = () => {
  repairToEdit.value = null
  showModal.value = false
}

const eliminarReparacion = async (id) => {
  if (confirm('¿Estás seguro de que quieres eliminar esta reparación?')) {
    try {
      await api.delete(`/repairs/${id}`)
      fetchReparaciones()
    } catch (error) {
      console.error('Error al eliminar reparación:', error)
    }
  }
}

const formatDuracion = (start, end) => {
  if (!start || !end) return '—'
  const inicio = new Date(start)
  const fin = new Date(end)
  const dias = Math.round((fin - inicio) / (1000 * 60 * 60 * 24))
  return `${dias} día${dias === 1 ? '' : 's'}`
}

onMounted(() => {
  fetchReparaciones()
})
</script>
