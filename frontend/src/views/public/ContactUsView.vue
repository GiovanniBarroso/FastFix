<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-100">
    <div class="max-w-2xl mx-auto px-6">
      <!-- Título -->
      <h1 class="text-4xl font-extrabold text-center mb-4 text-gray-900 dark:text-white">📩 Contáctanos</h1>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-10">
        ¿Tienes alguna duda o consulta? ¡Escríbenos y te responderemos lo antes posible!
      </p>

      <!-- Formulario -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <form @submit.prevent="enviarConsulta" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
            <input
              v-model="form.nombre"
              type="text"
              required
              class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensaje</label>
            <textarea
              v-model="form.mensaje"
              rows="6"
              required
              class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>

          <div class="flex justify-center">
            <button
              type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-md shadow transition-all duration-300"
            >
              Enviar mensaje
            </button>
          </div>
        </form>

        <div
          v-if="mensajeEnviado"
          class="mt-6 text-green-600 dark:text-green-400 text-center font-medium"
        >
          ✅ ¡Mensaje enviado correctamente! Gracias por contactarnos.
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  nombre: '',
  email: '',
  mensaje: ''
})

const mensajeEnviado = ref(false)

const enviarConsulta = () => {
  console.log('Consulta enviada:', form.value)
  mensajeEnviado.value = true

  setTimeout(() => {
    mensajeEnviado.value = false
    form.value = {
      nombre: '',
      email: '',
      mensaje: ''
    }
  }, 2000)
}
</script>
