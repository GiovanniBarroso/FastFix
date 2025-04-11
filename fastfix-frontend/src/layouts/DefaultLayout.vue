<template>
    <div class="layout">
      <header class="layout-header">
        <div class="user-info">
          <span>Hola, {{ user?.name }}</span>
          <LogoutButton />
        </div>
      </header>
  
      <main class="layout-content">
        <slot />
      </main>
    </div>
  </template>
  
  <script setup>
  import LogoutButton from '@/components/LogoutButton.vue'
  const user = JSON.parse(localStorage.getItem('user'))
  </script>
  
  <style scoped>
  .layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  
  .layout-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #4f46e5;
    color: white;
    padding: 1rem 2rem;
  }
  
  .user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: bold;
  }
  
  .layout-content {
    flex: 1;
    padding: 2rem;
  }
  </style>
  