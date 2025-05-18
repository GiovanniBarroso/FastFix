<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Crear cuenta</h1>

      <form @submit.prevent="handleRegister" class="space-y-5">
        <!-- Nombre -->
        <FormField v-model="name" label="Nombre completo" placeholder="Juan Pérez" type="text" autocomplete="name" />

        <!-- Email -->
        <FormField v-model="email" label="Correo electrónico" placeholder="tucorreo@fastfix.com" type="email"
          autocomplete="email" />

        <!-- Contraseña -->
        <FormField v-model="password" label="Contraseña" placeholder="••••••••" type="password"
          autocomplete="new-password" />

        <!-- Confirmar contraseña -->
        <FormField v-model="password_confirmation" label="Confirmar contraseña" placeholder="••••••••" type="password"
          autocomplete="new-password" />

        <!-- Error -->
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón registrar -->
        <BaseButton :loading="loading" fullWidth>
          Registrarse
        </BaseButton>

        <!-- Ya tienes cuenta -->
        <div class="text-center">
          <router-link to="/login" class="text-sm text-blue-600 hover:underline">
            ¿Ya tienes cuenta? Inicia sesión
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'  // <-- IMPORTANTE
import api from '@/services/api'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const auth = useAuthStore() // <-- DECLARACIÓN

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const errorMessage = ref('')
const loading = ref(false)
const router = useRouter()

const handleRegister = async () => {
  errorMessage.value = ''
  loading.value = true

  if (password.value !== password_confirmation.value) {
    errorMessage.value = 'Las contraseñas no coinciden.'
    loading.value = false
    return
  }

  try {
    const response = await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    // ✅ Guardamos datos del usuario
    auth.login(response.data.token, response.data.user, response.data.role)

    // ✅ Limpiamos
    name.value = ''
    email.value = ''
    password.value = ''
    password_confirmation.value = ''

    // ✅ Redirigimos con query
    router.push({ path: '/verify-email', query: { registered: '1' } })

  } catch (error) {
    console.error('Error en handleRegister:', error)
    errorMessage.value = error.response?.data?.message || 'Error al registrar el usuario.'
  } finally {
    loading.value = false
  }
}
</script>
