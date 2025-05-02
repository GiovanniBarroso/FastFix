<template>
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-2">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        :class="[
          'px-4 py-2 rounded-md shadow-md text-white animate-fade-in-down',
          toast.type === 'success' && 'bg-green-600',
          toast.type === 'error' && 'bg-red-600',
          toast.type === 'info' && 'bg-blue-600',
        ]"
      >
        {{ toast.message }}
      </div>
    </div>
  </template>
  
  <script setup>
  import ToastService from '@/services/ToastService.js'
  
  const toasts = ToastService.toasts
  </script>
  
  <style scoped>
  @keyframes fade-in-down {
    from {
      opacity: 0;
      transform: translateY(-10px);
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
  