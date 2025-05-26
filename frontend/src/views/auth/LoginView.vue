<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Iniciar sesión</h1>

      <form @submit.prevent="handleLogin" class="space-y-5">
        <!-- Email -->
        <FormField
          v-model="email"
          label="Correo electrónico"
          placeholder="tucorreo@fastfix.com"
          type="email"
          autocomplete="email"
        />

        <!-- Contraseña con mostrar/ocultar -->
        <div class="relative">
          <FormField
            :type="showPassword ? 'text' : 'password'"
            v-model="password"
            label="Contraseña"
            placeholder="••••••••"
            autocomplete="current-password"
          />
          <button
            type="button"
            @click="togglePassword"
            class="absolute right-2 top-9 text-sm text-blue-500"
          >
            {{ showPassword ? 'Ocultar' : 'Mostrar' }}
          </button>
        </div>

        <!-- Error -->
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón iniciar sesión -->
        <BaseButton :loading="loading" fullWidth>
          Iniciar sesión
        </BaseButton>

        <div class="flex flex-col items-center space-y-1">
          <router-link to="/forgot-password" class="text-sm text-blue-600 hover:underline">
            ¿Has olvidado tu contraseña?
          </router-link>
          <router-link to="/register" class="text-sm text-blue-600 hover:underline">
            ¿No estás registrado?
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useAuthStore } from '@/stores/authStore'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const errorMessage = ref('')
const loading = ref(false)
const router = useRouter()
const auth = useAuthStore()

const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const handleLogin = async () => {
  errorMessage.value = ''
  loading.value = true

  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value
    })

    const token = response.data.token
    const userData = response.data.user
    const role = userData.role_id === 1 ? 'admin' : 'user'

    auth.login(token, userData, role)

    router.push(role === 'admin' ? '/admin' : '/')
  } catch (error) {
    errorMessage.value =
      error.response?.data?.message || 'Credenciales incorrectas.'
  } finally {
    loading.value = false
  }
}
</script>
