<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Restablecer contraseña</h1>

      <form @submit.prevent="resetPassword" class="space-y-5">
        <!-- Campos -->
        <input type="hidden" v-model="token" />

        <FormField v-model="email" label="Correo electrónico" placeholder="tucorreo@fastfix.com" type="email"
          autocomplete="email" />

        <FormField v-model="password" label="Nueva contraseña" placeholder="••••••••" type="password"
          autocomplete="new-password" />

        <FormField v-model="password_confirmation" label="Confirmar contraseña" placeholder="••••••••" type="password"
          autocomplete="new-password" />

        <!-- Estado / Error -->
        <AlertMessage v-if="status" type="success" :message="status" />
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón -->
        <BaseButton :loading="loading" fullWidth>
          Guardar contraseña
        </BaseButton>

        <!-- Volver al login -->
        <div class="text-center">
          <router-link to="/login" class="text-sm text-blue-600 hover:underline">
            Volver a iniciar sesión
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from '@/utils/axios'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const token = ref('')
const status = ref('')
const errorMessage = ref('')
const loading = ref(false)

const route = useRoute()
const router = useRouter()

onMounted(() => {
  token.value = route.query.token || ''
  email.value = route.query.email || ''
})

const resetPassword = async () => {
  status.value = ''
  errorMessage.value = ''
  loading.value = true

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
  } finally {
    loading.value = false
  }
}
</script>
