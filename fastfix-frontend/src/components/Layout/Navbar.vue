<!-- src/components/Layout/Navbar.vue -->
<template>
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <router-link to="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                FastFix
            </router-link>

            <!-- Si usuario autenticado -->
            <div v-if="isAuthenticated" class="relative" @click="toggleMenu">
                <button
                    class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <span>{{ user.name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Menu dropdown -->
                <transition name="fade">
                    <div v-if="showMenu"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border dark:border-gray-600 rounded shadow z-50">
                        <button @click="logout"
                            class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-white">
                            Cerrar sesión
                        </button>
                    </div>
                </transition>
            </div>

            <!-- Si invitado -->
            <div v-else class="space-x-4">
                <router-link to="/login" class="text-gray-800 dark:text-white hover:underline">Iniciar
                    sesión</router-link>
                <router-link to="/register"
                    class="text-gray-800 dark:text-white hover:underline">Registrarse</router-link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const showMenu = ref(false)

const toggleMenu = () => {
    showMenu.value = !showMenu.value
}

const user = computed(() => {
    const data = localStorage.getItem('user')
    return data ? JSON.parse(data) : {}
})

const isAuthenticated = computed(() => !!localStorage.getItem('token'))

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
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>