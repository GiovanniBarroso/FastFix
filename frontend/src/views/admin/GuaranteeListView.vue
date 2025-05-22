<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

      <!-- Botón de volver reutilizable -->
      <div class="mb-6">
        <BackButtonAdmin />
      </div>
      
      <!-- Título y botón -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">
          🛡️ Gestión de Garantías
        </h1>
        <button
          @click="abrirModal()"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition"
        >
          + Añadir garantía
        </button>
      </div>

      <!-- Tabla -->
      <div v-if="garantias.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-md">
        <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
          <thead class="bg-green-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Cliente</th>
              <th class="p-4 text-left">Email</th>
              <th class="p-4 text-left">Producto</th>
              <th class="p-4 text-left">Inicio</th>
              <th class="p-4 text-left">Fin</th>
              <th class="p-4 text-left">Estado</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(garantia, index) in garantias"
              :key="garantia.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ garantia.user?.name || '—' }}</td>
              <td class="p-4">{{ garantia.user?.email || '—' }}</td>
              <td class="p-4">{{ garantia.product?.name || '—' }}</td>
              <td class="p-4">{{ formatDate(garantia.fecha_inicio) }}</td>
              <td class="p-4">{{ formatDate(garantia.fecha_fin) }}</td>
              <td class="p-4">
                <span
                  class="px-3 py-1 rounded-full text-xs font-semibold"
                  :class="isActive(garantia.fecha_fin)
                    ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                    : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100'"
                >
                  {{ isActive(garantia.fecha_fin) ? 'Activa' : 'Expirada' }}
                </span>
              </td>
              <td class="p-4 flex gap-2">
                <button
                  @click="abrirModal(garantia)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold"
                >
                  ✏️ Editar
                </button>
                <button
                  @click="eliminarGarantia(garantia.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold"
                >
                  🗑️ Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sin datos -->
      <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-10">
        No hay garantías registradas aún.
      </div>
    </div>

    <!-- Modal -->
    <GuaranteeFormModal
      :show="showModal"
      :guaranteeToEdit="guaranteeToEdit"
      @close="cerrarModal"
      @saved="fetchGarantias"
    />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import GuaranteeFormModal from '@/components/guarantees/GuaranteeFormModal.vue'
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

const garantias = ref([])
const showModal = ref(false)
const guaranteeToEdit = ref(null)

const fetchGarantias = async () => {
  try {
    const response = await api.get('/guarantees')
    garantias.value = response.data
  } catch (error) {
    console.error('Error al cargar garantías:', error)
  }
}

const eliminarGarantia = async (id) => {
  if (confirm('¿Seguro que quieres eliminar esta garantía?')) {
    try {
      await api.delete(`/guarantees/${id}`)
      await fetchGarantias()
    } catch (error) {
      console.error('Error al eliminar garantía:', error)
    }
  }
}

const formatDate = (fecha) => {
  const date = new Date(fecha)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const isActive = (fechaFin) => new Date(fechaFin) >= new Date()

const abrirModal = (garantia = null) => {
  guaranteeToEdit.value = garantia
  showModal.value = true
}

const cerrarModal = () => {
  guaranteeToEdit.value = null
  showModal.value = false
}

onMounted(fetchGarantias)
</script>
