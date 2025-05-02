<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">
        Autenticación de dos factores
      </h1>

      <form @submit.prevent="submit" class="space-y-5">
        <FormField v-model="code" label="Código de autenticación" placeholder="123456" type="text"
          autocomplete="one-time-code" />

        <FormField v-model="recovery_code" label="Código de recuperación" placeholder="••••••••••" type="text" />

        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <BaseButton :loading="loading" fullWidth>
          Verificar
        </BaseButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from '@/utils/axios'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const code = ref('')
const recovery_code = ref('')
const errorMessage = ref('')
const loading = ref(false)
const router = useRouter()

const submit = async () => {
  errorMessage.value = ''
  loading.value = true

  try {
    const response = await axios.post('/two-factor-challenge', {
      code: code.value,
      recovery_code: recovery_code.value,
    })

    localStorage.setItem('token', response.data.token)
    router.push('/')
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Código incorrecto.'
  } finally {
    loading.value = false
  }
}
</script>
