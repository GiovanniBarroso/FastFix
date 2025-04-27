<template>
    <div class="auth-container">
      <h1 class="text-2xl font-bold text-center mb-6">Confirmar contraseña</h1>
      <p class="text-sm text-gray-600 mb-4 text-center">
        Esta es un área segura de la aplicación. Por favor confirma tu contraseña antes de continuar.
      </p>
  
      <form @submit.prevent="confirmPassword" class="space-y-4">
        <div>
          <label for="password" class="block text-sm  text-gray-700">Contraseña</label>
          <input v-model="password" type="password" id="password" required class="input" />
        </div>
  
        <div v-if="errorMessage" class="text-red-600 text-sm text-center">{{ errorMessage }}</div>
  
        <button type="submit" class="btn-primary w-full">Confirmar</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from '@/utils/axios'
  
  const password = ref('')
  const errorMessage = ref('')
  
  const confirmPassword = async () => {
    try {
      await axios.post('/user/confirm-password', { password: password.value })
      window.history.back()
    } catch (error) {
      errorMessage.value = error.response?.data?.message || 'Contraseña incorrecta.'
    }
  }
  </script>
  
  <style scoped>

  </style>
  