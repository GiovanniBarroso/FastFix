<template>
  <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-background">
    <div class="w-full max-w-md space-y-8">
      <h1 class="text-3xl font-bold text-center text-primary mb-8">Iniciar Sesión</h1>

      <form @submit.prevent="login" class="bg-card p-8 rounded-xl shadow space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-foreground mb-1">Correo electrónico</label>
          <input v-model="email" type="email" id="email" required
            class="w-full px-4 py-2 rounded-lg border border-border focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
            placeholder="Tu correo" />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-foreground mb-1">Contraseña</label>
          <input v-model="password" type="password" id="password" required
            class="w-full px-4 py-2 rounded-lg border border-border focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
            placeholder="Tu contraseña" />
        </div>

        <div v-if="errorMessage" class="text-center text-red-500 text-sm">
          {{ errorMessage }}
        </div>

        <button type="submit"
          class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition font-semibold">
          Entrar
        </button>
      </form>
    </div>
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

<style scoped>
/* No es necesario usar @apply */
</style>
