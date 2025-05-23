<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-100 to-blue-100 flex items-center justify-center px-4 py-12">
        <transition name="fade">
            <div
                class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8 space-y-6 border border-gray-200 animate-fade-in">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-800">Cambiar contraseña</h2>
                    <p class="mt-1 text-sm text-gray-500">Introduce tus credenciales para actualizar tu seguridad.</p>
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-5">
                    <PasswordInput v-model="currentPassword" label="Contraseña actual" :show="showCurrent"
                        @toggle="showCurrent = !showCurrent" />
                    <PasswordInput v-model="newPassword" label="Nueva contraseña" :show="showNew"
                        @toggle="showNew = !showNew" />
                    <PasswordInput v-model="confirmPassword" label="Confirmar nueva contraseña" :show="showConfirm"
                        @toggle="showConfirm = !showConfirm" />

                    <p v-if="errorMessage" class="text-sm text-red-600 text-center font-medium animate-pulse">
                        {{ errorMessage }}
                    </p>

                    <p v-if="successMessage"
                        class="text-sm text-green-600 text-center font-medium animate-fade-in-down">
                        {{ successMessage }}
                    </p>


                    <button type="submit"
                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 active:scale-95 transition transform text-white font-semibold rounded-xl shadow-lg">
                        Guardar nueva contraseña
                    </button>
                </form>
            </div>
        </transition>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import PasswordInput from '@/views/components/PasswordInput.vue'

const router = useRouter()

const currentPassword = ref('')
const newPassword = ref('')
const confirmPassword = ref('')
const errorMessage = ref('')
const successMessage = ref('')

const showCurrent = ref(false)
const showNew = ref(false)
const showConfirm = ref(false)

onMounted(() => {
    if (localStorage.getItem('passwordConfirmed') !== 'true') {
        router.push('/confirm-password')
        return
    }

    localStorage.removeItem('passwordConfirmed')
})

const handleSubmit = async () => {
    errorMessage.value = ''
    successMessage.value = ''

    if (newPassword.value.length < 8) {
        errorMessage.value = 'La nueva contraseña debe tener al menos 8 caracteres.'
        return
    }

    if (newPassword.value !== confirmPassword.value) {
        errorMessage.value = 'Las nuevas contraseñas no coinciden.'
        return
    }

    try {
        await api.post('/user/confirm-password', { password: currentPassword.value })

        await api.put('/profile', {
            password: newPassword.value,
            password_confirmation: confirmPassword.value
        })

        successMessage.value = '¡Contraseña cambiada correctamente!'
        currentPassword.value = ''
        newPassword.value = ''
        confirmPassword.value = ''
    } catch (error) {
        errorMessage.value = error.response?.data?.message || 'Error al cambiar la contraseña.'
    }
}

</script>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.3s ease-out;
}
</style>
