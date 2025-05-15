<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">
        Verifica tu correo electrónico
      </h1>

      <p class="text-sm text-gray-600 text-center mb-6">
        Gracias por registrarte. Antes de comenzar, por favor verifica tu dirección de correo haciendo clic en el enlace
        que te enviamos.
      </p>

      <!-- Estado / error -->
      <AlertMessage v-if="status" type="success" :message="status" />
      <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

      <!-- Botón reenviar -->
      <form @submit.prevent="resendVerification">
        <BaseButton :loading="loading" fullWidth>
          Reenviar correo de verificación
        </BaseButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/services/api'

import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const status = ref('')
const errorMessage = ref('')
const loading = ref(false)

const resendVerification = async () => {
  errorMessage.value = ''
  status.value = ''
  loading.value = true

  try {
    const response = await api.post('/email/verification-notification')
    status.value = response.data.status || '¡Correo reenviado con éxito!'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Error al reenviar el correo.'
  } finally {
    loading.value = false
  }
}
</script>
