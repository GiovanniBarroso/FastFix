<template>
  <section class="py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white">🛡️ Mis Garantías</h1>
        <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
          Aquí puedes consultar el estado de todas tus garantías.
        </p>
      </div>

      <div v-if="garantias.length > 0" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <div
          v-for="g in garantias"
          :key="g.id"
          class="rounded-xl bg-white dark:bg-gray-800 shadow-md p-6 border-l-4 cursor-pointer transform transition-transform duration-300 hover:scale-105 hover:shadow-xl"
          :class="estaActiva(g.fecha_fin) ? 'border-green-500' : 'border-red-500'"
          @click="toggleDetalle(g.id)"
        >
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
              {{ g.product.name }}
            </h2>
            <span
              class="text-sm font-medium px-3 py-1 rounded-full"
              :class="estaActiva(g.fecha_fin)
                ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white'
                : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white'"
            >
              {{ estaActiva(g.fecha_fin) ? 'Activa' : 'Vencida' }}
            </span>
          </div>
          <p class="text-sm text-gray-700 dark:text-gray-300">
            <strong>Inicio:</strong> {{ formatFecha(g.fecha_inicio) }}
          </p>
          <p class="text-sm text-gray-700 dark:text-gray-300">
            <strong>Fin:</strong> {{ formatFecha(g.fecha_fin) }}
          </p>

          <!-- Detalle extra desplegable -->
          <transition name="fade">
            <div v-if="detalleVisible === g.id" class="mt-4 text-sm text-gray-600 dark:text-gray-300 space-y-1">
              <p><strong>Registrada:</strong> {{ formatFecha(g.created_at) }}</p>
              <p><strong>Duración:</strong> {{ duracionEnDias(g.fecha_inicio, g.fecha_fin) }} días</p>
              <p v-if="estaActiva(g.fecha_fin)">
                <strong>Días restantes:</strong> {{ diasRestantes(g.fecha_fin) }} días
              </p>
              <p v-else class="text-red-500 dark:text-red-400">
                Garantía vencida.
              </p>
              <p v-if="estaActiva(g.fecha_fin) && diasRestantes(g.fecha_fin) <= 30" class="text-yellow-600 dark:text-yellow-400 font-semibold">
                ⚠️ Tu garantía vencerá pronto.
              </p>
              <p class="italic mt-2 text-xs">Haz clic para ocultar detalles.</p>
            </div>
          </transition>
        </div>
      </div>

      <div v-else class="text-center text-red-600 dark:text-red-400 mt-10">
        <h2 class="text-2xl font-semibold">❌ No tienes garantías activas registradas.</h2>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const garantias = ref([])
const detalleVisible = ref(null)

onMounted(async () => {
  try {
    const response = await api.get('/guarantees')
    garantias.value = response.data
  } catch (error) {
    console.error('Error al obtener garantías:', error)
  }
})

const formatFecha = (fecha) => new Date(fecha).toLocaleDateString()

const estaActiva = (fechaFin) => new Date(fechaFin) >= new Date()

const diasRestantes = (fechaFin) => {
  const fin = new Date(fechaFin)
  const hoy = new Date()
  return Math.ceil((fin - hoy) / (1000 * 60 * 60 * 24))
}

const duracionEnDias = (inicio, fin) => {
  const start = new Date(inicio)
  const end = new Date(fin)
  return Math.ceil((end - start) / (1000 * 60 * 60 * 24))
}

const toggleDetalle = (id) => {
  detalleVisible.value = detalleVisible.value === id ? null : id
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
