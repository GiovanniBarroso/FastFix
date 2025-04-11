<template>
    <div class="auth-container">
      <h1 class="text-2xl font-bold text-center mb-6">¿Olvidaste tu contraseña?</h1>
      <p class="text-sm text-gray-600 mb-4 text-center">
        No hay problema. Indícanos tu dirección de correo electrónico y te enviaremos un enlace para que puedas restablecer tu contraseña.
      </p>
  
      <form @submit.prevent="sendResetLink" class="space-y-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
          <input
            v-model="email"
            type="email"
            id="email"
            required
            class="input"
            placeholder="ejemplo@correo.com"
          />
        </div>
  
        <div v-if="status" class="text-green-600 text-sm text-center">
          {{ status }}
        </div>
  
        <div v-if="errorMessage" class="text-red-600 text-sm text-center">
          {{ errorMessage }}
        </div>
  
        <button type="submit" class="btn-primary w-full">Enviar enlace</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from '@/utils/axios'
  
  const email = ref('')
  const status = ref('')
  const errorMessage = ref('')
  
  const sendResetLink = async () => {
    try {
      const response = await axios.post('/forgot-password', {
        email: email.value,
      })
      status.value = response.data.status
      errorMessage.value = ''
    } catch (error) {
      console.error(error)
      status.value = ''
      errorMessage.value = error.response?.data?.message || 'Ha ocurrido un error.'
    }
  }
  </script>
  
  <style scoped>
  .auth-container {
    max-width: 400px;
    margin: 4rem auto;
    padding: 2rem;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
  }
  
  .input {
    width: 100%;
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.2s;
  }
  
  .input:focus {
    border-color: #6366f1;
  }
  
  .btn-primary {
    background-color: #6366f1;
    color: white;
    padding: 0.6rem;
    font-weight: bold;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
  }
  
  .btn-primary:hover {
    background-color: #4f46e5;
  }
  </style>
  