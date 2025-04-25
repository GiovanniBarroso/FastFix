<template>
    <section class="py-12 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-6 text-center">
          📩 Contáctanos
        </h1>
  
        <p class="text-center text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto">
          ¿Tienes alguna duda o consulta? ¡Escríbenos y te responderemos lo antes posible!
        </p>
  
        <form @submit.prevent="enviarConsulta" class="space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow">
          <div>
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Nombre</label>
            <input
              v-model="form.nombre"
              type="text"
              required
              class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />
          </div>
  
          <div>
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Correo electrónico</label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />
          </div>
  
          <div>
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Mensaje</label>
            <textarea
              v-model="form.mensaje"
              rows="6"
              required
              class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            ></textarea>
          </div>
  
          <div class="flex justify-center">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded transition">
              Enviar mensaje
            </button>
          </div>
        </form>
  
        <div v-if="mensajeEnviado" class="mt-6 text-green-600 dark:text-green-400 text-center">
          ¡Mensaje enviado correctamente! Gracias por contactarnos.
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
  
    // Resetear formulario después de 2 segundos
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
  