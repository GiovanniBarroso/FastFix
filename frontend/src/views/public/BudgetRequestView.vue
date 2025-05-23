<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-100">
    <div class="max-w-2xl mx-auto px-6">
      <!-- Título -->
      <h1 class="text-4xl font-extrabold text-center mb-4 text-gray-900 dark:text-white">📝 Solicita tu presupuesto</h1>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-10">
        Cuéntanos tu problema y te enviaremos un presupuesto detallado sin compromiso.
      </p>

      <!-- Formulario -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <form @submit.prevent="enviarPresupuesto" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tu nombre</label>
            <input
              :value="auth.user?.name"
              disabled
              class="w-full p-3 rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white cursor-not-allowed"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
            <input
              :value="auth.user?.email"
              disabled
              class="w-full p-3 rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white cursor-not-allowed"
            />
          </div>

          <div v-if="auth.user?.telefono">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
            <input
              :value="auth.user?.telefono"
              disabled
              class="w-full p-3 rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white cursor-not-allowed"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción del problema</label>
            <textarea
              v-model="form.mensaje"
              rows="5"
              required
              class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>

          <div class="flex justify-center">
            <button
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-md shadow transition-all duration-300"
            >
              Enviar solicitud
            </button>
          </div>
        </form>

        <div
          v-if="mensajeEnviado"
          class="mt-6 text-green-600 dark:text-green-400 text-center font-medium"
        >
          ✅ ¡Solicitud enviada correctamente! Nos pondremos en contacto contigo.
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useAuthStore } from '@/stores/authStore'

const auth = useAuthStore()
const router = useRouter()

const form = ref({
  mensaje: ''
})

const mensajeEnviado = ref(false)

onMounted(() => {
  if (!auth.isAuthenticated()) {
    router.push('/login')
  }
})

const enviarPresupuesto = async () => {
  try {
    await api.post('/budgets', {
      mensaje: form.value.mensaje
    })

    mensajeEnviado.value = true
    form.value.mensaje = ''

    setTimeout(() => {
      mensajeEnviado.value = false
    }, 3000)
  } catch (error) {
    console.error('Error al enviar presupuesto:', error)
    alert('Error al enviar el presupuesto. Intenta más tarde.')
  }
}
</script>
