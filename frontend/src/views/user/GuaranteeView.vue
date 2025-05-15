<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto">
      <h1 class="text-4xl font-extrabold mb-8 text-center">🛡️ Consulta tu garantía</h1>

      <p class="text-center text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto">
        Introduce el número de pedido para verificar el estado de tu garantía.
      </p>

      <form @submit.prevent="buscarGarantia" class="space-y-6 dark:bg-gray-800 p-8 rounded-xl">
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-2">Número de pedido</label>
          <input v-model="form.pedido" type="text" required
            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded" />
        </div>

        <div class="flex justify-center">
          <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded transition">
            Buscar garantía
          </button>
        </div>
      </form>

      <div v-if="garantiaEncontrada"
        class="mt-10 bg-green-100 dark:bg-green-800 text-green-900 dark:text-green-200 p-6 rounded-xl text-center">
        <h2 class="text-2xl font-bold mb-2">✅ Garantía activa</h2>
        <p>Tu producto está cubierto hasta: <strong>{{ garantia.fechaFin }}</strong></p>
        <p class="mt-2">Detalles: {{ garantia.detalles }}</p>
      </div>

      <div v-else-if="buscarRealizado"
        class="mt-10 bg-red-100 dark:bg-red-800 text-red-900 dark:text-red-200 p-6 rounded-xl text-center">
        <h2 class="text-2xl font-bold mb-2">❌ No se encontró garantía</h2>
        <p>Revisa el número de pedido o contáctanos para más información.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/services/api'

const form = ref({ pedido: '' })
const garantia = ref(null)
const buscarRealizado = ref(false)

const garantiaEncontrada = computed(() => garantia.value !== null)

const buscarGarantia = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await api.get(
      import.meta.env.VITE_API_URL + `/guarantees/by-order/${form.value.pedido}`,
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    )

    garantia.value = {
      fechaFin: new Date(response.data.fecha_fin).toLocaleDateString(),
      detalles: response.data.product?.nombre || 'Producto asociado'
    }
  } catch (error) {
    garantia.value = null
  } finally {
    buscarRealizado.value = true
  }
}
</script>
