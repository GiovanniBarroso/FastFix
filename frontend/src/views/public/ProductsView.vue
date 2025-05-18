<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
          🛍 Explora nuestros productos
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Accesorios, componentes y repuestos de calidad para móviles, consolas, ordenadores y más.
        </p>
      </div>

      <!-- Grid de productos -->
      <div v-if="products.length" class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <ProductCard v-for="product in products" :key="product.id" :product="product" />
      </div>

      <div v-else class="text-center text-gray-600 dark:text-gray-400 mt-20 text-lg">
        No hay productos disponibles.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import ProductCard from '@/components/products/ProductCard.vue'

const products = ref([])

const fetchProducts = async () => {
  try {
    const response = await api.get('/products')
    products.value = response.data
  } catch (error) {
    console.error('Error cargando productos:', error)
  }
}

onMounted(fetchProducts)
</script>
