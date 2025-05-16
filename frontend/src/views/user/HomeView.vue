<template>
  <section class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-3xl font-extrabold mb-4 text-center">📊 Panel de Usuario</h1>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-8">
        Aquí puedes ver un resumen de tus pedidos, garantías, favoritos y actividad reciente.
      </p>

      <div class="grid gap-6 md:grid-cols-3">
        <!-- Últimos pedidos -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
          <h2 class="text-xl font-bold mb-4">📦 Últimos pedidos</h2>
          <ul v-if="pedidos.length > 0" class="space-y-2">
            <li v-for="pedido in pedidos" :key="pedido.id" class="border-b pb-2 text-gray-700 dark:text-gray-200">
              Pedido #{{ pedido.id }} - {{ pedido.estado }} - {{ pedido.fecha }}
            </li>
          </ul>
          <p v-else class="text-gray-500 dark:text-gray-400">No tienes pedidos recientes.</p>
          <router-link to="/orders"
            class="mt-4 inline-block text-blue-600 dark:text-blue-400 font-medium hover:underline">Ver todos</router-link>
        </div>

        <!-- Garantías activas -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
          <h2 class="text-xl font-bold mb-4">🛡️ Garantías activas</h2>
          <ul v-if="garantias.length > 0" class="space-y-2">
            <li v-for="garantia in garantias" :key="garantia.id" class="border-b pb-2 text-gray-700 dark:text-gray-200">
              Producto: {{ garantia.producto }} - vence el {{ garantia.vencimiento }}
            </li>
          </ul>
          <p v-else class="text-gray-500 dark:text-gray-400">No hay garantías activas.</p>
          <router-link to="/guarantee"
            class="mt-4 inline-block text-blue-600 dark:text-blue-400 font-medium hover:underline">Ver todas</router-link>
        </div>

        <!-- Favoritos -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
          <h2 class="text-xl font-bold mb-4">❤️ Favoritos</h2>
          <ul v-if="favoritos.length > 0" class="space-y-2">
            <li v-for="favorito in favoritos" :key="favorito.id" class="border-b pb-2 text-gray-700 dark:text-gray-200">
              {{ favorito.nombre }} - {{ favorito.marca }}
            </li>
          </ul>
          <p v-else class="text-gray-500 dark:text-gray-400">No hay productos en favoritos.</p>
          <router-link to="/favorites"
            class="mt-4 inline-block text-blue-600 dark:text-blue-400 font-medium hover:underline">Ver todos</router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const pedidos = ref([])
const garantias = ref([])
const favoritos = ref([])

onMounted(() => {
  pedidos.value = [
    { id: 101, estado: 'Entregado', fecha: '2025-05-01' },
    { id: 102, estado: 'En camino', fecha: '2025-05-07' }
  ]

  garantias.value = [
    { id: 1, producto: 'iPhone 13 Pro', vencimiento: '2025-12-01' }
  ]

  favoritos.value = [
    { id: 1, nombre: 'Cargador USB-C 20W', marca: 'Anker' },
    { id: 2, nombre: 'Funda antigolpes iPhone 14', marca: 'Spigen' }
  ]
})
</script>
