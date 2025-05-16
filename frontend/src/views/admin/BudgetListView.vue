<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
      <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-10">
        📝 Solicitudes de Presupuesto
      </h1>

      <div v-if="budgets.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
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
              v-for="(solicitud, index) in budgets"
              :key="solicitud.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ solicitud.nombre }}</td>
              <td class="p-4">{{ solicitud.email }}</td>
              <td class="p-4">{{ solicitud.telefono }}</td>
              <td class="p-4 max-w-sm">
                <div class="truncate bg-gray-100 dark:bg-gray-700 p-2 rounded" :title="solicitud.mensaje">
                  {{ solicitud.mensaje }}
                </div>
              </td>
              <td class="p-4">
                <button
                  class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded text-xs transition"
                >
                  📩 Contactar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-10">
        No hay solicitudes de presupuesto todavía.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api' // Asegúrate de tener tu instancia Axios configurada

const budgets = ref([])

onMounted(async () => {
  try {
    const response = await api.get('/budgets') // GET /api/budgets
    budgets.value = response.data
  } catch (error) {
    console.error('Error al cargar presupuestos:', error)
  }
})
</script>
