<template>
  <section class="py-12 bg-[#F8F9FA] dark:bg-[#1E2A38] min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1
          class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#FFBF00] to-[#007BFF] animate-glow"
        >
          🔧 Mis reparaciones
        </h1>
      </div>

      <!-- Tabla de reparaciones -->
      <div
        v-if="repairs.length"
        class="overflow-x-auto bg-white dark:bg-[#1E2A38] rounded-2xl shadow-xl animate-fade-up"
      >
        <table class="min-w-full text-sm text-[#1E2A38] dark:text-[#F8F9FA]">
          <thead
            class="bg-gradient-to-r from-[#FFBF00] to-[#007BFF] text-[#1E2A38] dark:text-white"
          >
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Dispositivo</th>
              <th class="p-4 text-left font-semibold tracking-wide">Problema</th>
              <th class="p-4 text-left font-semibold tracking-wide">Estado</th>
              <th class="p-4 text-left font-semibold tracking-wide">Fecha recibido</th>
              <th class="p-4 text-left font-semibold tracking-wide">Garantía</th>
              <th class="p-4 text-left font-semibold tracking-wide">Coste</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(repair, index) in repairs"
              :key="repair.id"
              class="border-t border-[#E5E7EB] dark:border-[#5E6C77] hover:bg-[#F8F9FA] dark:hover:bg-[#2C3E50] transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4 font-semibold text-[#007BFF]">{{ repair.nombre }}</td>
              <td class="p-4">{{ repair.problem_description }}</td>
              <td class="p-4">
                <span
                  :class="[
                    'px-3 py-1 text-xs font-semibold rounded-full capitalize',
                    estadoColor(repair.status),
                  ]"
                >
                  {{ traducirEstado(repair.status) }}
                </span>
              </td>
              <td class="p-4">{{ formatDate(repair.received_at) }}</td>
              <td class="p-4 capitalize">{{ traducirGarantia(repair.garantia) }}</td>
              <td class="p-4 font-bold text-[#007BFF] font-mono">
                €{{ parseFloat(repair.repair_cost || 0).toFixed(2) }}
              </td>
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
    '6m': '6 meses',
  }
  return map[garantia] || garantia
}

const estadoColor = (estado) =>
  ({
    pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
    'en progreso': 'bg-orange-100 text-orange-800 dark:bg-orange-600 dark:text-white',
    terminado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
    entregado: 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
  })[estado] || 'bg-gray-100 dark:bg-gray-700'

onMounted(fetchRepairs)
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
    text-shadow:
      0 0 5px rgba(0, 123, 255, 0.4),
      0 0 10px rgba(0, 123, 255, 0.3);
  }
  100% {
    text-shadow:
      0 0 12px rgba(255, 191, 0, 0.5),
      0 0 20px rgba(255, 191, 0, 0.4);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}
</style>
