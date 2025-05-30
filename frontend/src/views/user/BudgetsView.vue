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
          class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#007BFF] to-[#5E6C77] animate-glow"
        >
          🧾 Mis presupuestos
        </h1>
      </div>

      <!-- Tabla de presupuestos -->
      <div
        v-if="budgets.length"
        class="overflow-x-auto bg-white dark:bg-[#1E2A38] rounded-2xl shadow-xl animate-fade-up"
      >
        <table class="min-w-full text-sm text-[#1E2A38] dark:text-[#F8F9FA]">
          <thead
            class="bg-gradient-to-r from-[#FFBF00] to-[#007BFF] text-[#1E2A38] dark:text-white"
          >
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Fecha solicitud</th>
              <th class="p-4 text-left font-semibold tracking-wide">Mensaje</th>
              <th class="p-4 text-left font-semibold tracking-wide">Estado</th>
              <th class="p-4 text-left font-semibold tracking-wide">Respuesta</th>
              <th class="p-4 text-left font-semibold tracking-wide">Presupuesto estimado</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(budget, index) in budgets"
              :key="budget.id"
              class="border-t border-[#E5E7EB] dark:border-[#5E6C77] hover:bg-[#F8F9FA] dark:hover:bg-[#2C3E50] transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ formatDate(budget.created_at) }}</td>
              <td class="p-4 max-w-xs whitespace-pre-line break-words">{{ budget.mensaje }}</td>
              <td class="p-4">
                <span
                  :class="[
                    'px-3 py-1 text-xs font-semibold rounded-full capitalize',
                    estadoColor(budget.estado),
                  ]"
                >
                  {{ traducirEstado(budget.estado) }}
                </span>
              </td>
              <td class="p-4 text-sm">{{ budget.respuesta_admin || '—' }}</td>
              <td class="p-4 font-bold text-[#007BFF]">
                {{
                  budget.presupuesto_estimado
                    ? `€${parseFloat(budget.presupuesto_estimado).toFixed(2)}`
                    : '—'
                }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sin presupuestos -->
      <div
        v-else
        class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg animate-fade-in"
      >
        <p class="font-semibold mb-2">Aún no has solicitado presupuestos.</p>
        <router-link
          to="/contact"
          class="inline-block mt-2 px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition"
        >
          Solicitar presupuesto
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const budgets = ref([])

const fetchBudgets = async () => {
  try {
    const { data } = await api.get('/budgets')
    budgets.value = data
  } catch (error) {
    console.error('❌ Error al cargar presupuestos:', error)
  }
}

const formatDate = (fecha) => (fecha ? new Date(fecha).toLocaleDateString('es-ES') : '—')

const traducirEstado = (estado) => {
  const estados = {
    pendiente: 'Pendiente',
    respondido: 'Respondido',
    rechazado: 'Rechazado',
  }
  return estados[estado] || estado
}

const estadoColor = (estado) =>
  ({
    pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
    respondido: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
    rechazado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
  })[estado] || 'bg-gray-100 dark:bg-gray-700'

onMounted(fetchBudgets)
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

@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fadeUp 0.8s ease-out both;
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
