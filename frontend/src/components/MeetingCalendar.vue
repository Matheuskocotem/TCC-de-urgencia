<template>
    <div class="calendar">
      <!-- Calendar Header -->
      <div class="calendar-header">
        <h2 class="calendar-title">{{ currentDateFormatted }}</h2>
        <div class="calendar-controls">
          <button @click="goToToday" class="today-button">hoje</button>
        </div>
      </div>
  
      <!-- Calendar Grid -->
      <div class="calendar-grid">
        <div v-for="hour in hours" :key="hour" class="calendar-hour" @click="openModal(hour)">
          <div class="hour-content">
            <span class="hour-label">{{ hour }}</span>
            <div class="event-indicators">
              <!-- Event slots would go here -->
            </div>
          </div>
        </div>
      </div>
  
      <ReservationModal
        :show="showModal"
        :date="selectedHour"
        :availableTimes="availableTimes"
        :rooms="rooms"
        @close="closeModal"
        @save="handleSave"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue'
  import ReservationModal from '../components/ReservationModal.vue'
  
  const currentDate = ref(new Date())
  const showModal = ref(false)
  const selectedHour = ref(null)
  const availableTimes = ref(['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00']) // Exemplos de horários disponíveis
  const rooms = ref([{ id: 1, name: 'Sala A' }, { id: 2, name: 'Sala B' }]) // Exemplos de salas
  
  const currentDateFormatted = computed(() => {
    return currentDate.value.toLocaleDateString('pt-BR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
  })
  
  const hours = computed(() => {
    const hourArray = []
    for (let i = 8; i <= 17; i++) { // Horário das 08:00 às 17:00
      hourArray.push(`${i}:00`)
    }
    return hourArray
  })
  
  const openModal = (hour) => {
    selectedHour.value = hour // Armazena a hora selecionada
    showModal.value = true
  }
  
  const closeModal = () => {
    showModal.value = false
  }
  
  const handleSave = (data) => {
    // Aqui você pode adicionar a lógica para salvar a reunião
    console.log('Dados da reunião:', data)
    closeModal()
  }
  
  const goToToday = () => {
    currentDate.value = new Date()
  }
  </script>
  
  <style scoped>
  .calendar {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    height: 100%;
    width: 100%;
  }
  
  .calendar-header {
    padding: 1rem;
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .calendar-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #4b5563;
  }
  
  .calendar-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .today-button {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    background-color: #4a5568;
    color: white;
    border-radius: 0.375rem;
    transition: background-color 0.2s;
  }
  
  .today-button:hover {
    background-color: #4c51bf;
  }
  
  .calendar-grid {
    display: flex;
    flex-direction: column;
    background-color: white;
  }
  
  .calendar-hour {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
    transition: background-color 0.2s;
    cursor: pointer;
  }
  
  .calendar-hour:hover {
    background-color: #f9fafb;
  }
  
  .hour-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .hour-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #4b5563;
  }
  
  /* Modal styles */
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-content {
    background-color: white;
    padding: 1rem;
    border-radius: 0.5rem;
    width: 300px;
    position: relative;
  }
  
  .close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    cursor: pointer;
  }
  
  /* Hide scrollbar for Chrome, Safari and Opera */
  ::-webkit-scrollbar {
    display: none;
  }
  
  /* Hide scrollbar for IE and Edge */
  * {
    -ms-overflow-style: none; /* IE and Edge */
  }
  </style>
  