<!-- src/components/Layout/AppLayout.vue -->
<template>
    <div class="min-h-screen flex flex-col">
      <Navbar />
      <main class="flex-grow container mx-auto px-4 py-6">
        <slot />
      </main>
      <Footer />
    </div>
  </template>
  
  <script setup>
  import Navbar from './Navbar.vue'
  import Footer from './Footer.vue'
  </script>
  