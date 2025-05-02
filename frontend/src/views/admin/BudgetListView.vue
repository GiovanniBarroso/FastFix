<template>
    <section class="py-12  bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold   mb-8 text-center">
          📝 Solicitudes de Presupuesto
        </h1>
  
        <div v-if="budgets.length" class="overflow-x-auto  dark:bg-gray-800 -xl ">
          <table class="min-w-full text-sm  dark:text-gray-200">
            <thead class="bg-blue-500 text-white">
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
                :key="index"
                class="border-t border-gray-200 dark:border-gray-700"
              >
                <td class="p-4">{{ index + 1 }}</td>
                <td class="p-4">{{ solicitud.nombre }}</td>
                <td class="p-4">{{ solicitud.email }}</td>
                <td class="p-4">{{ solicitud.telefono }}</td>
                <td class="p-4 max-w-xs truncate" :title="solicitud.mensaje">
                  {{ solicitud.mensaje }}
                </td>
                <td class="p-4">
                  <button
                    class="bg-green-600 hover:bg-green-700 text-white  py-1  text-xs transition"
                  >
                    Contactar
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
  import { ref } from 'vue'
  
  const budgets = ref([
    {
      nombre: 'Juan García',
      email: 'juan@example.com',
      telefono: '612345678',
      mensaje: 'Mi iPhone 11 tiene la pantalla rota, ¿cuánto costaría repararla?'
    },
    {
      nombre: 'Ana López',
      email: 'ana@example.com',
      telefono: '699876543',
      mensaje: '¿Podríais revisar la batería de mi Samsung Galaxy S20?'
    }
  ])
  </script>
  