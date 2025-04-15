<template>
    <div class="auth-container">
      <h1 class="text-2xl font-bold text-center mb-6">Verifica tu correo electrónico</h1>
      <p class="text-sm text-gray-600 mb-4 text-center">
        Gracias por registrarte. Antes de comenzar, por favor verifica tu dirección de correo haciendo clic en el enlace que te enviamos.
      </p>
  
      <div v-if="status" class="text-green-600 text-sm text-center mb-4">{{ status }}</div>
      <div v-if="errorMessage" class="text-red-600 text-sm text-center mb-4">{{ errorMessage }}</div>
  
      <form @submit.prevent="resendVerification">
        <button type="submit" class="btn-primary w-full">Reenviar correo de verificación</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import axios from '@/utils/axios'
  import { ref } from 'vue'
  
  const status = ref('')
  const errorMessage = ref('')
  
  const resendVerification = async () => {
    try {
      const response = await axios.post('/email/verification-notification')
      status.value = response.data.status || '¡Correo reenviado con éxito!'
      errorMessage.value = ''
    } catch (error) {
      errorMessage.value = error.response?.data?.message || 'Error al reenviar el correo.'
    }
  }
  </script>
  
  <style scoped>

  </style>
  