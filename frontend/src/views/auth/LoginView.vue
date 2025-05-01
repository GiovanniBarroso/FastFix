<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Iniciar sesión</h1>

      <form @submit.prevent="handleLogin" class="space-y-5">
        <!-- Email -->
        <FormField v-model="email" label="Correo electrónico" placeholder="tucorreo@fastfix.com" type="email"
          autocomplete="email" />

        <!-- Contraseña -->
        <FormField v-model="password" label="Contraseña" placeholder="••••••••" type="password"
          autocomplete="current-password" />

        <!-- Error -->
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón iniciar sesión -->
        <BaseButton :loading="loading" fullWidth>
          Iniciar sesión
        </BaseButton>


        <div class="flex flex-col items-center space-y-1">
          <!-- Link recuperar contraseña -->
          <div class="text-center">
            <router-link to="/forgot-password" class="text-sm text-blue-600 hover:underline">
              ¿Has olvidado tu contraseña?
            </router-link>
          </div>

          <!-- Link recuperar contraseña -->
          <div class="text-center">
            <router-link to="/register" class="text-sm text-blue-600 hover:underline">
              ¿No estás registrado?
            </router-link>
          </div>
        </div>

      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from '@/utils/axios'

// 🧩 Importamos nuestros componentes
import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const loading = ref(false)
const router = useRouter()

const handleLogin = async () => {
  errorMessage.value = ''
  loading.value = true

  try {
    const response = await axios.post('/login', {
      email: email.value,
      password: password.value
    })

    const token = response.data.token
    const role = response.data.role || 'user'

    localStorage.setItem('token', token)
    localStorage.setItem('role', role)

    router.push(role === 'admin' ? '/admin' : '/')
  } catch (error) {
    errorMessage.value =
      error.response?.data?.message || 'Credenciales incorrectas.'
  } finally {
    loading.value = false
  }
}
</script>
