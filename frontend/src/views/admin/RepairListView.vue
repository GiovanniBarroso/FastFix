<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      
      <!-- Botón de volver reutilizable -->
      <div class="mb-6">
        <BackButtonAdmin />
      </div>

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
<div class="w-full overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
  <table class="w-full table-fixed text-xs sm:text-sm text-gray-700 dark:text-gray-200">
    <thead class="bg-purple-500 dark:bg-purple-600 text-white text-xs uppercase tracking-wider">
      <tr>
        <th class="p-3 w-6">#</th>
        <th class="p-3 w-22">Tipo</th>
        <th class="p-3 w-36">Nombre</th>
        <th class="p-3 w-74 truncate">Problema</th>
        <th class="p-3 w-20">Precio</th>
        <th class="p-3 w-20">Garantía</th>
        <th class="p-3 w-24">Recibido</th>
        <th class="p-3 w-20">Entregado</th>
        <th class="p-3 w-28">Estado</th>
        <th class="p-3 w-18">Cliente</th>
        <th class="p-3 w-24">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(reparacion, index) in reparaciones"
        :key="reparacion.id"
        class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
      >
        <td class="p-3">{{ index + 1 }}</td>
        <td class="p-3">{{ reparacion.device_type }}</td>
        <td class="p-3 font-medium truncate">{{ reparacion.nombre }}</td>
        <td class="p-3 truncate" :title="reparacion.problem_description">
          {{ reparacion.problem_description }}
        </td>
        <td class="p-3 font-mono">
          {{ reparacion.repair_cost !== null ? `€${reparacion.repair_cost}` : '—' }}
        </td>
        <td class="p-3">{{ traducirGarantia(reparacion.garantia) }}</td>
        <td class="p-3">{{ formatFecha(reparacion.received_at) }}</td>
        <td class="p-3">{{ formatFecha(reparacion.delivered_at) }}</td>
        <td class="p-3">
          <span
            class="inline-block text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap"
            :class="estadoColor(reparacion.status)"
          >
            {{ reparacion.status }}
          </span>
        </td>
        <td class="p-3 truncate">{{ reparacion.user?.nombre || '—' }}</td>
        <td class="p-3 flex flex-col gap-1">
          <button
            @click="abrirModal(reparacion)"
            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold"
          >
            Editar
          </button>
          <button
            @click="eliminarReparacion(reparacion.id)"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold"
          >
            Eliminar
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>


    </div>

    <!-- Modal de edición -->
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
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

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

const traducirGarantia = (valor) => {
  switch (valor) {
    case '3m': return '3 meses'
    case '6m': return '6 meses'
    default: return 'Sin garantía'
  }
}

const formatFecha = (fecha) => {
  if (!fecha) return '—'
  return new Date(fecha).toLocaleDateString('es-ES')
}


const estadoColor = (estado) => {
  switch (estado) {
    case 'pendiente':
      return 'bg-yellow-100 text-yellow-800'
    case 'en progreso':
      return 'bg-blue-100 text-blue-800'
    case 'terminado':
      return 'bg-green-100 text-green-800'
    case 'entregado':
      return 'bg-gray-100 text-gray-800'
    default:
      return ''
  }
}

onMounted(fetchReparaciones)
</script>
