<template>
    <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Botón volver -->
            <div class="mb-6">
                <BackButtonUser />
            </div>

            <!-- Título -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">🧾 Mis presupuestos</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Consulta tus solicitudes de presupuesto y su estado.
                </p>
            </div>

            <!-- Tabla -->
            <div v-if="budgets.length" class="overflow-x-auto rounded-xl shadow-md bg-white dark:bg-gray-800">
                <table class="min-w-full text-sm text-gray-800 dark:text-gray-100">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="text-left px-6 py-4">#</th>
                            <th class="text-left px-6 py-4">Fecha</th>
                            <th class="text-left px-6 py-4">Descripción</th>
                            <th class="text-left px-6 py-4">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(budget, index) in budgets" :key="budget.id"
                            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 font-medium">{{ index + 1 }}</td>
                            <td class="px-6 py-4">{{ formatDate(budget.created_at) }}</td>
                            <td class="px-6 py-4">{{ budget.descripcion }}</td>
                            <td class="px-6 py-4">
                                <span
                                    :class="['px-3 py-1 text-xs font-semibold rounded-full capitalize', estadoColor(budget.estado)]">
                                    {{ traducirEstado(budget.estado) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg">
                Aún no has solicitado presupuestos.
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const budgets = ref([])

const fetchBudgets = async () => {
    try {
        const { data } = await api.get('/budgets')
        budgets.value = data
    } catch (error) {
        console.error('❌ Error al cargar presupuestos:', error)
    }
}

const formatDate = (fecha) => new Date(fecha).toLocaleDateString('es-ES')

const traducirEstado = (estado) => {
    const estados = {
        pendiente: 'Pendiente',
        aprobado: 'Aprobado',
        rechazado: 'Rechazado',
    }
    return estados[estado] || estado
}

const estadoColor = (estado) => ({
    pendiente: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
    aprobado: 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
    rechazado: 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
}[estado] || 'bg-gray-100 dark:bg-gray-700')

onMounted(fetchBudgets)
</script>