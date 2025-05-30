<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-white dark:from-gray-900 dark:to-gray-950 px-4"
  >
    <div
      class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8"
      data-aos="zoom-in"
      data-aos-duration="800"
    >
      <!-- Título -->
      <div class="text-center mb-6" data-aos="fade-up" data-aos-delay="100">
        <h1
          class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 inline-flex items-center gap-2 justify-center"
        >
          🔑 Iniciar sesión
        </h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
          Accede a tu cuenta para continuar
        </p>
      </div>

      <!-- Formulario -->
      <form @submit.prevent="handleLogin" class="space-y-5" data-aos="fade-up" data-aos-delay="200">
        <!-- Email -->
        <FormField
          v-model="email"
          label="Correo electrónico"
          placeholder="tucorreo@fastfix.com"
          type="email"
          autocomplete="email"
        />

        <!-- Contraseña -->
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
            class="absolute right-3 top-[45px] text-xs text-blue-600 hover:underline"
          >
            {{ showPassword ? 'Ocultar' : 'Mostrar' }}
          </button>
        </div>

        <!-- Error -->
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón -->
        <BaseButton :loading="loading" fullWidth> 🚀 Iniciar sesión </BaseButton>

        <!-- Enlaces -->
        <div class="text-center text-sm mt-2 space-y-1">
          <router-link
            to="/forgot-password"
            class="text-blue-600 hover:underline dark:text-blue-400"
          >
            ¿Has olvidado tu contraseña?
          </router-link>
          <br />
          <router-link to="/register" class="text-blue-600 hover:underline dark:text-blue-400">
            ¿No tienes cuenta? Regístrate
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useAuthStore } from '@/stores/authStore'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

import AOS from 'aos'
import 'aos/dist/aos.css'

onMounted(() => {
  AOS.init()
})

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
      password: password.value,
    })

    const token = response.data.token
    const userData = response.data.user
    const role = userData.role_id === 1 ? 'admin' : 'user'

    auth.login(token, userData, role)

    router.push(role === 'admin' ? '/admin' : '/')
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Credenciales incorrectas.'
  } finally {
    loading.value = false
  }
}
</script>
