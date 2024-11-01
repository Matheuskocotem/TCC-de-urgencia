<template>
    <div class="min-h-screen bg-gray-100 flex">
      <!-- Sidebar fixa à esquerda -->
      <SideBar class="fixed left-0 top-0 h-full w-1/4 md:w-1/6 bg-white shadow-md z-10" />
  
      <!-- Conteúdo principal -->
      <div class="ml-1/4 md:ml-1/6 flex-1 p-4 md:p-8">
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
  
  // Dados mockados
  const rooms = ref([
    { id: 1, name: 'Sala Executiva', capacity: 10, resources: ['Projetor', 'Quadro Branco'], availableSlots: ['09:00', '11:00', '14:00'] },
    { id: 2, name: 'Sala de Brainstorming', capacity: 6, resources: ['Quadro Branco'], availableSlots: ['10:00', '13:00', '15:00'] },
    { id: 3, name: 'Sala de Conferência', capacity: 20, resources: ['Projetor', 'Videoconferência'], availableSlots: ['09:00', '14:00', '16:00'] },
    { id: 4, name: 'Sala Pequena', capacity: 4, resources: ['TV'], availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] },
  ])
  
  const filteredRooms = computed(() => rooms.value) // Simplesmente retornando as salas para simplificar o exemplo
  
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
  }
  
  h1 {
    color: #4a5568; /* Texto do título em cinza escuro */
  }
  
  /* Estilos da Sidebar */
  .fixed {
    background-color: #ffffff; /* Fundo branco da Sidebar */
  }
  
  .shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
  }
  
  .p-4 {
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
  