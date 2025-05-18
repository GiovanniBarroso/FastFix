import { ref } from 'vue'

const toasts = ref([])

const showToast = (message, type = 'success', duration = 3000) => {
  const id = Date.now()
  toasts.value.push({ id, message, type })

  setTimeout(() => {
    toasts.value = toasts.value.filter((toast) => toast.id !== id)
  }, duration)
}

export default {
  toasts,
  showToast,
  success(message, duration = 3000) {
    showToast(message, 'success', duration)
  },
  error(message, duration = 3000) {
    showToast(message, 'error', duration)
  },
  info(message, duration = 3000) {
    showToast(message, 'info', duration)
  },
}
