<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Recuperar contraseña</h1>

      <form @submit.prevent="sendResetLink" class="space-y-5">
        <!-- Campo email -->
        <FormField v-model="email" label="Correo electrónico" placeholder="tucorreo@fastfix.com" type="email"
          autocomplete="email" />

        <!-- Estado / Error -->
        <AlertMessage v-if="status" type="success" :message="status" />
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón enviar -->
        <BaseButton :loading="loading" fullWidth>
          Enviar enlace de recuperación
        </BaseButton>

        <!-- Volver a login -->
        <div class="text-center">
          <router-link to="/login" class="text-sm text-blue-600 hover:underline">
            Volver a iniciar sesión
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from '@/utils/axios'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const email = ref('')
const status = ref('')
const errorMessage = ref('')
const loading = ref(false)

const sendResetLink = async () => {
  status.value = ''
  errorMessage.value = ''
  loading.value = true

  try {
    const response = await axios.post('/forgot-password', {
      email: email.value
    })

    status.value = response.data.message || 'Revisa tu correo electrónico.'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'No se pudo enviar el enlace.'
  } finally {
    loading.value = false
  }
}
</script>
