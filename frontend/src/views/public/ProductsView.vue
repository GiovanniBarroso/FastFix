<template>
  <section class="relative py-24 bg-gradient-to-br from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 min-h-screen">
    <div class="absolute inset-0 bg-[url('/images/bg-circuit.svg')] bg-cover bg-center opacity-5 dark:opacity-10"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">
      <!-- ENCABEZADO -->
      <div class="text-center mb-16 animate-fade-in-down">
        <h1 class="text-6xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500">
          🛍 Productos FastFix
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto animate-fade-in">
          Accesorios, componentes y repuestos con garantía de calidad, diseño y rendimiento.
        </p>
      </div>

      <!-- GRID DE PRODUCTOS -->
      <transition-group
        name="fade-scale"
        tag="div"
        class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
          class="transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl"
        />
      </transition-group>

      <!-- SIN PRODUCTOS -->
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