<template>
  <Transition name="fade">
    <div
      v-if="modelValue"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-6 relative animate-scaleIn"
      >
        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">¿Vaciar carrito?</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
          Esta acción eliminará todos los productos de tu carrito. ¿Estás seguro?
        </p>

        <div class="flex justify-end gap-3">
          <button
            @click="$emit('update:modelValue', false)"
            class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition"
          >
            Cancelar
          </button>
          <button
            @click="confirmar"
            class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition shadow"
          >
            Sí, vaciar
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
defineProps({
  modelValue: Boolean,
})
const emit = defineEmits(['confirm', 'update:modelValue'])

const confirmar = () => {
  emit('confirm')
  emit('update:modelValue', false)
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
@keyframes scaleIn {
  0% {
    transform: scale(0.95);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
.animate-scaleIn {
  animation: scaleIn 0.3s ease-out;
}
</style>
