<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón volver -->
      <div class="mb-6" data-aos="fade-right" data-aos-delay="100">
        <BackButtonAdmin />
      </div>

      <!-- Título -->
      <h1
        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500 text-center mb-12"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        📝 Solicitudes de Presupuesto
      </h1>

      <!-- Sección Pendientes -->
      <SectionTable
        icon="📩"
        title="Pendientes"
        :items="pendientes"
        type="pendiente"
        :show-actions="true"
        @open-modal="openModal"
        @rechazar="rechazarSolicitud"
      />

      <!-- Sección Respondidas -->
      <SectionTable icon="✅" title="Respondidas" :items="respondidas" type="respondido" />

      <!-- Sección Rechazadas -->
      <SectionTable icon="❌" title="Rechazadas" :items="rechazadas" type="rechazado" />

      <!-- Modal -->
      <BudgetContactModal
        :show="showModal"
        :cliente="selectedCliente"
        @close="closeModal"
        @respondido="marcarComoRespondido"
      />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/services/api'
import AOS from 'aos'
import 'aos/dist/aos.css'

import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'
import BudgetContactModal from '@/components/budgets/BudgetContactModal.vue'
import SectionTable from '@/components/budgets/SectionTable.vue'

const budgets = ref([])
const showModal = ref(false)
const selectedCliente = ref(null)

const pendientes = computed(() => budgets.value.filter((b) => b.estado === 'pendiente'))
const respondidas = computed(() => budgets.value.filter((b) => b.estado === 'respondido'))
const rechazadas = computed(() => budgets.value.filter((b) => b.estado === 'rechazado'))

const openModal = (cliente) => {
  selectedCliente.value = cliente
  showModal.value = true
}

const closeModal = () => {
  selectedCliente.value = null
  showModal.value = false
}

const marcarComoRespondido = async (id) => {
  try {
    await api.put(`/budgets/${id}`, { estado: 'respondido' })
    await cargarPresupuestos()
  } catch (err) {
    console.error('Error al actualizar a respondido:', err)
  }
}

const rechazarSolicitud = async (id) => {
  if (!confirm('¿Seguro que quieres rechazar esta solicitud?')) return
  try {
    await api.put(`/budgets/${id}`, { estado: 'rechazado' })
    await cargarPresupuestos()
  } catch (err) {
    console.error('Error al rechazar solicitud:', err)
  }
}

const cargarPresupuestos = async () => {
  try {
    const res = await api.get('/budgets')
    budgets.value = res.data
  } catch (err) {
    console.error('Error cargando presupuestos:', err)
  }
}

onMounted(() => {
  cargarPresupuestos()
  AOS.init({ duration: 700, once: true })
})
</script>
