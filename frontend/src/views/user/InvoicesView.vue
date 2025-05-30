<template>
  <section class="py-12 bg-[#F8F9FA] dark:bg-[#1E2A38] min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón de volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#007BFF] to-[#5E6C77] animate-glow">
          🧾 Mis facturas
        </h1>
      </div>

      <!-- Tabla de facturas -->
      <div v-if="filteredInvoices.length" class="overflow-x-auto bg-white dark:bg-[#1E2A38] rounded-2xl shadow-xl animate-fade-up">
        <table class="min-w-full text-sm text-[#1E2A38] dark:text-[#F8F9FA]">
          <thead class="bg-gradient-to-r from-[#FFBF00] to-[#007BFF] text-[#1E2A38] dark:text-white">
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Pedido</th>
              <th class="p-4 text-left font-semibold tracking-wide">Fecha</th>
              <th class="p-4 text-left font-semibold tracking-wide">Total</th>
              <th class="p-4 text-left font-semibold tracking-wide">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(invoice, index) in filteredInvoices"
              :key="invoice.id"
              class="border-t border-[#E5E7EB] dark:border-[#5E6C77] hover:bg-[#F8F9FA] dark:hover:bg-[#2C3E50] transition">
              <td class="p-4 font-medium">{{ index + 1 }}</td>
              <td class="p-4">#{{ invoice.order_id }}</td>
              <td class="p-4">{{ formatDate(invoice.created_at) }}</td>
              <td class="p-4 font-bold text-[#007BFF]">€{{ Number(invoice.order?.total).toFixed(2) }}</td>
              <td class="p-4 text-center">
                <a
                  :href="`http://127.0.0.1:8000/storage/facturas/${invoice.pdf_url}`"
                  target="_blank"
                  class="bg-[#007BFF] hover:bg-[#005BB5] text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105">
                  📄 Descargar PDF
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sin facturas -->
      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg">
        Aún no tienes facturas generadas.
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
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

const filteredInvoices = computed(() =>
  invoices.value.filter((invoice) => invoice.pdf_url && invoice.order?.total),
)

onMounted(fetchInvoices)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fadeIn 0.8s ease-out both;
}

@keyframes glow {
  0% {
    text-shadow: 0 0 5px rgba(0, 123, 255, 0.4), 0 0 10px rgba(0, 123, 255, 0.3);
  }
  100% {
    text-shadow: 0 0 12px rgba(255, 191, 0, 0.5), 0 0 20px rgba(255, 191, 0, 0.4);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}
</style>
