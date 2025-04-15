<template>
  <div class="auth-container">
    <h1 class="text-2xl font-bold text-center mb-6">Crear cuenta</h1>

    <form @submit.prevent="register" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
        <input v-model="name" type="text" required class="input" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
        <input v-model="email" type="email" required class="input" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
        <input v-model="password" type="password" required class="input" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
        <input v-model="password_confirmation" type="password" required class="input" />
      </div>

      <div v-if="errorMessage" class="text-red-600 text-sm text-center">
        {{ errorMessage }}
      </div>

      <button type="submit" class="btn-primary w-full">Registrarse</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/utils/axios'
import { useRouter } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const errorMessage = ref('')
const router = useRouter()

const register = async () => {
  try {
    const response = await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    const token = response.data.token
    const user = response.data.user

    localStorage.setItem('token', token)
    localStorage.setItem('user', JSON.stringify(user))

    router.push('/')
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Error al registrarse.'
  }
}
</script>

<style scoped>
</style>
