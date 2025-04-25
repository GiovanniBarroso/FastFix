<template>
  <div>
    <Navbar />
    <main class="min-h-screen pt-16">
      <router-view />
    </main>
    <Footer />
  </div>
</template>

<script>
import Navbar from '@/components/layout/Navbar.vue'
import Footer from '@/components/layout/Footer.vue'

export default {
  components: { Navbar, Footer }
}
</script>
