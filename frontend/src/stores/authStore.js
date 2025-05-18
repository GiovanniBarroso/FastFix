// src/stores/authStore.js
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('token') || null)
  const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))
  const role = ref(localStorage.getItem('role') || 'user')

  const isAuthenticated = () => !!token.value
  const isAdmin = () => role.value === 'admin'

  function login(newToken, newUser, newRole = 'user') {
    token.value = newToken
    user.value = newUser
    role.value = newRole

    localStorage.setItem('token', newToken)
    localStorage.setItem('user', JSON.stringify(newUser))
    localStorage.setItem('role', newRole)
  }

  function logout() {
    token.value = null
    user.value = {}
    role.value = 'user'

    localStorage.clear()
  }

  return {
    token,
    user,
    role,
    isAuthenticated,
    isAdmin,
    login,
    logout,
  }
})
