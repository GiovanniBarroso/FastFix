<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6" data-aos="fade-up" data-aos-duration="700">
      <!-- Botón de volver -->
      <div class="mb-6" data-aos="fade-right" data-aos-delay="100">
        <BackButtonAdmin />
      </div>

      <!-- Encabezado -->
      <div
        class="flex justify-between items-center mb-10"
        data-aos="zoom-in-up"
        data-aos-delay="200"
      >
        <h1
          class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500"
        >
          🛠️ Gestión de productos
        </h1>
        <button
          @click="openForCreate"
          class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:shadow-[0_0_12px_rgba(34,197,94,0.6)] transition-all"
          data-aos="fade-left"
          data-aos-delay="300"
        >
          + Añadir producto
        </button>
      </div>

      <!-- Tabla de productos -->
      <div
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
        data-aos="fade-up"
        data-aos-delay="400"
      >
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead
            class="bg-gradient-to-r from-yellow-300 to-yellow-500 dark:from-yellow-500 dark:to-yellow-600 text-gray-900 dark:text-white"
          >
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Producto</th>
              <th class="p-4 text-left font-semibold tracking-wide">Precio Base</th>
              <th class="p-4 text-left font-semibold tracking-wide">Precio con Descuento</th>
              <th class="p-4 text-left font-semibold tracking-wide">Stock</th>
              <th class="p-4 text-left font-semibold tracking-wide">Marca</th>
              <th class="p-4 text-left font-semibold tracking-wide">Categoría</th>
              <th class="p-4 text-left font-semibold tracking-wide">Activo</th>
              <th class="p-4 text-left font-semibold tracking-wide">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(product, index) in products"
              :key="product.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              data-aos="fade-up"
              data-aos-delay="500"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium flex items-center gap-3">
                <img :src="getImageUrl(product.image)" class="w-10 h-10 rounded shadow" />
                <span class="truncate max-w-[180px]">{{ product.nombre }}</span>
              </td>
              <td class="p-4 text-end text-gray-700 dark:text-gray-200 font-semibold">
                €{{ product.precio_base }}
              </td>
              <td class="p-4 text-end text-green-600 dark:text-green-400 font-bold">
                €{{ product.precio }}
              </td>
              <td class="p-4 text-end font-semibold text-gray-800 dark:text-gray-100">
                {{ product.stock }}
              </td>
              <td class="p-4">
                <span
                  class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-white shadow-sm"
                >
                  {{ product.brand?.nombre }}
                </span>
              </td>
              <td class="p-4">
                <span
                  class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 dark:bg-emerald-700 text-emerald-800 dark:text-white shadow-sm"
                >
                  {{ product.category?.nombre }}
                </span>
              </td>
              <td class="p-4">
                <span
                  :class="
                    product.activo
                      ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-white'
                      : 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-white'
                  "
                  class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full shadow-sm"
                >
                  {{ product.activo ? '✅ Sí' : '❌ No' }}
                </span>
              </td>
              <td class="p-4 flex gap-2">
                <button
                  @click="editar(product)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  ✏️ Editar
                </button>
                <button
                  @click="eliminar(product.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  🗑️ Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
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
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'
import AOS from 'aos'
import 'aos/dist/aos.css'

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

const openForCreate = () => {
  productToEdit.value = null
  showModal.value = true
}

const editar = (product) => {
  productToEdit.value = product
  showModal.value = true
}

const eliminar = async (id) => {
  if (confirm('¿Seguro que quieres eliminar este producto?')) {
    try {
      await api.delete(`/products/${id}`)
      await fetchProducts()
    } catch (error) {
      console.error('Error al eliminar producto:', error)
    }
  }
}

const getImageUrl = (filename) => {
  if (!filename) return '/images/default.jpg'
  return `/products/${filename}`
}

onMounted(() => {
  fetchProducts()
  AOS.init({ duration: 700, once: true })
})
</script>
