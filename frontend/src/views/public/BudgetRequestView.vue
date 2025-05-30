<template>
  <section
    class="py-20 bg-gradient-to-b from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-gray-800 dark:text-gray-100 min-h-screen"
  >
    <div class="max-w-3xl mx-auto px-6">
      <!-- Título -->
      <div class="text-center mb-10" data-aos="fade-up">
        <h1
          class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-purple-600 dark:from-pink-400 dark:to-indigo-500 animate-glow"
        >
          📝 Solicita tu presupuesto
        </h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
          Cuéntanos tu problema y te enviaremos un presupuesto detallado sin compromiso.
        </p>
      </div>

      <!-- Formulario -->
      <div
        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-10 space-y-6"
        data-aos="fade-in"
      >
        <form @submit.prevent="enviarPresupuesto" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
              >Tu nombre</label
            >
            <input
              :value="auth.user?.nombre"
              disabled
              class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white cursor-not-allowed shadow-inner"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
              >Correo electrónico</label
            >
            <input
              :value="auth.user?.email"
              disabled
              class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white cursor-not-allowed shadow-inner"
            />
          </div>

          <div v-if="auth.user?.telefono">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
              >Teléfono</label
            >
            <input
              :value="auth.user?.telefono"
              disabled
              class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white cursor-not-allowed shadow-inner"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
              >Descripción del problema</label
            >
            <textarea
              v-model="form.mensaje"
              rows="6"
              required
              class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-pink-500 shadow-sm"
            ></textarea>
          </div>

          <div class="flex justify-center">
            <button
              class="bg-gradient-to-r from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 text-white font-semibold px-10 py-3 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105"
            >
              Enviar solicitud
            </button>
          </div>
        </form>

        <div
          v-if="mensajeEnviado"
          class="mt-6 text-green-600 dark:text-green-400 text-center font-medium animate-pulse"
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
import { useNotificationStore } from '@/stores/notificationStore'

const auth = useAuthStore()
const router = useRouter()
const notificationStore = useNotificationStore()

const form = ref({
  mensaje: '',
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
      mensaje: form.value.mensaje,
    })

    await notificationStore.fetchNotifications() // 🔔 Actualiza la campana

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
