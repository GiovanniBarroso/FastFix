<template>
  <section class="py-12 bg-[#F8F9FA] dark:bg-[#1E2A38] min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1
          class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#007BFF] to-[#5E6C77] animate-glow"
        >
          📍 Tus direcciones
        </h1>
        <button
          @click="openCreateModal"
          class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-6 py-3 rounded-xl shadow-xl transition-all duration-300 hover:scale-105"
        >
          <span class="text-xl">➕</span> Añadir dirección
        </button>
      </div>

      <!-- Lista de direcciones -->
      <div
        v-if="addresses.length"
        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 animate-fade-up"
      >
        <div
          v-for="address in addresses"
          :key="address.id"
          class="bg-white dark:bg-[#2C3E50] rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-md hover:shadow-xl transform transition-all hover:-translate-y-1 relative"
        >
          <div class="flex items-center gap-4 mb-4">
            <div class="text-4xl">🏠</div>
            <div>
              <h2 class="text-xl font-semibold text-[#1E2A38] dark:text-white">
                {{ address.nombre }}
              </h2>
              <span
                class="text-xs inline-block mt-1 px-2 py-0.5 rounded-full font-medium"
                :class="address.principal
                  ? 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-200'
                  : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-300'"
              >
                {{ address.principal ? 'Principal' : 'Secundaria' }}
              </span>
            </div>
          </div>

          <ul class="text-sm text-[#1E2A38] dark:text-[#F8F9FA] space-y-1 pl-1">
            <li>📍 <span class="font-medium">{{ address.direccion }}</span></li>
            <li>📫 {{ address.codigo_postal }} – {{ address.ciudad }}</li>
            <li>🌍 {{ address.provincia }}, {{ address.pais }}</li>
            <li v-if="address.telefono_envio">📞 {{ address.telefono_envio }}</li>
          </ul>

          <button
            @click="openEditModal(address)"
            class="absolute top-4 right-4 text-lg text-gray-400 hover:text-blue-600 transition-transform hover:scale-110"
            title="Editar dirección"
          >
            ✏️
          </button>
        </div>
      </div>

      <!-- Sin direcciones -->
      <div
        v-else
        class="text-center text-gray-500 dark:text-gray-400 mt-16 text-lg animate-fade-in"
      >
        <p class="font-semibold mb-2">Aún no tienes direcciones registradas.</p>
        <router-link
          to="/products"
          class="inline-block mt-2 px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition"
        >
          Ir a la tienda
        </router-link>
      </div>

      <!-- Modal -->
      <NewAddressModal
        :visible="showModal"
        :editing="isEditing"
        :initial-data="addressToEdit"
        @close="showModal = false"
        @refresh="fetchAddresses"
      />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import NewAddressModal from '@/components/modals/NewAddressModal.vue'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const addresses = ref([])
const showModal = ref(false)
const isEditing = ref(false)
const addressToEdit = ref(null)

const fetchAddresses = async () => {
  try {
    const { data } = await api.get('/addresses')
    addresses.value = data
  } catch (err) {
    console.error('❌ Error al cargar direcciones:', err)
    addresses.value = []
  }
}

const openCreateModal = () => {
  isEditing.value = false
  addressToEdit.value = null
  showModal.value = true
}

const openEditModal = (address) => {
  isEditing.value = true
  addressToEdit.value = { ...address }
  showModal.value = true
}

onMounted(fetchAddresses)
</script>

<style scoped>
@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fadeUp 0.8s ease-out both;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fadeIn 0.8s ease-out both;
}

@keyframes glow {
  0% {
    text-shadow:
      0 0 5px rgba(0, 123, 255, 0.4),
      0 0 10px rgba(0, 123, 255, 0.3);
  }
  100% {
    text-shadow:
      0 0 12px rgba(255, 191, 0, 0.5),
      0 0 20px rgba(255, 191, 0, 0.4);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}
</style>
