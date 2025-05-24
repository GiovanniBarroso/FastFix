<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-4 animate-fade-in-down">
          🛍 Explora nuestros productos
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto animate-fade-in">
          Accesorios, componentes y repuestos de calidad para móviles, consolas, ordenadores y más.
        </p>
      </div>

      <!-- Grid de productos con animaciones -->
      <transition-group
        name="fade-scale"
        tag="div"
        class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
      >
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
          class="transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl rounded-2xl"
        />
      </transition-group>

      <!-- Sin productos -->
      <div v-if="!products.length" class="text-center text-gray-600 dark:text-gray-400 mt-20 text-lg">
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

<style scoped>
/* Animaciones */
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.3s ease;
}
.fade-scale-enter-from {
  opacity: 0;
  transform: scale(0.95);
}
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.animate-fade-in-down {
  animation: fadeInDown 0.6s ease-out both;
}

.animate-fade-in {
  animation: fadeIn 0.8s ease-out both;
}

/* Keyframes */
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
