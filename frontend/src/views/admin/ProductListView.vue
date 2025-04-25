<template>
    <section class="py-10 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Título -->
            <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-6 text-center">
                Explora nuestros productos
            </h1>

            <!-- Descripción -->
            <p class="text-center text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto">
                Accesorios, componentes y repuestos de calidad para móviles, consolas, ordenadores y más.
            </p>

            <!-- Grid de productos -->
            <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <ProductCard v-for="(product, index) in products" :key="index" :product="product" />
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
        nombre: 'Funda antigolpes iPhone 13',
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