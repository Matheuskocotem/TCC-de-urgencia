<script setup>
import { ref } from 'vue'
import Calendar from '../components/Calendar.vue'
import ReservationModal from '../components/ReservationModal.vue'

const events = ref([
  { title: 'Reunião A - Sala 1', start: '2023-04-10' },
  { title: 'Reunião B - Sala 2', start: '2023-04-15' }
])

const showModal = ref(false)
const selectedDate = ref('')
const availableTimes = ref([])

const selectedEventIndex = ref(null)

const handleDateClick = (info) => {
  console.log('Data clicada:', info.dateStr)
  selectedDate.value = info.dateStr
  // Aqui você deve buscar os horários disponíveis para a data selecionada
  availableTimes.value = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00']
  showModal.value = true
  console.log('showModal:', showModal.value)
}

const handleEventClick = (info) => {
  const event = info.event
  selectedEventIndex.value = events.value.findIndex(e => e.start === event.start.toISOString().slice(0, 10))
  selectedDate.value = event.start.toISOString().slice(0, 10)
  availableTimes.value = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00']
  
  showModal.value = true
}

const saveReservation = (reservation) => {
  if (selectedEventIndex.value === null) {
    // Novo evento
    events.value.push({
      title: `${reservation.name} - Sala X`,
      start: `${reservation.date}T${reservation.startTime}`,
      end: `${reservation.date}T${reservation.endTime}`
    })
  } else {
    // Editando evento existente
    const event = events.value[selectedEventIndex.value]
    event.title = `${reservation.name} - Sala X`
    event.start = `${reservation.date}T${reservation.startTime}`
    event.end = `${reservation.date}T${reservation.endTime}`
  }
  
  showModal.value = false
  selectedEventIndex.value = null // Resetar o índice selecionado
}

const deleteEvent = () => {
  if (selectedEventIndex.value !== null) {
    events.value.splice(selectedEventIndex.value, 1)
    showModal.value = false
    selectedEventIndex.value = null
  }
}
</script>

<template>
  <div class="dashboard">
    <div class="calendar-container">
      <Calendar 
        :events="events"
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
  height: 100%; /* Definir a altura para 100% da altura do contêiner pai */
  margin-top: 1rem;
  background-color: #ffffff; /* Fundo do calendário */
  border-radius: 12px; /* Bordas arredondadas */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
  padding: 1rem;
  width: 100%;
}

/* Estilização do calendário */
.fc {
  font-family: 'Comic Sans MS', cursive; /* Fonte amigável */
}

.fc-day {
  background-color: #f0f8ff; /* Cor de fundo suave */
  border-radius: 8px; /* Bordas arredondadas para os dias */
  transition: background-color 0.3s, transform 0.3s; /* Transição suave */
}

.fc-day:hover {
  background-color: #e0f7fa; /* Cor de fundo ao passar o mouse */
  transform: scale(1.05); /* Efeito de aumentar ao passar o mouse */
}

/* Estilo para eventos */
.fc-event {
  background-color: #ffcccb; /* Cor suave para eventos */
  border: none; /* Sem borda */
  border-radius: 5px; /* Bordas arredondadas para eventos */
  padding: 0.5rem; /* Espaçamento interno */
  transition: background-color 0.3s, transform 0.3s; /* Transição suave */
}

.fc-event:hover {
  background-color: #ff9999; /* Cor de fundo ao passar o mouse */
  transform: scale(1.05); /* Efeito de aumentar ao passar o mouse */
}





.modal-overlay {
  background-color: rgba(0, 0, 0, 0.5); /* Fundo escuro para o modal */
}

.modal-content {
  background-color: #fff; /* Fundo do modal */
  border-radius: 10px; /* Bordas arredondadas */
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Sombra do modal */
  padding: 2rem;
}

.modal-header h3 {
  color: #333; /* Cor do título do modal */
}

.close-button {
  background: transparent;
  border: none;
  color: #888; /* Cor do botão de fechar */
  font-size: 1.5rem;
  cursor: pointer;
}

.submit-button {
  background-color: #4caf50; /* Cor do botão de confirmação */
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #45a049; /* Efeito hover para o botão */
}

.cancel-button {
  background-color: #f44336; /* Cor do botão de cancelar */
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.cancel-button:hover {
  background-color: #d32f2f; /* Efeito hover para o botão */
}

label {
  font-weight: bold; /* Estilo dos rótulos */
}

input, select {
  width: 100%;
  padding: 10px;
  margin-top: 0.5rem;
  border: 1px solid #ccc; /* Borda suave */
  border-radius: 5px; /* Bordas arredondadas */
  transition: border-color 0.3s;
}

input:focus, select:focus {
  border-color: #4caf50; /* Mudança de cor ao focar */
}
</style>
