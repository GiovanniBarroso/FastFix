<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonAdmin />
      </div>

      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">
          🏷️ Gestión de Descuentos
        </h1>
        <button
          @click="abrirModal()"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition"
        >
          + Nuevo descuento
        </button>
      </div>

      <!-- Tabla -->
      <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-yellow-400 dark:bg-yellow-500 text-gray-900 uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Código</th>
              <th class="p-4 text-left">Productos</th>
              <th class="p-4 text-left">Valor</th>
              <th class="p-4 text-left">Tipo</th>
              <th class="p-4 text-left">Activo</th>
              <th class="p-4 text-left">Inicio</th>
              <th class="p-4 text-left">Fin</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(d, i) in descuentos"
              :key="d.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ i + 1 }}</td>
              <td class="p-4 font-mono">{{ d.codigo }}</td>
              <td class="p-4">
                <template v-if="d.products?.length">
                  <span v-for="p in d.products" :key="p.id" class="block">
                    • {{ p.nombre }}
                  </span>
                </template>
                <template v-else>
                  <span>—</span>
                </template>
              </td>


              <td class="p-4">{{ d.tipo === 'porcentaje' ? d.valor + '%' : '€' + d.valor }}</td>
              <td class="p-4 capitalize">{{ d.tipo }}</td>
              <td class="p-4">
                <span
                  class="inline-block px-2 py-1 rounded-full text-xs font-bold"
                  :class="d.activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                >
                  {{ d.activo ? 'Sí' : 'No' }}
                </span>
              </td>
              <td class="p-4">{{ formatFecha(d.inicio) }}</td>
              <td class="p-4">{{ formatFecha(d.fin) }}</td>
              <td class="p-4">
                <div class="flex flex-col sm:flex-row items-center justify-start gap-2 h-full">
                  <button
                    @click="abrirModal(d)"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-xs font-semibold"
                  >
                    Editar
                  </button>
                  <button
                    @click="eliminar(d.id)"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-xs font-semibold"
                  >
                    Eliminar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <DiscountFormModal
        :show="showModal"
        :discount="discountToEdit"
        @close="cerrarModal"
        @saved="fetchDescuentos"
      />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import DiscountFormModal from '@/components/discounts/DiscountFormModal.vue'
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

const descuentos = ref([])
const showModal = ref(false)
const discountToEdit = ref(null)

const fetchDescuentos = async () => {
  try {
    const res = await api.get('/discounts')
    descuentos.value = res.data
  } catch (err) {
    console.error('Error al cargar descuentos:', err)
  }
}

const abrirModal = (discount = null) => {
  discountToEdit.value = discount
  showModal.value = true
}

const cerrarModal = () => {
  discountToEdit.value = null
  showModal.value = false
}

const eliminar = async (id) => {
  if (confirm('¿Eliminar este descuento?')) {
    try {
      await api.delete(`/discounts/${id}`)
      fetchDescuentos()
    } catch (err) {
      console.error('Error al eliminar:', err)
    }
  }
}

const formatFecha = (fecha) => {
  return fecha ? new Date(fecha).toLocaleDateString('es-ES') : '—'
}

onMounted(fetchDescuentos)
</script>

<style scoped>
</style>
