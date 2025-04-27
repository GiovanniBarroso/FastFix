<template>
  <div class="auth-container">
    <h1 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h1>

    <form @submit.prevent="login" class="space-y-4">
      <div>
        <label for="email" class="block text-sm  text-gray-700">Correo electrónico</label>
        <input v-model="email" type="email" id="email" required class="input" />
      </div>

      <div>
        <label for="password" class="block text-sm  text-gray-700">Contraseña</label>
        <input v-model="password" type="password" id="password" required class="input" />
      </div>

      <div v-if="errorMessage" class="text-red-600 text-sm text-center">
        {{ errorMessage }}
      </div>

      <button type="submit" class="btn-primary w-full">Entrar</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/services/api'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const router = useRouter()

const login = async () => {
  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value
    })

    console.log('Response completa:', response)
    console.log('Token recibido:', response.data.token)


    const token = response.data.token
    const user = response.data.user

    localStorage.setItem('token', token)
    localStorage.setItem('user', JSON.stringify(user))

    router.push('/')
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Error inesperado al iniciar sesión.'
  }
}
</script>

<style scoped></style>
