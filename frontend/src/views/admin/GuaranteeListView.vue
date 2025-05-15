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
              :key="index"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">{{ garantia.cliente }}</td>
              <td class="p-4">{{ garantia.producto }}</td>
              <td class="p-4">{{ formatDate(garantia.inicio) }}</td>
              <td class="p-4">{{ formatDate(garantia.fin) }}</td>
              <td class="p-4">
                <span
                  class="px-3 py-1 rounded-full text-xs font-semibold"
                  :class="garantia.estado === 'Activa'
                    ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                    : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100'"
                >
                  {{ garantia.estado }}
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
import { ref } from 'vue'

const garantias = ref([
  {
    cliente: 'María Rodríguez',
    producto: 'Cambio de batería - iPhone XR',
    inicio: '2024-10-05',
    fin: '2025-10-05',
    estado: 'Activa'
  },
  {
    cliente: 'Pedro Ruiz',
    producto: 'Reparación de cámara - Galaxy S21',
    inicio: '2023-12-01',
    fin: '2024-12-01',
    estado: 'Expirada'
  }
])

const formatDate = (fecha) => {
  return new Date(fecha).toLocaleDateString('es-ES')
}
</script>
