<template>
    <section class="py-12  bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold   mb-8 text-center">
          🧾 Lista de Pedidos
        </h1>
  
        <div v-if="orders.length" class="overflow-x-auto  dark:bg-gray-800 -xl ">
          <table class="min-w-full text-sm  dark:text-gray-200">
            <thead class="bg-yellow-400 text-gray-900">
              <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Usuario</th>
                <th class="p-4 text-left">Fecha</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-left">Estado</th>
                <th class="p-4 text-left">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(order, index) in orders"
                :key="index"
                class="border-t border-gray-200 dark:border-gray-700"
              >
                <td class="p-4">{{ index + 1 }}</td>
                <td class="p-4">{{ order.usuario }}</td>
                <td class="p-4">{{ order.fecha }}</td>
                <td class="p-4 font-bold">€{{ order.total.toFixed(2) }}</td>
                <td class="p-4">
                  <span
                    :class="[
                      ' py-1 -full text-xs font-semibold',
                      order.estado === 'Entregado'
                        ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100'
                        : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-700 dark:text-yellow-100'
                    ]"
                  >
                    {{ order.estado }}
                  </span>
                </td>
                <td class="p-4">
                  <button
                    class="bg-blue-500 hover:bg-blue-600 text-white  py-1  text-xs transition"
                  >
                    Ver detalle
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-10">
          No hay pedidos registrados aún.
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const orders = ref([
    {
      usuario: 'Carlos Pérez',
      fecha: '2025-04-20',
      total: 149.99,
      estado: 'Entregado'
    },
    {
      usuario: 'Lucía Martínez',
      fecha: '2025-04-23',
      total: 79.49,
      estado: 'En proceso'
    }
  ])
  </script>
  