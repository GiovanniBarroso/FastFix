<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-white dark:from-gray-900 dark:to-gray-950 px-4"
  >
    <div
      class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 animate-fade"
      data-aos="zoom-in"
      data-aos-duration="800"
    >
      <!-- Título con ícono y gradiente -->
      <div class="text-center mb-6" data-aos="fade-up" data-aos-delay="100">
        <h1
          class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 inline-flex items-center gap-2 justify-center"
        >
          🔐 Recuperar contraseña
        </h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
          Introduce tu correo para enviarte un enlace de recuperación.
        </p>
      </div>

      <!-- Formulario -->
      <form
        @submit.prevent="sendResetLink"
        class="space-y-5"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        <FormField
          v-model="email"
          label="Correo electrónico"
          placeholder="tucorreo@fastfix.com"
          type="email"
          autocomplete="email"
        />

        <!-- Mensajes -->
        <AlertMessage v-if="status" type="success" :message="status" />
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Botón -->
        <BaseButton :loading="loading" fullWidth> 📩 Enviar enlace de recuperación </BaseButton>

        <!-- Enlace de retorno -->
        <div class="text-center mt-2">
          <router-link to="/login" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
            ← Volver a iniciar sesión
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

import AOS from 'aos'
import 'aos/dist/aos.css'

onMounted(() => {
  AOS.init()
})

const email = ref('')
const status = ref('')
const errorMessage = ref('')
const loading = ref(false)

const sendResetLink = async () => {
  status.value = ''
  errorMessage.value = ''
  loading.value = true

  try {
    const response = await api.post('/forgot-password', {
      email: email.value,
    })
    status.value = response.data.message || 'Revisa tu correo electrónico.'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'No se pudo enviar el enlace.'
  } finally {
    loading.value = false
  }
}
</script>
