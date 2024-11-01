<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar fixa à esquerda -->
    <SideBar class="sidebar" />

    <!-- Conteúdo principal -->
    <div class="content">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Salas de Reunião</h1>

      <RoomList 
        :rooms="filteredRooms" 
        @open-reservation="openReservationModal"
      />

      <!-- Modal de Reserva -->
      <ReservationModal 
        v-if="showReservationModal"
        :room="selectedRoom"
        @close="closeReservationModal"
        @submit="submitReservation"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import RoomList from '../components/RoomList.vue'
import ReservationModal from '../components/ReservationModalSalas.vue'
import SideBar from '../components/Sidebar.vue'

// Dados mockados
const rooms = ref([
  { id: 1, name: 'Sala Executiva', capacity: 10, resources: ['Projetor', 'Quadro Branco'], availableSlots: ['09:00', '11:00', '14:00'] },
  { id: 2, name: 'Sala de Brainstorming', capacity: 6, resources: ['Quadro Branco'], availableSlots: ['10:00', '13:00', '15:00'] },
  { id: 3, name: 'Sala de Conferência', capacity: 20, resources: ['Projetor', 'Videoconferência'], availableSlots: ['09:00', '14:00', '16:00'] },
  { id: 4, name: 'Sala Pequena', capacity: 4, resources: ['TV'], availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] },
])

const filteredRooms = computed(() => rooms.value)

const showReservationModal = ref(false)
const selectedRoom = ref(null)

const openReservationModal = (room) => {
  selectedRoom.value = room
  showReservationModal.value = true
}

const closeReservationModal = () => {
  showReservationModal.value = false
  selectedRoom.value = null
}

const submitReservation = (reservationData) => {
  console.log('Reserva submetida:', reservationData)
  closeReservationModal()
}
</script>

<style scoped>
/* Estilos gerais */
.min-h-screen {
  background-color: #f7fafc; /* Fundo cinza claro */
  display: flex;
}

.sidebar {
  position: fixed; /* Fixa a barra lateral */
  left: 0;
  top: 0;
  height: 100vh; /* Altura total da tela */
  width: 250px; /* Largura da sidebar */
  background-color: #ffffff; /* Cor de fundo da sidebar */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
  z-index: 10; /* Coloca a sidebar acima do conteúdo */
}

.content {
  margin-left: 250px; /* Margem para o conteúdo principal */
  flex: 1; /* Permite que o conteúdo principal ocupe o espaço restante */
  padding: 1rem; /* Espaçamento interno */
}

/* Estilos do RoomList */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Colunas responsivas */
  gap: 1rem; /* Espaçamento entre os cartões */
}

/* Cartões de salas */
.bg-white {
  background-color: #ffffff; /* Fundo branco dos cartões */
}

.rounded-lg {
  border-radius: 0.5rem; /* Bordas arredondadas */
}

.shadow {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra dos cartões */
}

/* Estilos dos botões */
button {
  background-color: #4c51bf; /* Cor do botão */
  color: #ffffff; /* Texto branco no botão */
}

button:hover {
  background-color: #434190; /* Cor do botão ao passar o mouse */
}
</style>
