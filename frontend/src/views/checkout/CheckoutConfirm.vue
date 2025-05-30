<template>
  <section class="py-14 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 space-y-8">
      <!-- ENCABEZADO -->
      <div class="flex items-center gap-4">
        <img src="/logoFastFix.png" alt="Logo FastFix" class="w-12 h-12 rounded-md shadow" />
        <div>
          <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">FastFix S.L.</h1>
          <p class="text-sm text-gray-500 dark:text-gray-400 leading-5">
            CIF: B12345678<br />
            Calle Tecnología, 123 · 41001 Sevilla<br />
            contacto@fastfix.com
          </p>
        </div>
      </div>

      <!-- DATOS DEL CLIENTE -->
      <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow space-y-2">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
          👤 Datos del cliente
        </h2>
        <p class="text-gray-600 dark:text-gray-300 text-sm">
          <span class="font-semibold">Nombre:</span> {{ order?.user?.nombre }}
          {{ order?.user?.apellidos }}<br />
          <span class="font-semibold">Email:</span> {{ order?.user?.email }}<br />
          <span class="font-semibold">Teléfono:</span> {{ order?.user?.telefono }}
        </p>
      </div>

      <!-- DIRECCIÓN DE ENVÍO -->
      <div v-if="order?.address" class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow space-y-2">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
          📍 Dirección de envío
        </h2>
        <div class="text-gray-600 dark:text-gray-300 text-sm space-y-1">
          <p><span class="font-semibold">Nombre:</span> {{ order.address.nombre }}</p>
          <p><span class="font-semibold">Dirección:</span> {{ order.address.direccion }}</p>
          <p>
            <span class="font-semibold">Código postal:</span> {{ order.address.codigo_postal
            }}<br />
            <span class="font-semibold">Ciudad:</span> {{ order.address.ciudad }}
          </p>
          <p>
            <span class="font-semibold">Provincia:</span> {{ order.address.provincia }}<br />
            <span class="font-semibold">País:</span> {{ order.address.pais }}
          </p>
          <p><span class="font-semibold">Teléfono:</span> {{ order.address.telefono_envio }}</p>
        </div>
      </div>

      <!-- NOTAS -->
      <div v-if="order?.notas_cliente" class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
          📝 Notas del cliente
        </h2>
        <p class="text-sm text-gray-700 dark:text-gray-300">{{ order.notas_cliente }}</p>
      </div>

      <!-- PRODUCTOS -->
      <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow space-y-6">
        <h2
          class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2"
        >
          🧾 Resumen del pedido
        </h2>

        <div class="space-y-4">
          <ResumenProductoCard
            v-for="item in order?.products"
            :key="item.id"
            :nombre="item.nombre"
            :marca="item.brand?.nombre"
            :precio="parseFloat(item.pivot.precio)"
            :imagen="item.image"
            compacto
          >
            <template #acciones>
              <div class="flex flex-col items-end space-y-1 text-sm">
                <span class="text-gray-600 dark:text-gray-300">
                  Cantidad: <span class="font-semibold">x{{ item.pivot.cantidad }}</span>
                </span>
                <span class="font-semibold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                  Subtotal: €{{ formatPrice(item.pivot.precio * item.pivot.cantidad) }}
                </span>
              </div>
            </template>
          </ResumenProductoCard>
        </div>

        <div
          class="text-right text-xl font-bold text-gray-800 dark:text-white pt-6 border-t border-gray-300 dark:border-gray-600"
        >
          Total: <span class="text-blue-600 dark:text-blue-400">€{{ formatPrice(total) }}</span>
        </div>
      </div>

      <!-- BOTÓN PAYPAL -->
      <div v-if="order?.estado === 'pendiente'" class="text-right">
        <BaseButton
          @click="pagarConPayPal"
          class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg active:scale-95 transition-all"
        >
          💵 Pagar con PayPal
        </BaseButton>
      </div>

      <div v-if="order?.invoice" class="text-right">
        <a
          :href="`http://localhost:8000/storage/facturas/${order.invoice.pdf_url}`"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-lg shadow transition active:scale-95"
        >
          🧾 Descargar factura ({{ order.invoice.numero_factura }})
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/services/api'
import ResumenProductoCard from '@/components/cards/ResumenProductoCard.vue'
import BaseButton from '@/views/components/BaseButton.vue'

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
    0,
  )
})

const formatPrice = (value) =>
  new Intl.NumberFormat('es-ES', {
    style: 'decimal',
    minimumFractionDigits: 2,
  }).format(value)

const pagarConPayPal = async () => {
  try {
    const response = await api.post('/paypal/create-order', {
      order_id: orderId.value,
    })

    const approvalUrl = response.data.links.find((link) => link.rel === 'approve')?.href

    if (approvalUrl) {
      // ✅ Guarda el ID del pedido antes de redirigir
      localStorage.setItem('lastOrderId', orderId.value)

      // ✅ Redirige a PayPal
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
