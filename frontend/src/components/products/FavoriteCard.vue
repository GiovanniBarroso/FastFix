<template>
    <div class=" dark:bg-gray-800 -lg -md overflow-hidden">
        <img :src="product.image" class="w-full h-48 object-cover" alt="Producto favorito" />
        <div class="p-4">
            <h3 class="text-xl font-semibold  ">{{ product.nombre }}</h3>
            <div class="mt-4 flex justify-between items-center">
                <span class="text-lg font-bold text-gray-900 ">€{{ product.precio.toFixed(2) }}</span>
                <button @click="removeFromFavorites"
                    class="bg-red-600 text-white    transition hover:bg-red-700">
                    Eliminar de favoritos
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

const removeFromFavorites = () => {
    // Implementa la lógica para eliminar del carrito
    alert(`${product.nombre} eliminado de favoritos!`)
}
</script>

<style scoped>
/* Personaliza el diseño de la tarjeta de favoritos */
</style>