<template>
  <div
    class="min-h-screen bg-gradient-to-tr from-sky-100 to-indigo-200 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center px-4 py-12"
    data-aos="fade-in"
    data-aos-duration="800"
  >
    <transition name="fade">
      <div
        class="w-full max-w-lg bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 space-y-6 animate-fade-in"
        data-aos="zoom-in"
        data-aos-delay="200"
        data-aos-duration="1000"
      >
        <!-- Header -->
        <div class="text-center" data-aos="fade-up" data-aos-delay="300">
          <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
            🔐 Cambiar contraseña
          </h2>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            Introduce tus credenciales para actualizar tu seguridad.
          </p>
        </div>

        <!-- Formulario -->
        <form
          @submit.prevent="handleSubmit"
          class="space-y-5"
          data-aos="fade-up"
          data-aos-delay="400"
        >
          <PasswordInput
            v-model="currentPassword"
            label="Contraseña actual"
            :show="showCurrent"
            @toggle="showCurrent = !showCurrent"
          />
          <PasswordInput
            v-model="newPassword"
            label="Nueva contraseña"
            :show="showNew"
            @toggle="showNew = !showNew"
          />
          <PasswordInput
            v-model="confirmPassword"
            label="Confirmar nueva contraseña"
            :show="showConfirm"
            @toggle="showConfirm = !showConfirm"
          />

          <!-- Mensajes -->
          <p
            v-if="errorMessage"
            class="text-sm text-red-600 text-center font-medium animate-pulse"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            {{ errorMessage }}
          </p>
          <p
            v-if="successMessage"
            class="text-sm text-green-600 text-center font-medium animate-fade-in-down"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            {{ successMessage }}
          </p>

          <!-- Botón -->
          <button
            type="submit"
            class="w-full py-3 px-4 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 transition text-white font-bold rounded-xl shadow-md active:scale-[.97] focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800"
            data-aos="fade-up"
            data-aos-delay="500"
          >
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
      password_confirmation: confirmPassword.value,
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
    transform: translateY(-6px);
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
