<template>
    <nav class="bg-white dark:bg-gray-800 shadow fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <router-link to="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                FastFix
            </router-link>

            <!-- Mobile menu toggle -->
            <button @click="toggleMobileMenu" class="sm:hidden text-gray-800 dark:text-white">
                <span v-if="!mobileMenuOpen">☰</span>
                <span v-else>✖</span>
            </button>

            <!-- Desktop links -->
            <div class="hidden sm:flex items-center space-x-4">
                <router-link to="/" class="nav-link">Inicio</router-link>
                <router-link to="/product-list" class="nav-link">Productos</router-link>
                <router-link to="/about" class="nav-link">Sobre nosotros</router-link>

                <template v-if="isAuthenticated">
                    <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
                    <router-link v-if="user?.roles_id === 1" to="/admin" class="nav-link">Admin</router-link>

                    <!-- User dropdown -->
                    <div class="relative" ref="dropdownRef">
                        <button @click="toggleMenu"
                            class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                            :aria-expanded="showMenu" aria-haspopup="true">
                            <span>{{ user.name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <transition name="fade">
                            <div v-if="showMenu"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border dark:border-gray-600 rounded shadow z-50"
                                role="menu">
                                <button @click="logout"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-white">
                                    Cerrar sesión
                                </button>
                            </div>
                        </transition>
                    </div>
                </template>

                <template v-else>
                    <router-link to="/login" class="nav-link">Iniciar sesión</router-link>
                    <router-link to="/register" class="nav-link">Registrarse</router-link>
                </template>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-if="mobileMenuOpen" class="sm:hidden px-4 pb-4">
            <router-link to="/" class="nav-link block">Inicio</router-link>
            <router-link to="/product-list" class="nav-link block">Productos</router-link>
            <router-link to="/about" class="nav-link block">Sobre nosotros</router-link>

            <template v-if="isAuthenticated">
                <router-link to="/dashboard" class="nav-link block">Dashboard</router-link>
                <router-link v-if="user?.roles_id === 1" to="/admin" class="nav-link block">Admin</router-link>
                <button @click="logout" class="nav-link block text-left text-red-500">Cerrar sesión</button>
            </template>

            <template v-else>
                <router-link to="/login" class="nav-link block">Iniciar sesión</router-link>
                <router-link to="/register" class="nav-link block">Registrarse</router-link>
            </template>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const showMenu = ref(false)
const mobileMenuOpen = ref(false)
const dropdownRef = ref(null)

const user = computed(() => {
    const data = localStorage.getItem('user')
    return data ? JSON.parse(data) : {}
})

const isAuthenticated = computed(() => !!localStorage.getItem('token'))

const toggleMenu = () => {
    showMenu.value = !showMenu.value
}

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value
}

// Cerrar menú dropdown al hacer click fuera
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

const logout = async () => {
    try {
        await api.post('/logout')
    } catch (e) {
        console.warn('Error al cerrar sesión')
    } finally {
        localStorage.clear()
        router.push('/login')
    }
}
</script>

<style scoped>
.nav-link {
    @apply text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-medium px-3 py-2 transition duration-200;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>