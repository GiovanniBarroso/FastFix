<template>
    <button @click="logout" class="btn-logout">
      Cerrar sesión
    </button>
  </template>
  
  <script setup>
  import { useRouter } from 'vue-router'
  import api from '@/utils/axios'
  
  const router = useRouter()
  
  const logout = async () => {
    try {
      await api.post('/logout') // Llama al logout del backend (opcional)
    } catch (error) {
      // Si falla, no hay problema: borra el token igual
      console.warn('Logout falló en el servidor, cerrando sesión localmente.')
    }
  
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    router.push('/login')
  }
  </script>
  
  <style scoped>
  .btn-logout {
    background-color: #dc2626;
    color: white;
    padding: 0.5rem 1rem;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  
  .btn-logout:hover {
    background-color: #b91c1c;
  }
  </style>
  