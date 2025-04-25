<template>
    <section class="py-12 px-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-6 text-center">
          📝 Solicita tu presupuesto
        </h1>
  
        <p class="text-center text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto">
          Cuéntanos tu problema y te enviaremos un presupuesto detallado sin compromiso.
        </p>
  
        <form @submit.prevent="enviarPresupuesto" class="space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow">
          <div>
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Nombre completo</label>
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
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Teléfono</label>
            <input
              v-model="form.telefono"
              type="text"
              class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />
          </div>
  
          <div>
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Descripción del problema</label>
            <textarea
              v-model="form.descripcion"
              rows="5"
              required
              class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            ></textarea>
          </div>
  
          <div class="flex justify-center">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded transition">
              Enviar solicitud
            </button>
          </div>
        </form>
  
        <div v-if="mensajeEnviado" class="mt-6 text-green-600 dark:text-green-400 text-center">
          ¡Solicitud enviada correctamente! Nos pondremos en contacto contigo.
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
  