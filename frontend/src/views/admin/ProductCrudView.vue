<template>
    <section class="py-10 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">
            🛠️ Gestión de productos
          </h1>
          <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
            + Añadir producto
          </button>
        </div>
  
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
          <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
            <thead class="bg-yellow-400 text-gray-900">
              <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Producto</th>
                <th class="p-4 text-left">Precio</th>
                <th class="p-4 text-left">Stock</th>
                <th class="p-4 text-left">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(product, index) in products"
                :key="index"
                class="border-t border-gray-200 dark:border-gray-700"
              >
                <td class="p-4">{{ index + 1 }}</td>
                <td class="p-4 flex items-center gap-4">
                  <img :src="product.imagen" class="w-12 h-12 rounded" alt="Producto" />
                  <span>{{ product.nombre }}</span>
                </td>
                <td class="p-4">€{{ product.precio.toFixed(2) }}</td>
                <td class="p-4">{{ product.stock }}</td>
                <td class="p-4 flex gap-2">
                  <button
                    @click="editar(product)"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition"
                  >
                    Editar
                  </button>
                  <button
                    @click="eliminar(index)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition"
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
  
  const products = ref([
    {
      nombre: 'Cable USB-C',
      precio: 8.99,
      stock: 120,
      imagen: 'https://via.placeholder.com/100'
    },
    {
      nombre: 'Funda antigolpes',
      precio: 12.99,
      stock: 80,
      imagen: 'https://via.placeholder.com/100'
    },
    {
      nombre: 'Auriculares Bluetooth',
      precio: 29.99,
      stock: 45,
      imagen: 'https://via.placeholder.com/100'
    }
  ])
  
  const editar = (product) => {
    alert(`Editar producto: ${product.nombre} (simulado)`)
  }
  
  const eliminar = (index) => {
    if (confirm('¿Seguro que quieres eliminar este producto?')) {
      products.value.splice(index, 1)
    }
  }
  </script>
  