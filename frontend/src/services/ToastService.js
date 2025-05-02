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
}
