<template>
  <Transition name="fade">
    <div
      v-if="show"
      class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center px-4"
    >
      <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl p-8 relative animate-fade-in"
        data-aos="zoom-in"
      >
        <!-- Título -->
        <div class="flex items-center gap-3 mb-6">
          <div class="text-3xl">📨</div>
          <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
            Contactar con
            <span class="text-blue-500">{{ cliente?.user?.nombre || 'Cliente' }}</span>
          </h2>
        </div>

        <!-- Info contacto -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
          <div class="flex items-start gap-3">
            <span class="text-blue-500 text-xl mt-1">📧</span>
            <div>
              <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Email</p>
              <p class="text-gray-800 dark:text-white font-mono text-sm">
                {{ cliente?.user?.email }}
              </p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-red-500 text-xl mt-1">📞</span>
            <div>
              <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Teléfono</p>
              <p class="text-gray-800 dark:text-white font-mono text-sm">
                {{ cliente?.user?.telefono }}
              </p>
            </div>
          </div>
        </div>

        <!-- Formulario -->
        <form @submit.prevent="enviarMensaje" class="space-y-6">
          <!-- Presupuesto -->
          <div>
            <div class="flex items-center gap-3 mb-1">
              <span class="text-yellow-500 text-xl">💰</span>
              <label class="form-label mb-0">Presupuesto estimado (€)</label>
            </div>
            <input
              v-model="presupuesto"
              type="number"
              step="0.01"
              min="0"
              placeholder="Ej: 120.00"
              class="form-input"
            />
            <p v-if="errorPresupuesto" class="text-sm text-red-600 mt-1">{{ errorPresupuesto }}</p>
          </div>

          <!-- Mensaje -->
          <div>
            <div class="flex items-center gap-3 mb-1">
              <span class="text-gray-500 text-xl">💬</span>
              <label class="form-label mb-0">Mensaje</label>
            </div>
            <textarea
              v-model="mensaje"
              rows="5"
              placeholder="Escribe tu respuesta aquí..."
              required
              class="form-input resize-none border-l-4 border-blue-400 dark:border-blue-600"
            ></textarea>
          </div>

          <!-- Botones -->
          <div class="flex justify-end gap-4 pt-2">
            <button type="button" @click="$emit('close')" class="btn-secondary">Cancelar</button>
            <button type="submit" :disabled="enviando || !!errorPresupuesto" class="btn-primary">
              {{ enviando ? 'Enviando...' : 'Enviar' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useToast } from 'vue-toastification'
import api from '@/services/api'

const props = defineProps({
  show: Boolean,
  cliente: Object,
})

const emit = defineEmits(['close', 'respondido'])

const toast = useToast()

const mensaje = ref('')
const presupuesto = ref('')
const errorPresupuesto = ref('')
const enviando = ref(false)
const MAX_PRESUPUESTO = 99999999.99

watch(
  () => props.show,
  (visible) => {
    if (visible) {
      mensaje.value = ''
      presupuesto.value = ''
      errorPresupuesto.value = ''
    }
  },
)

watch(presupuesto, (valor) => {
  if (valor && parseFloat(valor) > MAX_PRESUPUESTO) {
    errorPresupuesto.value = `Pon un presupuesto más pequeño (máx €${MAX_PRESUPUESTO})`
  } else {
    errorPresupuesto.value = ''
  }
})

const enviarMensaje = async () => {
  const id = props.cliente?.id
  const nombre = props.cliente?.user?.nombre
  const email = props.cliente?.user?.email

  if (!id || !mensaje.value || errorPresupuesto.value) return

  try {
    enviando.value = true

    await api.post(`/budgets/${id}/reply`, { mensaje: mensaje.value })
    await api.put(`/budgets/${id}`, {
      estado: 'respondido',
      presupuesto_estimado: presupuesto.value || null,
    })

    toast.success(`✉️ Mensaje enviado a ${nombre} (${email})`, {
      timeout: 3500,
      position: 'bottom-right',
      icon: '✅',
      hideProgressBar: false,
    })

    emit('respondido', id)
    emit('close')
  } catch (error) {
    toast.error('❌ Hubo un error al enviar el mensaje.', {
      timeout: 4000,
      position: 'bottom-right',
    })
    console.error('Error al enviar mensaje:', error)
  } finally {
    enviando.value = false
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}
@keyframes fadeIn {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.form-label {
  @apply block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1;
}
.form-input {
  @apply w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm;
}
.btn-primary {
  @apply bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed;
}
.btn-secondary {
  @apply bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold shadow-md transition-all;
}
</style>
