<template>
  <section class="py-10 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-8">
        🛒 Carrito de compras
      </h1>

      <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
        <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
          <thead class="bg-yellow-400 text-gray-900">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Producto</th>
              <th class="p-4 text-left">Precio</th>
              <th class="p-4 text-left">Cantidad</th>
              <th class="p-4 text-left">Subtotal</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in cart" :key="index" class="border-t border-gray-200 dark:border-gray-700">
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 flex items-center gap-4">
                <img :src="item.imagen" class="w-12 h-12 rounded" alt="Producto" />
                <span>{{ item.nombre }}</span>
              </td>
              <td class="p-4">€{{ item.precio.toFixed(2) }}</td>
              <td class="p-4">{{ item.cantidad }}</td>
              <td class="p-4 font-semibold text-blue-600 dark:text-blue-400">
                €{{ (item.precio * item.cantidad).toFixed(2) }}
              </td>
              <td class="p-4">
                <button
                  @click="eliminar(index)"
                  class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex justify-between items-center mt-8">
        <span class="text-xl font-bold text-gray-800 dark:text-white">
          Total: €{{ total.toFixed(2) }}
        </span>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition">
          Finalizar compra
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const cart = ref([
  {
    nombre: 'Cargador rápido USB-C',
    cantidad: 1,
    precio: 14.99,
    imagen: 'https://via.placeholder.com/100'
  },
  {
    nombre: 'Funda iPhone 13',
    cantidad: 2,
    precio: 9.99,
    imagen: 'https://via.placeholder.com/100'
  }
])

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.precio * item.cantidad, 0)
)

const eliminar = (index) => {
  cart.value.splice(index, 1)
}
</script>
