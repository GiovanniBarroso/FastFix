<template>
  <nav class="bg-gray-900 shadow-md fixed w-full z-50 text-white">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <!-- Logo -->
      <div class="align-left">
        <img src="/logoFastFix.png" alt="FastFix Logo" />
        <router-link to="/" class="text-2xl font-bold text-white">
          FastFix
        </router-link>
      </div>

      <!-- Botón mobile -->
      <button @click="toggleMobileMenu" class="sm:hidden text-white text-2xl">
        <span v-if="!mobileMenuOpen">☰</span>
        <span v-else>✖</span>
      </button>

      <!-- Menú Desktop -->
      <div class="hidden sm:flex items-center gap-6">
        <router-link to="/" class="hover:text-red-400 transition-colors">Inicio</router-link>
        <router-link to="/products" class="hover:text-red-400 transition-colors">Productos</router-link>
        <router-link to="/about" class="hover:text-red-400 transition-colors">Sobre nosotros</router-link>
        <router-link to="/cart" class="hover:text-red-400 transition-colors">Carrito</router-link>

        <template v-if="isAuthenticated">
          <!-- Panel dinámico: admin o usuario -->
          <router-link
            :to="isAdmin ? '/admin' : '/home'"
            class="hover:text-red-400 transition-colors"
          >
            Panel
          </router-link>

          <!-- Dropdown usuario -->
          <div class="relative" ref="dropdownRef">
            <button @click="toggleMenu" class="flex items-center space-x-1 hover:text-red-400 transition">
              <span>{{ user.name }}</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <transition name="fade">
              <div
                v-if="showMenu"
                class="absolute right-0 mt-2 w-40 bg-gray-800 border border-gray-600 rounded shadow-lg z-50"
              >
                <button @click="logout" class="w-full text-left px-4 py-2 text-white hover:bg-red-600 transition">
                  Cerrar sesión
                </button>
              </div>
            </transition>
          </div>

          <!-- Notificaciones solo para admin -->
          <NotificationCenter v-if="isAdmin" />
        </template>

        <template v-else>
          <div class="flex gap-2">
            <router-link to="/login"
              class="bg-white text-gray-900 font-semibold rounded-full px-4 py-2 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-200 hover:shadow-lg">
              Iniciar sesión
            </router-link>
            <router-link to="/register"
              class="bg-red-600 text-white font-semibold rounded-full px-4 py-2 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-red-700 hover:shadow-lg">
              Registrarse
            </router-link>
          </div>
        </template>
      </div>
    </div>

    <!-- Menú Mobile -->
    <div v-if="mobileMenuOpen" class="sm:hidden px-6 pt-4 pb-6 bg-gray-900 text-white space-y-4">
      <router-link to="/" class="block hover:text-red-400 transition">Inicio</router-link>
      <router-link to="/products" class="block hover:text-red-400 transition">Productos</router-link>
      <router-link to="/about" class="block hover:text-red-400 transition">Sobre nosotros</router-link>
      <router-link to="/cart" class="block hover:text-red-400 transition">🛒 Carrito</router-link>

      <template v-if="isAuthenticated">
        <router-link :to="isAdmin ? '/admin' : '/home'" class="block hover:text-red-400 transition">
          {{ isAdmin ? 'Admin' : 'Panel de Usuario' }}
        </router-link>
        <button @click="logout" class="block text-left w-full text-red-400 hover:text-red-200 transition">
          Cerrar sesión
        </button>
      </template>

      <template v-else>
        <router-link to="/login" class="block hover:text-red-400 transition">Iniciar sesión</router-link>
        <router-link to="/register" class="block hover:text-red-400 transition">Registrarse</router-link>
      </template>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useAuthStore } from '@/stores/authStore'
import NotificationCenter from '@/components/admin/NotificationCenter.vue'

const router = useRouter()
const auth = useAuthStore()

const showMenu = ref(false)
const mobileMenuOpen = ref(false)
const dropdownRef = ref(null)

const user = computed(() => auth.user)
const isAuthenticated = computed(() => auth.isAuthenticated())
const isAdmin = computed(() => auth.isAdmin())

const logout = async () => {
  try {
    await api.post('/logout')
  } catch (e) {
    console.warn('Error al cerrar sesión')
  } finally {
    auth.logout()
    router.push('/login')
  }
}

const toggleMenu = () => {
  showMenu.value = !showMenu.value
}

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    showMenu.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.align-left {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  margin-right: auto;
}
</style>
