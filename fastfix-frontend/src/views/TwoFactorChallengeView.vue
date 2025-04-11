<template>
    <div class="auth-container">
      <h1 class="text-2xl font-bold text-center mb-6">Autenticación de dos factores</h1>
  
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Código de autenticación</label>
          <input v-model="code" type="text" class="input" autocomplete="one-time-code" />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Código de recuperación</label>
          <input v-model="recovery_code" type="text" class="input" />
        </div>
  
        <div v-if="errorMessage" class="text-red-600 text-sm text-center">{{ errorMessage }}</div>
  
        <button type="submit" class="btn-primary w-full">Verificar</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import axios from '@/utils/axios'
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  
  const code = ref('')
  const recovery_code = ref('')
  const errorMessage = ref('')
  const router = useRouter()
  
  const submit = async () => {
    try {
      const response = await axios.post('/two-factor-challenge', {
        code: code.value,
        recovery_code: recovery_code.value,
      })
      localStorage.setItem('token', response.data.token)
      router.push('/')
    } catch (error) {
      errorMessage.value = error.response?.data?.message || 'Código incorrecto.'
    }
  }
  </script>
  
  <style scoped>
  @import './AuthStyles.css';
  </style>
  