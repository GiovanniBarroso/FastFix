<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-2xl mx-auto px-6">
      <!-- Título -->
      <h1 class="text-4xl font-extrabold text-center mb-4">📝 Solicita tu presupuesto</h1>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-10">
        Cuéntanos tu problema y te enviaremos un presupuesto detallado sin compromiso.
      </p>

      <!-- Formulario -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <form @submit.prevent="enviarPresupuesto" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre completo</label>
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
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
            <input
              v-model="form.telefono"
              type="text"
              class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción del problema</label>
            <textarea
              v-model="form.descripcion"
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

        <div v-if="mensajeEnviado" class="mt-6 text-green-600 dark:text-green-400 text-center font-medium">
          ✅ ¡Solicitud enviada correctamente! Nos pondremos en contacto contigo.
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
  telefono: '',
  descripcion: ''
})

const mensajeEnviado = ref(false)

const enviarPresupuesto = () => {
  console.log('Datos enviados:', form.value)
  mensajeEnviado.value = true

  // Resetear formulario después de 2 segundos
  setTimeout(() => {
    mensajeEnviado.value = false
    form.value = {
      nombre: '',
      email: '',
      telefono: '',
      descripcion: ''
    }
  }, 2000)
}
</script>