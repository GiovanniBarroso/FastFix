<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón de volver reutilizable -->
      <div class="mb-6" data-aos="fade-left">
        <BackButtonAdmin />
      </div>

      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10" data-aos="fade-right">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">
          🔧
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500">
            Servicios de reparación
          </span>
        </h1>
        <button
          @click="abrirModal()"
          class="bg-gradient-to-r from-green-500 to-emerald-600 hover:to-emerald-700 text-white font-semibold px-6 py-2 rounded-full shadow-lg transition hover:scale-105"
          data-aos="zoom-in"
        >
          + Añadir servicio
        </button>
      </div>

      <!-- Tabla de servicios -->
      <div
        class="w-full overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
        data-aos="fade-up"
      >
        <table
          class="min-w-full w-full table-auto text-xs sm:text-sm text-gray-700 dark:text-gray-200"
        >
          <thead
            class="bg-gradient-to-r from-purple-600 to-fuchsia-600 text-white text-xs uppercase tracking-wider"
          >
            <tr>
              <th class="px-4 py-3 text-left whitespace-nowrap">#</th>
              <th class="px-4 py-3 text-left whitespace-nowrap">Tipo</th>
              <th class="px-4 py-3 text-left whitespace-nowrap">Nombre</th>
              <th class="px-4 py-3 text-left truncate max-w-[200px]">Problema</th>
              <th class="px-4 py-3 text-left whitespace-nowrap">Precio</th>
              <th class="px-4 py-3 text-left">Garantía</th>
              <th class="px-4 py-3 text-left whitespace-nowrap">Recibido</th>
              <th class="px-4 py-3 text-left whitespace-nowrap">Entregado</th>
              <th class="px-4 py-3 text-left">Estado</th>
              <th class="px-4 py-3 text-left">Cliente</th>
              <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(reparacion, index) in reparaciones"
              :key="reparacion.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <td class="p-3 text-center font-semibold">{{ index + 1 }}</td>
              <td class="p-3 font-medium">{{ reparacion.device_type }}</td>
              <td class="p-3 font-semibold truncate">{{ reparacion.nombre }}</td>
              <td class="px-4 py-3 truncate max-w-[200px]">{{ reparacion.problem_description }}</td>
              <td class="p-3 font-mono font-bold text-green-600 dark:text-green-400">
                {{ reparacion.repair_cost !== null ? `€${reparacion.repair_cost}` : '—' }}
              </td>
              <td class="p-3">{{ traducirGarantia(reparacion.garantia) }}</td>
              <td class="p-3">{{ formatFecha(reparacion.received_at) }}</td>
              <td class="p-3">{{ formatFecha(reparacion.delivered_at) }}</td>
              <td class="p-3">
                <span
                  class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full shadow-sm whitespace-nowrap"
                  :class="estadoColor(reparacion.status)"
                >
                  {{ reparacion.status }}
                </span>
              </td>
              <td class="p-3 truncate font-medium text-gray-800 dark:text-gray-100">
                {{ reparacion.user?.nombre || '—' }}
              </td>
              <td class="p-3 flex gap-2">
                <button
                  @click="abrirModal(reparacion)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  ✏️ Editar
                </button>
                <button
                  @click="eliminarReparacion(reparacion.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  🗑️ Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
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
import AOS from 'aos'
import 'aos/dist/aos.css'

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
    case '3m':
      return '3 meses'
    case '6m':
      return '6 meses'
    default:
      return 'Sin garantía'
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

onMounted(() => {
  fetchReparaciones()
  AOS.init({ duration: 800, once: true })
})
</script>
