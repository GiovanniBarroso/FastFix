<template>
    <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Botón volver -->
            <div class="mb-6">
                <BackButtonUser />
            </div>

            <!-- Título -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">📄 Mis facturas</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Descarga tus facturas en PDF de cada compra
                    realizada.</p>
            </div>

            <!-- Tabla -->
            <div v-if="invoices.length" class="overflow-x-auto rounded-xl shadow-md bg-white dark:bg-gray-800">
                <table class="min-w-full text-sm text-gray-800 dark:text-gray-100">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="text-left px-6 py-4">#</th>
                            <th class="text-left px-6 py-4">Pedido</th>
                            <th class="text-left px-6 py-4">Fecha</th>
                            <th class="text-left px-6 py-4">Total</th>
                            <th class="text-left px-6 py-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(invoice, index) in invoices" :key="invoice.id"
                            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 font-medium">{{ index + 1 }}</td>
                            <td class="px-6 py-4">#{{ invoice.order_id }}</td>
                            <td class="px-6 py-4">{{ formatDate(invoice.created_at) }}</td>
                            <td class="px-6 py-4 font-semibold text-blue-600 dark:text-blue-400">€{{
                                invoice.total.toFixed(2) }}</td>
                            <td class="px-6 py-4">
                                <a :href="`/storage/facturas/${invoice.pdf}`" target="_blank"
                                    class="text-sm px-4 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition font-semibold">
                                    Descargar PDF
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg">
                Aún no tienes facturas generadas.
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const invoices = ref([])

const fetchInvoices = async () => {
    try {
        const { data } = await api.get('/invoices')
        invoices.value = data
    } catch (error) {
        console.error('❌ Error al cargar facturas:', error)
    }
}

const formatDate = (fecha) => new Date(fecha).toLocaleDateString('es-ES')

onMounted(fetchInvoices)
</script>