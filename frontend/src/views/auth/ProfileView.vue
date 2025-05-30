<template>
  <div
    class="min-h-screen bg-gradient-to-b from-gray-100 via-white to-gray-200 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center px-4 py-12"
  >
    <div
      class="w-full max-w-xl bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-10 border border-gray-200 dark:border-gray-700"
      data-aos="fade-up"
      data-aos-duration="800"
    >
      <h1
        class="text-3xl font-extrabold text-center mb-8 bg-gradient-to-r from-red-500 via-orange-400 to-yellow-400 text-transparent bg-clip-text animate-glow"
      >
        ✏️ Editar perfil
      </h1>

      <form @submit.prevent="updateProfile" class="space-y-6">
        <FormField v-model="nombre" label="Nombre completo" type="text" />
        <FormField v-model="apellidos" label="Apellidos" type="text" />
        <FormField v-model="telefono" label="Teléfono" type="tel" />
        <FormField v-model="email" label="Correo electrónico" type="email" />

        <!-- Estado de verificación -->
        <div class="text-sm">
          <span class="text-gray-600 dark:text-gray-300">Estado del correo:</span>
          <span
            v-if="isVerified"
            class="ml-2 px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-400 rounded-full"
          >
            Verificado ✅
          </span>
          <span
            v-else
            class="ml-2 px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 dark:bg-red-900 dark:text-red-400 rounded-full"
          >
            No verificado ❌
          </span>
        </div>

        <!-- Botón de reenviar -->
        <div v-if="!isVerified">
          <BaseButton
            type="button"
            @click="resendVerification"
            :loading="sendingVerification"
            class="text-sm"
          >
            Reenviar enlace de verificación
          </BaseButton>
        </div>

        <!-- Mensajes -->
        <AlertMessage v-if="status" type="success" :message="status" />
        <AlertMessage v-if="errorMessage" type="error" :message="errorMessage" />

        <!-- Guardar -->
        <BaseButton :loading="loading" fullWidth> 💾 Guardar cambios </BaseButton>
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
    await api.put(
      '/profile-information',
      {
        nombre: nombre.value,
        apellidos: apellidos.value,
        telefono: telefono.value,
        email: email.value,
      },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
          Accept: 'application/json',
        },
      },
    )
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
