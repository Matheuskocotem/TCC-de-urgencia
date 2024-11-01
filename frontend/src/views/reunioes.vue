<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar fixa à esquerda -->
    <div class="sidebar">
      <SideBar />
    </div>

    <!-- Conteúdo principal -->
    <div class="main-content">
      <div class="dashboard">
        <div class="calendar-container">
          <Calendar 
            :events="events"
            :date="currentDate" 
            height="800px"
            @dateClick="handleDateClick"  
            @eventClick="handleEventClick" 
          />
        </div>
        <ReservationModal
          :show="showModal"
          :date="selectedDate"
          :availableTimes="availableTimes"
          @close="closeModal" 
          @save="saveReservation" 
          @delete="deleteEvent"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import SideBar from '../components/Sidebar.vue' // Importando o componente SideBar
import Calendar from '../components/Calendar.vue'
import ReservationModal from '../components/ReservationModal.vue'

// Aqui você pode definir seus dados e métodos
const events = ref([]) // Defina seus eventos aqui
const currentDate = ref(new Date()) // Data atual
const showModal = ref(false) // Controle do modal
const selectedDate = ref(null) // Data selecionada para reserva
const availableTimes = ref([]) // Horários disponíveis

// Métodos de manipulação
const handleDateClick = (date) => {
  selectedDate.value = date
  showModal.value = true
}

const handleEventClick = (event) => {
  // Lógica para lidar com cliques em eventos
}

const closeModal = () => {
  showModal.value = false
}

const saveReservation = (reservationData) => {
  // Lógica para salvar a reserva
}

const deleteEvent = (eventId) => {
  // Lógica para deletar evento
}
</script>

<style scoped>
.min-h-screen {
  display: flex; /* Flex container para o layout */
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

.main-content {
  margin-left: 15%;
  padding: 1rem; 
  flex: 1; 
}

.calendar-container {
  height: 100%; /* Manter a altura para 100% da altura do contêiner pai */
  margin-top: 1rem;
  background-color: #ffffff; /* Fundo do calendário */
  border-radius: 12px; /* Bordas arredondadas */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
  padding: 1rem;
  width: 100%;
}
</style>
