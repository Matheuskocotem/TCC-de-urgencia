<script setup>
import { ref } from 'vue'
import Calendar from '../components/Calendar.vue'
import ReservationModal from '../components/ReservationModal.vue'

const events = ref([ 
  { title: 'Reunião A - Sala 1', start: '2023-04-10' }, 
  { title: 'Reunião B - Sala 2', start: '2023-04-15' } 
]);

const currentDate = ref(new Date().toISOString().slice(0, 10)); // Data atual
const showModal = ref(false);
const selectedDate = ref('');
const availableTimes = ref([]);
const selectedEventIndex = ref(null);

// Funções existentes aqui (handleDateClick, handleEventClick, etc.)

</script>

<template>
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
      @close="showModal = false"
      @save="saveReservation"
      @delete="deleteEvent"
    />
  </div>
</template>

<style scoped>

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
