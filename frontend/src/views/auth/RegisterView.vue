<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Crear cuenta</h1>

      <form @submit.prevent="handleRegister" class="space-y-5">
        <!-- Nombre -->
        <FormField v-model="nombre" label="Nombre" placeholder="Juan" type="text" autocomplete="given-name" />
        <span v-if="nombre && nombre.length < 2" class="text-red-500 text-sm">El nombre debe tener al menos 2
          caracteres.</span>

        <!-- Apellidos -->
        <FormField v-model="apellidos" label="Apellidos" placeholder="Pérez García" type="text"
          autocomplete="family-name" />
        <span v-if="apellidos && apellidos.length < 2" class="text-red-500 text-sm">Los apellidos deben tener al menos 2
          caracteres.</span>

        <!-- Teléfono -->
        <FormField v-model="telefono" label="Teléfono" placeholder="654321987" type="tel" autocomplete="tel" />
        <span v-if="telefono && (!/^\d{9}$/.test(telefono))" class="text-red-500 text-sm">
          El teléfono debe tener exactamente 9 dígitos numéricos.
        </span>

        <!-- Email -->
        <FormField v-model="email" label="Correo electrónico" placeholder="tucorreo@fastfix.com" type="email"
          autocomplete="email" />
        <span v-if="email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)" class="text-red-500 text-sm">Correo electrónico
          no válido.</span>

        <!-- Contraseña -->
        <div class="relative">
          <FormField :type="showPassword ? 'text' : 'password'" v-model="password" label="Contraseña"
            placeholder="••••••••" autocomplete="new-password" />
          <button type="button" @click="togglePassword" class="absolute right-2 top-9 text-sm text-blue-500">
            {{ showPassword ? 'Ocultar' : 'Mostrar' }}
          </button>
        </div>
        <span v-if="password && password.length < 8" class="text-red-500 text-sm">La contraseña debe tener al menos 8
          caracteres.</span>

        <!-- Confirmar contraseña -->
        <FormField v-model="password_confirmation" label="Confirmar contraseña" placeholder="••••••••" type="password"
          autocomplete="new-password" />
        <span v-if="password && password_confirmation && password !== password_confirmation"
          class="text-red-500 text-sm">Las contraseñas no coinciden.</span>

        <!-- Error general -->
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
import api from '@/services/api'

import FormField from '@/views/components/FormField.vue'
import BaseButton from '@/views/components/BaseButton.vue'
import AlertMessage from '@/views/components/AlertMessage.vue'

const nombre = ref('')
const apellidos = ref('')
const telefono = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const errorMessage = ref('')
const loading = ref(false)
const showPassword = ref(false)
const router = useRouter()

const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const handleRegister = async () => {
  errorMessage.value = ''
  loading.value = true

  // Validaciones básicas
  if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,}$/.test(apellidos.value)) {
    errorMessage.value = 'Los apellidos deben tener al menos 2 letras y solo contener letras o espacios.'
    loading.value = false
    return
  }

  if (!/^\d{9}$/.test(telefono.value)) {
    errorMessage.value = 'El teléfono debe tener exactamente 9 números.'
    loading.value = false
    return
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    errorMessage.value = 'Correo electrónico no válido.'
    loading.value = false
    return
  }

  if (password.value.length < 8) {
    errorMessage.value = 'La contraseña debe tener al menos 8 caracteres.'
    loading.value = false
    return
  }

  if (password.value !== password_confirmation.value) {
    errorMessage.value = 'Las contraseñas no coinciden.'
    loading.value = false
    return
  }

  try {
    await api.post('/register', {
      nombre: nombre.value,
      apellidos: apellidos.value,
      telefono: telefono.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    nombre.value = ''
    apellidos.value = ''
    telefono.value = ''
    email.value = ''
    password.value = ''
    password_confirmation.value = ''

    router.push({ path: '/verify-email', query: { registered: '1' } })

  } catch (error) {
    console.error('Error en handleRegister:', error)
    errorMessage.value = error.response?.data?.message || 'Error al registrar el usuario.'
  } finally {
    loading.value = false
  }
}
</script>
