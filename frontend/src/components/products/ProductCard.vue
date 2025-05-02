<template>
    <div class=" dark:bg-gray-800 -lg -md overflow-hidden">
        <img :src="product.image" class="w-full h-48 object-cover" alt="Producto" />
        <div class="p-4">
            <h3 class="text-xl font-semibold  ">{{ product.nombre }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">{{ product.description }}</p>
            <div class="mt-4 flex justify-between items-center">
                <span class="text-lg font-bold text-gray-900 ">€{{ product.precio.toFixed(2) }}</span>
                <button @click="addToCart"
                    class="bg-green-600 text-white    transition hover:bg-green-700">
                    Añadir al carrito
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true
    }
})

const addToCart = () => {
    // Implementa la lógica para agregar al carrito
    alert(`${product.nombre} agregado al carrito!`)
}
</script>

<style scoped>
/* Personaliza el diseño de la tarjeta según tu preferencia */
</style>