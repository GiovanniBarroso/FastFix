<template>
  <div class="flex flex-col min-h-screen bg-gray-50 text-gray-800">
    <Navbar />
    <main class="flex-1 pt-16">
      <router-view />
    </main>
    <Footer />
    <ToastContainer />
  </div>
</template>

<script>
import Navbar from '@/components/layout/Navbar.vue'
import Footer from '@/components/layout/Footer.vue'
import ToastContainer from '@/views/components/ToastContainer.vue'

export default {
  components: { Navbar, Footer, ToastContainer }
}
</script>
