<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">🔧 Servicios de reparación</h1>
        <button
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
              <th class="p-4 text-left">Precio base</th>
              <th class="p-4 text-left">Duración estimada</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(servicio, index) in servicios"
              :key="index"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ servicio.nombre }}</td>
              <td class="p-4 max-w-md truncate" :title="servicio.descripcion">
                {{ servicio.descripcion }}
              </td>
              <td class="p-4 font-mono">€{{ servicio.precio.toFixed(2) }}</td>
              <td class="p-4">{{ servicio.duracion }}</td>
              <td class="p-4 flex gap-2">
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-xs font-semibold"
                >
                  Editar
                </button>
                <button
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
  </section>
</template>

<script setup>
import { ref } from 'vue'

const servicios = ref([
  {
    nombre: 'Cambio de pantalla iPhone 11',
    descripcion: 'Sustitución completa de pantalla rota por una nueva (incluye diagnóstico).',
    precio: 89.99,
    duracion: '1-2 días'
  },
  {
    nombre: 'Reparación de placa base MacBook Pro',
    descripcion: 'Diagnóstico y reparación de fallos en la lógica principal del dispositivo.',
    precio: 149.99,
    duracion: '3-5 días'
  },
  {
    nombre: 'Reemplazo de batería Samsung Galaxy S21',
    descripcion: 'Instalación de batería nueva con componentes originales y prueba de carga.',
    precio: 49.90,
    duracion: '24 horas'
  }
])
</script>
