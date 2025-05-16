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
      <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <ProductCard
          v-for="(product, index) in products"
          :key="index"
          :product="product"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import ProductCard from '@/components/products/ProductCard.vue'

const products = [
  {
    nombre: 'Cargador USB-C 20W',
    precio: 14.99,
    marca: 'Anker',
    imagen: 'https://via.placeholder.com/300x200',
    descripcion: 'Carga rápida y segura para tus dispositivos.'
  },
  {
    nombre: 'Funda antigolpes iPhone 14',
    precio: 9.99,
    marca: 'Spigen',
    imagen: 'https://via.placeholder.com/300x200',
    descripcion: 'Protección extrema sin sacrificar estilo.'
  },
  {
    nombre: 'Cristal templado 9H',
    precio: 4.5,
    marca: 'NanotechPRO',
    imagen: 'https://via.placeholder.com/300x200',
    descripcion: 'Defiende tu pantalla de arañazos y golpes.'
  },
  {
    nombre: 'Cable USB-C trenzado',
    precio: 5.95,
    marca: 'Baseus',
    imagen: 'https://via.placeholder.com/300x200',
    descripcion: 'Durabilidad y velocidad a otro nivel.'
  }
]
</script>
