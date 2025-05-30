<template>
  <section
    class="py-16 bg-[#F8F9FA] dark:bg-[#1E2A38] min-h-screen text-[#1E2A38] dark:text-gray-100"
  >
    <div class="max-w-3xl mx-auto px-6 animate-fade-up">
      <!-- Título -->
      <div class="text-center mb-10">
        <h1
          class="text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text animate-glow"
        >
          📩 Contáctanos
        </h1>
        <p class="mt-3 text-lg text-gray-600 dark:text-gray-300">
          ¿Tienes alguna duda o consulta? ¡Escríbenos y te responderemos lo antes posible!
        </p>
      </div>

      <!-- Formulario -->
      <div
        class="bg-white dark:bg-[#2C3E50] rounded-3xl shadow-xl p-8 space-y-6 border border-gray-200 dark:border-gray-700"
      >
        <form @submit.prevent="enviarConsulta" class="space-y-6">
          <!-- Nombre -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1"
              >Nombre</label
            >
            <input
              v-model="form.nombre"
              type="text"
              required
              :class="inputClass(form.nombre)"
              class="w-full p-3 rounded-xl border bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1"
              >Correo electrónico</label
            >
            <input
              v-model="form.email"
              type="email"
              required
              :class="inputClass(form.email)"
              class="w-full p-3 rounded-xl border bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <!-- Mensaje -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1"
              >Mensaje</label
            >
            <textarea
              v-model="form.mensaje"
              rows="6"
              required
              :class="inputClass(form.mensaje)"
              class="w-full p-3 rounded-xl border bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>

          <!-- Botón enviar -->
          <div class="flex justify-center">
            <button
              type="submit"
              :disabled="enviando"
              class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-8 py-3 rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="!enviando">Enviar mensaje</span>
              <span v-else class="flex items-center gap-2">
                <svg
                  class="animate-spin h-5 w-5 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                </svg>
                Enviando...
              </span>
            </button>
          </div>
        </form>

        <!-- Mensaje de éxito -->
        <transition name="fade">
          <div
            v-if="mensajeEnviado"
            class="mt-6 text-green-600 dark:text-green-400 text-center font-semibold"
          >
            ✅ ¡Mensaje enviado correctamente! Gracias por contactarnos.
          </div>
        </transition>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  nombre: '',
  email: '',
  mensaje: '',
})

const mensajeEnviado = ref(false)
const enviando = ref(false)
const intentadoEnviar = ref(false)

const inputClass = (campo) =>
  `${!campo && intentadoEnviar.value ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600'}`

const enviarConsulta = async () => {
  intentadoEnviar.value = true
  if (!form.value.nombre.trim() || !form.value.email.trim() || !form.value.mensaje.trim()) return

  enviando.value = true

  try {
    const res = await fetch(`${import.meta.env.VITE_API_BASE_URL}/contact`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form.value),
    })

    if (!res.ok) throw new Error('Error al enviar mensaje')

    mensajeEnviado.value = true
    form.value = { nombre: '', email: '', mensaje: '' }
  } catch (err) {
    console.error(err)
    alert('❌ Ocurrió un error al enviar tu mensaje. Intenta más tarde.')
  } finally {
    enviando.value = false
    setTimeout(() => (mensajeEnviado.value = false), 4000)
  }
}
</script>

<style scoped>
@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fadeUp 0.8s ease-out both;
}

@keyframes glow {
  0% {
    text-shadow:
      0 0 4px rgba(0, 123, 255, 0.5),
      0 0 12px rgba(0, 123, 255, 0.4);
  }
  100% {
    text-shadow:
      0 0 12px rgba(255, 255, 255, 0.3),
      0 0 18px rgba(0, 123, 255, 0.3);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
