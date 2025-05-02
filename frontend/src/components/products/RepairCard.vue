<template>
    <div class=" dark:bg-gray-800 -lg -md overflow-hidden">
        <img :src="repair.image" class="w-full h-48 object-cover" alt="Reparación" />
        <div class="p-4">
            <h3 class="text-xl font-semibold  ">{{ repair.servicio }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">{{ repair.descripcion }}</p>
            <div class="mt-4 flex justify-between items-center">
                <span class="text-lg font-bold text-gray-900 ">Desde €{{ repair.precio.toFixed(2)
                    }}</span>
                <button @click="requestRepair"
                    class="bg-blue-600 text-white    transition hover:bg-blue-700">
                    Solicitar reparación
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    repair: {
        type: Object,
        required: true
    }
})

const requestRepair = () => {
    // Implementa la lógica para solicitar reparación
    alert(`Reparación de ${repair.servicio} solicitada!`)
}
</script>

<style scoped>
/* Personaliza el diseño de la tarjeta de reparación */
</style>