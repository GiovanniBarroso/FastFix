<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 px-4">
    <div
      class="w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700"
      data-aos="fade-up"
      data-aos-duration="700"
    >
      <h1 class="text-3xl font-extrabold text-center mb-4 bg-gradient-to-r from-red-500 to-yellow-400 text-transparent bg-clip-text animate-glow">
        🔒 Confirmar contraseña
      </h1>

      <p class="text-sm text-gray-600 dark:text-gray-300 text-center mb-6 leading-relaxed">
        Esta es un área segura. Por favor, confirma tu contraseña antes de continuar.
      </p>

      <form @submit.prevent="confirmPassword" class="space-y-6">
        <!-- Campo contraseña -->
        <FormField
          v-model="password"
          label="Contraseña"
          placeholder="••••••••"
          type="password"
          autocomplete="current-password"
        />

        <!-- Error -->
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón -->
        <BaseButton :loading="loading" fullWidth>✅ Confirmar</BaseButton>
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
<style>@keyframes glow {
  0% {
    text-shadow: 0 0 5px rgba(255, 99, 71, 0.4), 0 0 10px rgba(255, 165, 0, 0.3);
  }
  100% {
    text-shadow: 0 0 15px rgba(255, 99, 71, 0.6), 0 0 30px rgba(255, 165, 0, 0.4);
  }
}
.animate-glow {
  animation: glow 2s ease-in-out infinite alternate;
}
</style>