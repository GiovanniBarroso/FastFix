<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-10">
        🛡️ Gestión de Garantías
      </h1>

      <div v-if="garantias.length" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-md">
        <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
          <thead class="bg-green-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Cliente</th>
              <th class="p-4 text-left">Producto / Servicio</th>
              <th class="p-4 text-left">Inicio</th>
              <th class="p-4 text-left">Válido hasta</th>
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
              <td class="p-4">{{ garantia.user?.name ?? 'Sin nombre' }}</td>
              <td class="p-4">{{ garantia.product?.nombre ?? 'Sin producto' }}</td>
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
              <td class="p-4">
                <button
                  class="flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition"
                >
                  🔍 Ver detalle
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-10">
        No hay garantías registradas aún.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const garantias = ref([])

const formatDate = (fecha) => new Date(fecha).toLocaleDateString('es-ES')

const isActive = (fechaFin) => new Date(fechaFin) > new Date()

onMounted(async () => {
  try {
    const response = await api.get('/guarantees')
     console.log('Garantías recibidas:', response.data)
    garantias.value = response.data
  } catch (error) {
    console.error('Error al cargar garantías:', error)
  }
})
</script>
