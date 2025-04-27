<template>
    <div class="auth-container">
      <h1 class="text-2xl font-bold text-center mb-6">Restablecer contraseña</h1>
  
      <form @submit.prevent="resetPassword" class="space-y-4">
        <input type="hidden" v-model="token" />
  
        <div>
          <label for="email" class="block text-sm  text-gray-700">Correo electrónico</label>
          <input
            v-model="email"
            type="email"
            id="email"
            required
            class="input"
          />
        </div>
  
        <div>
          <label for="password" class="block text-sm  text-gray-700">Nueva contraseña</label>
          <input
            v-model="password"
            type="password"
            id="password"
            required
            class="input"
          />
        </div>
  
        <div>
          <label for="password_confirmation" class="block text-sm  text-gray-700">Confirmar contraseña</label>
          <input
            v-model="password_confirmation"
            type="password"
            id="password_confirmation"
            required
            class="input"
          />
        </div>
  
        <div v-if="status" class="text-green-600 text-sm text-center">{{ status }}</div>
        <div v-if="errorMessage" class="text-red-600 text-sm text-center">{{ errorMessage }}</div>
  
        <button type="submit" class="btn-primary w-full">Guardar contraseña</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import axios from '@/utils/axios'
  
  const email = ref('')
  const password = ref('')
  const password_confirmation = ref('')
  const token = ref('')
  const status = ref('')
  const errorMessage = ref('')
  const route = useRoute()
  const router = useRouter()
  
  onMounted(() => {
    token.value = route.query.token || ''
    email.value = route.query.email || ''
  })
  
  const resetPassword = async () => {
    try {
      const response = await axios.post('/reset-password', {
        token: token.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
      })
      status.value = response.data.message || 'Contraseña actualizada correctamente.'
      router.push('/login')
    } catch (error) {
      errorMessage.value = error.response?.data?.message || 'Error al actualizar la contraseña.'
    }
  }
  </script>
  
  <style scoped>

  </style>
  