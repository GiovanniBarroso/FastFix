<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
      <div class="mb-6" data-aos="fade-right">
        <BackButtonAdmin />
      </div>

      <h1
        class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-10"
        data-aos="fade-up"
      >
        📝 Solicitudes de Presupuesto
      </h1>

      <!-- Tabla pendientes -->
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4" data-aos="fade-up">
        📩 Pendientes
      </h2>
      <div
        v-if="pendientes.length"
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md mb-12"
        data-aos="fade-up"
      >
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-blue-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Nombre</th>
              <th class="p-4 text-left">Email</th>
              <th class="p-4 text-left">Teléfono</th>
              <th class="p-4 text-left">Mensaje</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(solicitud, index) in pendientes"
              :key="solicitud.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ solicitud.user?.nombre || '—' }}</td>
              <td class="p-4">{{ solicitud.user?.email || '—' }}</td>
              <td class="p-4">{{ solicitud.user?.telefono || '—' }}</td>
              <td class="p-4 max-w-sm">
                <div
                  class="truncate bg-gray-100 dark:bg-gray-700 p-2 rounded"
                  :title="solicitud.mensaje"
                >
                  {{ solicitud.mensaje }}
                </div>
              </td>
              <td class="p-4">
                <div class="flex items-center justify-start gap-2">
                  <button
                    @click="openModal(solicitud)"
                    class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs transition"
                  >
                    💌 Contactar
                  </button>
                  <button
                    @click="rechazarSolicitud(solicitud.id)"
                    class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition"
                  >
                    ❌ Rechazar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-gray-500 dark:text-gray-300 mb-12" data-aos="fade-up">
        No hay solicitudes pendientes.
      </div>

      <!-- Tabla respondidas -->
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4" data-aos="fade-up">
        ✅ Respondidas
      </h2>
      <div
        v-if="respondidas.length"
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md mb-12"
        data-aos="fade-up"
      >
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-blue-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Nombre</th>
              <th class="p-4 text-left">Email</th>
              <th class="p-4 text-left">Mensaje</th>
              <th class="p-4 text-left">Respuesta</th>
              <th class="p-4 text-left">Presupuesto</th>
              <th class="p-4 text-left">Respondido</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(solicitud, index) in respondidas"
              :key="solicitud.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ solicitud.user?.nombre || '—' }}</td>
              <td class="p-4">{{ solicitud.user?.email || '—' }}</td>
              <td class="p-4 max-w-sm">
                <div
                  class="truncate bg-gray-100 dark:bg-gray-700 p-2 rounded"
                  :title="solicitud.mensaje"
                >
                  {{ solicitud.mensaje }}
                </div>
              </td>
              <td class="p-4 max-w-sm">
                <div
                  class="truncate bg-gray-50 dark:bg-gray-800 p-2 rounded"
                  :title="solicitud.respuesta_admin"
                >
                  {{ solicitud.respuesta_admin || '—' }}
                </div>
              </td>
              <td class="p-4 font-mono">
                {{
                  solicitud.presupuesto_estimado !== null &&
                  solicitud.presupuesto_estimado !== undefined
                    ? `€${Number(solicitud.presupuesto_estimado)}`
                    : '—'
                }}
              </td>
              <td class="p-4">
                {{ formatFecha(solicitud.fecha_respuesta || solicitud.updated_at) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-gray-500 dark:text-gray-300 mb-12" data-aos="fade-up">
        No hay solicitudes respondidas.
      </div>

      <!-- Tabla rechazadas -->
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4" data-aos="fade-up">
        ❌ Rechazadas
      </h2>
      <div
        v-if="rechazadas.length"
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md"
        data-aos="fade-up"
      >
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-blue-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Nombre</th>
              <th class="p-4 text-left">Email</th>
              <th class="p-4 text-left">Teléfono</th>
              <th class="p-4 text-left">Mensaje</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(solicitud, index) in rechazadas"
              :key="solicitud.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ solicitud.user?.nombre || '—' }}</td>
              <td class="p-4">{{ solicitud.user?.email || '—' }}</td>
              <td class="p-4">{{ solicitud.user?.telefono || '—' }}</td>
              <td class="p-4 max-w-sm">
                <div
                  class="truncate bg-gray-100 dark:bg-gray-700 p-2 rounded"
                  :title="solicitud.mensaje"
                >
                  {{ solicitud.mensaje }}
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-gray-500 dark:text-gray-300" data-aos="fade-up">
        No hay solicitudes rechazadas.
      </div>
    </div>

    <!-- Modal de contacto -->
    <BudgetContactModal
      :show="showModal"
      :cliente="selectedCliente"
      @close="closeModal"
      @respondido="marcarComoRespondido"
    />
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/services/api'
import BudgetContactModal from '@/components/budgets/BudgetContactModal.vue'
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

const budgets = ref([])
const showModal = ref(false)
const selectedCliente = ref(null)

const pendientes = computed(() => budgets.value.filter((b) => b.estado === 'pendiente'))
const respondidas = computed(() => budgets.value.filter((b) => b.estado === 'respondido'))
const rechazadas = computed(() => budgets.value.filter((b) => b.estado === 'rechazado'))

const formatFecha = (fecha) => {
  if (!fecha) return '—'
  return new Date(fecha).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}

const openModal = (cliente) => {
  selectedCliente.value = cliente
  showModal.value = true
}

const closeModal = () => {
  selectedCliente.value = null
  showModal.value = false
}

const marcarComoRespondido = async (id) => {
  try {
    await api.put(`/budgets/${id}`, { estado: 'respondido' })
    await cargarPresupuestos()
  } catch (err) {
    console.error('Error al actualizar a respondido:', err)
  }
}

const rechazarSolicitud = async (id) => {
  if (!confirm('¿Seguro que quieres rechazar esta solicitud?')) return
  try {
    await api.put(`/budgets/${id}`, { estado: 'rechazado' })
    await cargarPresupuestos()
  } catch (err) {
    console.error('Error al rechazar solicitud:', err)
  }
}

const cargarPresupuestos = async () => {
  try {
    const res = await api.get('/budgets')
    budgets.value = res.data
  } catch (err) {
    console.error('Error cargando presupuestos:', err)
  }
}

onMounted(cargarPresupuestos)
</script>
