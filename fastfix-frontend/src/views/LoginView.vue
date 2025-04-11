<template>
    <div class="auth-container">
      <h1 class="text-3xl font-bold text-center mb-6">Iniciar Sesión</h1>
      <form @submit.prevent="login" class="space-y-4">
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
  
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input
            v-model="password"
            type="password"
            id="password"
            required
            class="input"
            placeholder="********"
          />
        </div>
  
        <div v-if="errorMessage" class="text-red-600 text-sm">
          {{ errorMessage }}
        </div>
  
        <button type="submit" class="btn-primary w-full">Entrar</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axiosInstance from '@/utils/axios.js'
  import { useRouter } from 'vue-router'
  
  const email = ref('')
  const password = ref('')
  const errorMessage = ref('')
  const router = useRouter()
  
  const login = async () => {
    try {
      const response = await axiosInstance.post('/login', {
        email: email.value,
        password: password.value
      })
  
      const token = response.data.token
      localStorage.setItem('token', token)
  
      router.push('/')
    } catch (error) {
      console.error(error)
      errorMessage.value = error.response?.data?.message || 'Error al iniciar sesión.'
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
  