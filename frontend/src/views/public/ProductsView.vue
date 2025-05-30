<template>
  <section
    class="relative py-24 bg-gradient-to-br from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 min-h-screen scroll-smooth"
  >
    <!-- Fondo decorativo -->
    <div
      class="absolute inset-0 bg-[url('/images/bg-circuit.svg')] bg-cover bg-center opacity-5 dark:opacity-10"
    ></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">
      <!-- ENCABEZADO -->
      <div class="text-center mb-16 animate-fade-in-down">
        <h1
          class="text-6xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-blue-400 animate-gradient-x"
        >
          🛍 Productos FastFix
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto animate-fade-in">
          Accesorios, componentes y repuestos con garantía de calidad, diseño y rendimiento.
        </p>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 animate-fade-in">
          Envío gratis en pedidos superiores a 50€ ✨
        </p>
      </div>

      <!-- LOADING SPINNER -->
      <div v-if="loading" class="flex justify-center py-10">
        <svg
          class="animate-spin h-8 w-8 text-orange-500"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
        </svg>
      </div>

      <!-- GRID DE PRODUCTOS -->
      <transition-group
        name="fade-scale"
        tag="div"
        class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        v-if="!loading"
      >
        <ProductCard
          v-for="(product, index) in products"
          :key="product.id"
          :product="product"
          :style="`animation-delay: ${index * 100}ms`"
          class="card-glow animate-fade-in-card"
        />
      </transition-group>

      <!-- SIN PRODUCTOS -->
      <div
        v-if="!products.length && !loading"
        class="text-center text-gray-600 dark:text-gray-400 mt-20 text-lg animate-fade-in"
      >
        No hay productos disponibles en este momento.
      </div>

      <!-- NOTA FINAL -->
      <div
        class="border-t border-gray-200 dark:border-gray-700 mt-16 pt-6 text-center text-sm text-gray-500"
      >
        * Todos los productos cuentan con garantía de 2 años y servicio técnico especializado.
      </div>
    </div>

    <!-- BOTÓN VOLVER ARRIBA -->
    <a
      href="#"
      class="fixed bottom-6 right-6 bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-full shadow-lg transition duration-300 z-50"
    >
      ↑
    </a>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import ProductCard from '@/components/products/ProductCard.vue'

const products = ref([])
const loading = ref(true)

const fetchProducts = async () => {
  loading.value = true
  try {
    const response = await api.get('/products')
    products.value = response.data
  } catch (error) {
    console.error('Error cargando productos:', error)
  } finally {
    loading.value = false
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

@keyframes fadeInCard {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in-card {
  animation: fadeInCard 0.5s ease-out both;
}

@keyframes gradient-x {
  0%,
  100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}
.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

.card-glow {
  backdrop-filter: blur(10px);
  background-color: rgba(255, 255, 255, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.card-glow:hover {
  box-shadow: 0 0 30px rgba(255, 107, 53, 0.3);
  transform: scale(1.03) translateY(-4px);
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
