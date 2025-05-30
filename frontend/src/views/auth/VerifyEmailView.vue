<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-white px-4 py-12"
  >
    <div
      class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 md:p-10 animate-fade-up"
      data-aos="fade-up"
    >
      <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-4">
        Verifica tu correo electrónico
      </h1>

      <p class="text-sm text-gray-600 text-center mb-6 leading-relaxed">
        Gracias por registrarte. Antes de comenzar, por favor verifica tu dirección de correo
        haciendo clic en el enlace que te enviamos. Si no lo has recibido, puedes reenviarlo.
      </p>

      <form @submit.prevent="resendVerification">
        <BaseButton :loading="loading" fullWidth> Reenviar correo de verificación </BaseButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { useRoute } from 'vue-router'

import BaseButton from '@/views/components/BaseButton.vue'
import ToastService from '@/services/ToastService.js'

const errorMessage = ref('')
const loading = ref(false)
const route = useRoute()

onMounted(() => {
  const { registered, verified } = route.query

  if (registered === '1') {
    ToastService.success('¡Cuenta creada! Revisa tu correo para verificarla.')
  }

  if (verified === '1') {
    ToastService.success('¡Correo verificado! Ya puedes iniciar sesión.')
  } else if (verified === '0') {
    ToastService.error('Hubo un error al verificar tu correo. Intenta nuevamente.')
  }
})

const resendVerification = async () => {
  errorMessage.value = ''
  loading.value = true

  try {
    await api.post('/email/verification-notification')
    ToastService.success('¡Correo de verificación reenviado con éxito!')
  } catch (error) {
    ToastService.error('No se pudo reenviar el correo. Intenta más tarde.')
  } finally {
    loading.value = false
  }
}
</script>
