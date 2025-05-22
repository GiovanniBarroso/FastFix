<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-neutral-900 dark:to-neutral-800 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

      <!-- Botón de volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Título -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">📦 Historial de pedidos</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">Consulta tus compras realizadas en FastFix.</p>
      </div>

      <!-- Tabla de pedidos -->
      <div v-if="orders.length" class="overflow-x-auto rounded-xl shadow-md bg-white dark:bg-neutral-800">
        <table class="min-w-full text-sm text-gray-800 dark:text-gray-100">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="text-left px-6 py-4">#</th>
              <th class="text-left px-6 py-4">Fecha</th>
              <th class="text-left px-6 py-4">Productos</th>
              <th class="text-left px-6 py-4">Total</th>
              <th class="text-left px-6 py-4">Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(order, index) in orders"
              :key="order.id"
              class="border-t border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-700 transition"
            >
              <td class="px-6 py-4 font-medium">{{ index + 1 }}</td>
              <td class="px-6 py-4">{{ formatDate(order.fecha_pedido) }}</td>
              <td class="px-6 py-4">
                <ul class="list-disc list-inside space-y-1">
                  <li
                    v-for="(product, idx) in order.products"
                    :key="idx"
                    class="text-gray-700 dark:text-gray-200"
                  >
                    {{ product.nombre }}
                  </li>
                </ul>
              </td>
              <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400">
                €{{ order.total.toFixed(2) }}
              </td>
              <td class="px-6 py-4">
                <span
                  :class="[ 
                    'px-3 py-1 text-xs font-semibold rounded-full',
                    order.estado === 'Entregado'
                      ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                      : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-600 dark:text-yellow-100'
                  ]"
                >
                  {{ order.estado }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sin pedidos -->
      <div class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg" v-else>
        Aún no tienes pedidos realizados.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'


const orders = ref([
  {
    id: 1,
    fecha_pedido: '2024-10-01',
    total: 79.99,
    estado: 'Entregado',
    products: [
      { nombre: 'Cargador USB-C 20W' },
      { nombre: 'Funda antigolpes iPhone 14' }
    ]
  },
  {
    id: 2,
    fecha_pedido: '2024-12-18',
    total: 44.5,
    estado: 'En preparación',
    products: [
      { nombre: 'Cable USB-C trenzado' },
      { nombre: 'Cristal templado 9H' }
    ]
  }
])

const formatDate = (fecha) => new Date(fecha).toLocaleDateString()
</script>
