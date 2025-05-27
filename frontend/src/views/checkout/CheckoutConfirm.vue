<template>
    <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">
                📋 Confirmación del Pedido
            </h1>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                    📦 Productos en tu carrito
                </h2>
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="p-3">Producto</th>
                            <th class="p-3">Precio</th>
                            <th class="p-3">Cantidad</th>
                            <th class="p-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in order?.products" :key="item.id"
                            class="border-b border-gray-200 dark:border-gray-600">
                            <td class="p-3">{{ item.nombre }}</td>
                            <td class="p-3">€{{ parseFloat(item.pivot.precio).toFixed(2) }}</td>
                            <td class="p-3">{{ item.pivot.cantidad }}</td>
                            <td class="p-3 font-semibold">
                                €{{ (parseFloat(item.pivot.precio) * item.pivot.cantidad).toFixed(2) }}
                            </td>
                        </tr>
                    </tbody>

                </table>

                <div class="mt-6 text-right text-xl font-bold text-gray-800 dark:text-white">
                    Total: €{{ total.toFixed(2) }}
                </div>

                <div class="mt-8 flex justify-end">
                    <button @click="pagarConPayPal"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition">
                        💵 Pagar con PayPal
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/services/api'

const route = useRoute()
const orderId = ref(route.query.order_id)

const order = ref(null)

const getOrder = async () => {
    try {
        const response = await api.get(`/orders/${orderId.value}`)
        order.value = response.data
    } catch (error) {
        console.error('Error al obtener el pedido:', error)
    }
}

const total = computed(() => {
    if (!order.value?.products) return 0
    return order.value.products.reduce(
        (sum, item) => sum + parseFloat(item.pivot.precio) * item.pivot.cantidad,
        0
    )
})

const pagarConPayPal = async () => {
    try {
        const response = await api.post('/paypal/create-order', {
            order_id: orderId.value,
        })
        const approvalUrl = response.data.links.find((link) => link.rel === 'approve')?.href
        if (approvalUrl) {
            window.location.href = approvalUrl
        } else {
            alert('No se pudo iniciar el pago con PayPal')
        }
    } catch (error) {
        console.error('❌ Error al crear orden en PayPal:', error.response?.data || error)
        alert('Hubo un error al procesar el pago.')
    }
}

onMounted(getOrder)
</script>
