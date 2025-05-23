<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">
        Confirmar contraseña
      </h1>

      <p class="text-sm text-gray-600 text-center mb-6">
        Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
      </p>

      <form @submit.prevent="confirmPassword" class="space-y-5">
        <!-- Campo contraseña -->
        <FormField v-model="password" label="Contraseña" placeholder="••••••••" type="password"
          autocomplete="current-password" />

        <!-- Error -->
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón -->
        <BaseButton :loading="loading" fullWidth>
          Confirmar
        </BaseButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/services/api'
import { useRouter } from 'vue-router'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const password = ref('')
const errorMessage = ref('')
const loading = ref(false)
const router = useRouter()

const confirmPassword = async () => {
  errorMessage.value = ''
  loading.value = true

  try {
    await api.post('/user/confirm-password', {
      password: password.value
    })

    localStorage.setItem('passwordConfirmed', 'true')

    router.push('/change-password')
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Contraseña incorrecta.'
  } finally {
    loading.value = false
  }
}
</script>
