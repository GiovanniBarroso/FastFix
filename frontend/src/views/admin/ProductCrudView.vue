<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">🛠️ Gestión de productos</h1>
        <button
          @click="showModal = true"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition"
        >
          + Añadir producto
        </button>
      </div>

      <!-- Tabla de productos -->
      <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-yellow-400 dark:bg-yellow-500 text-gray-900">
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Producto</th>
              <th class="p-4 text-left font-semibold tracking-wide">Precio</th>
              <th class="p-4 text-left font-semibold tracking-wide">Stock</th>
              <th class="p-4 text-left font-semibold tracking-wide">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(product, index) in products"
              :key="product.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 flex items-center gap-4">
                <img :src="getImageUrl(product.image)" class="w-12 h-12 rounded object-cover" alt="Producto" />
                <span class="font-medium">{{ product.name }}</span>
              </td>
              <td class="p-4">€{{ product.price }}</td>
              <td class="p-4">{{ product.stock }}</td>
              <td class="p-4 flex gap-2">
                <button
                  @click="editar(product)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-xs font-semibold transition"
                >
                  Editar
                </button>
                <button
                  @click="eliminar(product.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-xs font-semibold transition"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal para añadir o editar -->
    <ProductFormModal
      :show="showModal"
      :productToEdit="productToEdit"
      @close="showModal = false"
      @saved="fetchProducts"
    />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import ProductFormModal from '@/components/products/ProductFormModal.vue'

const products = ref([])
const showModal = ref(false)
const productToEdit = ref(null)

const fetchProducts = async () => {
  try {
    const response = await api.get('/products')
    products.value = response.data
  } catch (error) {
    console.error('Error cargando productos:', error)
  }
}

const editar = (product) => {
  productToEdit.value = product
  showModal.value = true
}

const eliminar = async (id) => {
  if (confirm('¿Seguro que quieres eliminar este producto?')) {
    try {
      await api.delete(`/products/${id}`)
      products.value = products.value.filter(p => p.id !== id)
    } catch (error) {
      console.error('Error al eliminar producto:', error)
    }
  }
}

const getImageUrl = (filename) => {
  return filename?.startsWith('http') ? filename : `/images/${filename}`
}

onMounted(() => {
  fetchProducts()
})
</script>
