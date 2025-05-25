<template>
  <nav class="bg-gray-950 text-white shadow-lg fixed w-full z-50">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="/logoFastFix.png" alt="FastFix" class="w-9 h-9 rounded-full shadow-md" />
        <router-link to="/" class="text-3xl font-bold hover:text-red-500 transition duration-200">FastFix</router-link>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden sm:flex items-center gap-8 font-medium text-base">
        <router-link to="/" class="hover:text-red-400 transition">Inicio</router-link>
        <router-link to="/products" class="hover:text-red-400 transition">Productos</router-link>
        <router-link to="/about" class="hover:text-red-400 transition">Sobre nosotros</router-link>

        <!-- Carrito con contador -->
        <router-link to="/cart" class="relative hover:text-red-400 transition">
          <span class="flex items-center gap-1 relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.293 2.293a1 1 0 00.217 1.09l.243.243a1 1 0 001.09.217L9 15h6l1.293 1.293a1 1 0 001.09-.217l.243-.243a1 1 0 00.217-1.09L17 13M5 21h2a2 2 0 002-2H5a2 2 0 00-2 2zm12 0h2a2 2 0 002-2h-4a2 2 0 002 2z" />
            </svg>
            Carrito
            <span v-if="cartCount > 0"
              class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
              {{ cartCount }}
            </span>
          </span>
        </router-link>

        <!-- Panel y usuario -->
        <template v-if="isAuthenticated">
          <router-link :to="isAdmin ? '/admin' : '/user-panel'" class="hover:text-red-400 transition">Panel</router-link>

          <!-- Menú usuario -->
          <div class="relative" ref="dropdownRef">
            <button @click="toggleMenu" aria-label="Menú de usuario" aria-haspopup="true"
              class="flex items-center gap-2 font-semibold hover:text-red-400 transition">
              <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center uppercase">
                {{ user?.nombre ? user.nombre[0] : '' }}
              </div>


              <ChevronDown class="w-4 h-4" />
            </button>

            <transition name="fade">
              <div v-if="showMenu"
                class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-xl border border-gray-300 z-50 overflow-hidden"
                role="menu">
                <router-link to="/profile" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100"
                  role="menuitem">
                  <User class="w-4 h-4" /> Editar perfil
                </router-link>
                <router-link to="/confirm-password" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100"
                  role="menuitem">
                  <Key class="w-4 h-4" /> Cambiar contraseña
                </router-link>
                <router-link to="/favorites" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100"
                  role="menuitem">
                  <Heart class="w-4 h-4" /> Favoritos
                </router-link>
                <router-link to="/orders" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100"
                  role="menuitem">
                  📦 Mis pedidos
                </router-link>
                <hr class="my-1 border-gray-200" />
                <button @click="logout"
                  class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                  <LogOut class="w-4 h-4" /> Cerrar sesión
                </button>
              </div>
            </transition>
          </div>

          <NotificationCenter v-if="isAdmin" />
        </template>

        <template v-else>
          <router-link to="/login"
            class="bg-white text-gray-900 font-semibold rounded-full px-4 py-2 hover:bg-gray-200 transition">
            Iniciar sesión
          </router-link>
          <router-link to="/register"
            class="bg-red-600 text-white font-semibold rounded-full px-4 py-2 hover:bg-red-700 transition">
            Registrarse
          </router-link>
        </template>
      </div>

      <!-- Botón móvil -->
      <button @click="toggleMobileMenu" class="sm:hidden text-white text-2xl" aria-label="Menú móvil">
        <span v-if="!mobileMenuOpen">☰</span>
        <span v-else>✖</span>
      </button>
    </div>

    <!-- Menú Móvil -->
    <transition name="fade">
      <div v-if="mobileMenuOpen" class="sm:hidden px-6 pt-4 pb-6 bg-gray-900 text-white space-y-4">
        <router-link to="/" class="block hover:text-red-400 transition">Inicio</router-link>
        <router-link to="/products" class="block hover:text-red-400 transition">Productos</router-link>
        <router-link to="/about" class="block hover:text-red-400 transition">Sobre nosotros</router-link>
        <router-link to="/cart" class="block hover:text-red-400 transition">🛒 Carrito</router-link>

        <template v-if="isAuthenticated">
          <router-link :to="isAdmin ? '/admin' : '/user-panel'" class="block hover:text-red-400 transition">
            {{ isAdmin ? 'Admin' : 'Panel de Usuario' }}
          </router-link>
          <router-link to="/profile" class="block hover:text-red-400 transition">Editar perfil</router-link>
          <router-link to="/confirm-password" class="block hover:text-red-400 transition">Cambiar
            contraseña</router-link>
          <router-link to="/favorites" class="block hover:text-red-400 transition">Favoritos</router-link>
          <router-link to="/orders" class="block hover:text-red-400 transition">Mis pedidos</router-link>
          <button @click="logout" class="block w-full text-left text-red-400 hover:text-red-200 transition">Cerrar
            sesión</button>
        </template>

        <template v-else>
          <router-link to="/login" class="block hover:text-red-400 transition">Iniciar sesión</router-link>
          <router-link to="/register" class="block hover:text-red-400 transition">Registrarse</router-link>
        </template>
      </div>
    </transition>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useAuthStore } from '@/stores/authStore'
import { useCartStore } from '@/stores/cartStore'
import NotificationCenter from '@/components/admin/NotificationCenter.vue'
import { User, Key, Heart, LogOut, ChevronDown } from 'lucide-vue-next'

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const showMenu = ref(false)
const mobileMenuOpen = ref(false)
const dropdownRef = ref(null)

const user = computed(() => auth.user)
const isAuthenticated = computed(() => auth.isAuthenticated())
const isAdmin = computed(() => auth.isAdmin())
const cartCount = computed(() => cart.totalCount)

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
  cart.loadCart()
  document.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>