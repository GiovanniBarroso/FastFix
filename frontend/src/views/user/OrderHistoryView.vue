<template>
    <section class="py-12  bg-neutral-50 dark:bg-neutral-900 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold   mb-8 text-center">
          📦 Historial de pedidos
        </h1>
  
        <div v-if="orders.length > 0" class="overflow-x-auto  dark:bg-neutral-800 -xl ">
          <table class="min-w-full text-sm  dark:text-neutral-200">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Fecha</th>
                <th class="p-4 text-left">Productos</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-left">Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(order, index) in orders"
                :key="index"
                class="border-t border-neutral-200 dark:border-neutral-700"
              >
                <td class="p-4">{{ index + 1 }}</td>
                <td class="p-4">{{ order.fecha }}</td>
                <td class="p-4">
                  <ul class="list-disc list-inside">
                    <li v-for="(producto, idx) in order.productos" :key="idx">
                      {{ producto }}
                    </li>
                  </ul>
                </td>
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
              </tr>
            </tbody>
          </table>
        </div>
  
        <div v-else class="text-center text-neutral-600 dark:text-neutral-300 mt-10">
          Aún no tienes pedidos realizados.
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const orders = ref([
    {
      fecha: '2025-04-01',
      productos: ['Cambio de pantalla iPhone 13', 'Protector de pantalla'],
      total: 129.98,
      estado: 'Entregado'
    },
    {
      fecha: '2025-04-15',
      productos: ['Funda antigolpes Galaxy S21'],
      total: 19.99,
      estado: 'En proceso'
    }
  ])
  </script>
  