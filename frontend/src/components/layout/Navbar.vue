<template>
    <nav class="bg-background shadow fixed w-full z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <router-link to="/" class="text-2xl font-bold text-foreground">
                FastFix
            </router-link>

            <!-- Botón mobile -->
            <button @click="toggleMobileMenu" class="sm:hidden text-foreground text-2xl">
                <span v-if="!mobileMenuOpen">☰</span>
                <span v-else>✖</span>
            </button>

            <!-- Menú Desktop -->
            <div class="hidden sm:flex items-center gap-6">
                <router-link to="/"
                    class="text-foreground hover:text-[var(--color-red-500)] transition">Inicio</router-link>
                <router-link to="/product-list"
                    class="text-foreground hover:text-[var(--color-red-500)] transition">Productos</router-link>
                <router-link to="/about" class="text-foreground hover:text-[var(--color-red-500)] transition">Sobre
                    nosotros</router-link>

                <template v-if="isAuthenticated">
                    <router-link v-if="isAdmin" to="/admin"
                        class="text-foreground hover:text-[var(--color-red-500)] transition">Admin</router-link>

                    <!-- Dropdown usuario -->
                    <div class="relative" ref="dropdownRef">
                        <button @click="toggleMenu"
                            class="flex items-center space-x-1 text-foreground hover:text-[var(--color-red-500)] transition">
                            <span>{{ user.name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <transition name="fade">
                            <div v-if="showMenu"
                                class="absolute right-0 mt-2 w-40 bg-background border border-border rounded shadow-lg z-50">
                                <button @click="logout"
                                    class="w-full text-left px-4 py-2 text-foreground hover:bg-[var(--color-red-100)] transition">
                                    Cerrar sesión
                                </button>
                            </div>
                        </transition>
                    </div>
                </template>

                <template v-else>
                    <router-link to="/login"
                        class="text-foreground hover:text-[var(--color-red-500)] transition">Iniciar
                        sesión</router-link>
                    <router-link to="/register"
                        class="text-foreground hover:text-[var(--color-red-500)] transition">Registrarse</router-link>
                </template>
            </div>
        </div>

        <!-- Menú Mobile -->
        <div v-if="mobileMenuOpen" class="sm:hidden px-6 pt-4 pb-6 bg-background space-y-4">
            <router-link to="/"
                class="block text-foreground hover:text-[var(--color-red-500)] transition">Inicio</router-link>
            <router-link to="/product-list"
                class="block text-foreground hover:text-[var(--color-red-500)] transition">Productos</router-link>
            <router-link to="/about" class="block text-foreground hover:text-[var(--color-red-500)] transition">Sobre
                nosotros</router-link>

            <template v-if="isAuthenticated">
                <router-link to="/dashboard"
                    class="block text-foreground hover:text-[var(--color-red-500)] transition">Dashboard</router-link>
                <router-link v-if="isAdmin" to="/admin"
                    class="block text-foreground hover:text-[var(--color-red-500)] transition">Admin</router-link>

                <button @click="logout"
                    class="block text-left w-full text-[var(--color-red-600)] hover:text-[var(--color-red-400)] transition">
                    Cerrar sesión
                </button>
            </template>

            <template v-else>
                <router-link to="/login"
                    class="block text-foreground hover:text-[var(--color-red-500)] transition">Iniciar
                    sesión</router-link>
                <router-link to="/register"
                    class="block text-foreground hover:text-[var(--color-red-500)] transition">Registrarse</router-link>
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

const isAdmin = computed(() => {
    return localStorage.getItem('is_admin') === 'true'
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
</style>