<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-3xl mx-auto px-6">
      <!-- Título -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold mb-4 text-gray-900 dark:text-white">🛡️ Consulta tu garantía</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Introduce el número de pedido para verificar el estado de tu garantía.
        </p>
      </div>

      <!-- Formulario -->
      <form @submit.prevent="buscarGarantia"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 space-y-6 transition-all duration-300">
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
            Número de pedido
          </label>
          <input
            v-model="form.pedido"
            type="text"
            required
            placeholder="Ej: 123456ABC"
            class="w-full px-4 py-3 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div class="flex justify-center">
          <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-md transition-all duration-300 shadow hover:shadow-md"
          >
            Buscar garantía
          </button>
        </div>
      </form>

      <!-- Resultado: Garantía encontrada -->
      <div
        v-if="garantiaEncontrada"
        class="mt-10 bg-green-100 dark:bg-green-800 text-green-900 dark:text-green-100 p-6 rounded-xl text-center animate-fade-up"
      >
        <h2 class="text-2xl font-bold mb-2">✅ Garantía activa</h2>
        <p>Tu producto está cubierto hasta: <strong>{{ garantia.fechaFin }}</strong></p>
        <p class="mt-2">🛠️ Detalles: {{ garantia.detalles }}</p>
      </div>

      <!-- Resultado: No encontrada -->
      <div
        v-else-if="buscarRealizado"
        class="mt-10 bg-red-100 dark:bg-red-800 text-red-900 dark:text-red-100 p-6 rounded-xl text-center animate-fade-up"
      >
        <h2 class="text-2xl font-bold mb-2">❌ No se encontró garantía</h2>
        <p>Revisa el número de pedido o <router-link to="/contact" class="underline font-medium">contáctanos</router-link> para más información.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
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

<style scoped>
@keyframes fade-up {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fade-up 0.5s ease-out both;
}
</style>
