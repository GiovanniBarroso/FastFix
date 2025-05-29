<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-xl bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Editar Perfil</h1>

      <form @submit.prevent="updateProfile" class="space-y-5">
        <FormField v-model="nombre" label="Nombre completo" type="text" />
        <FormField v-model="apellidos" label="Apellidos" type="text" />
        <FormField v-model="telefono" label="Teléfono" type="tel" />
        <FormField v-model="email" label="Correo electrónico" type="email" />

        <div class="text-sm text-gray-500">
          Estado del correo:
          <span v-if="isVerified" class="text-green-600 font-medium">Verificado ✅</span>
          <span v-else class="text-red-600 font-medium">No verificado ❌</span>
        </div>

        <div v-if="!isVerified" class="text-sm">
          <BaseButton type="button" @click="resendVerification" :loading="sendingVerification">
            Reenviar enlace de verificación
          </BaseButton>
        </div>

        <AlertMessage v-if="status" type="success" :message="status" />
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <BaseButton :loading="loading" fullWidth>Guardar cambios</BaseButton>
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

const nombre = ref('')
const apellidos = ref('')
const telefono = ref('')
const email = ref('')
const isVerified = ref(false)
const loading = ref(false)
const sendingVerification = ref(false)
const status = ref('')
const errorMessage = ref('')

onMounted(async () => {
  try {
    const response = await api.get('/me?plano=true')
    nombre.value = response.data.nombre
    apellidos.value = response.data.apellidos
    telefono.value = response.data.telefono 
    email.value = response.data.email
    isVerified.value = response.data.email_verified_at !== null
  } catch (error) {
    errorMessage.value = 'Error al cargar los datos del perfil.'
  }
})

const updateProfile = async () => {
  loading.value = true
  status.value = ''
  errorMessage.value = ''

  if (!apellidos.value.trim()) {
    errorMessage.value = 'Los apellidos son obligatorios.'
    loading.value = false
    return
  }

  if (!telefono.value.match(/^\d{9}$/)) {
    errorMessage.value = 'El teléfono debe tener exactamente 9 dígitos numéricos.'
    loading.value = false
    return
  }

  try {
    await api.put('/profile-information', {
      nombre: nombre.value,
      apellidos: apellidos.value,
      telefono: telefono.value,
      email: email.value
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        Accept: 'application/json'
      }
    })
    status.value = 'Perfil actualizado correctamente.'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'No se pudo actualizar el perfil.'
  } finally {
    loading.value = false
  }
}

const resendVerification = async () => {
  sendingVerification.value = true
  errorMessage.value = ''
  status.value = ''

  try {
    await api.post('/email/verification-notification')
    status.value = 'Correo de verificación enviado. Revisa tu bandeja de entrada.'
  } catch (error) {
    errorMessage.value = 'No se pudo reenviar el correo de verificación.'
  } finally {
    sendingVerification.value = false
  }
}
</script>
