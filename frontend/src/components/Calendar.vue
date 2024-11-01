<template>
  <div class="calendar">
    <!-- Calendar Header -->
    <div class="calendar-header">
      <h2 class="calendar-title">{{ currentMonth }}</h2>
      <div class="calendar-controls">
        <button @click="previousMonth" class="control-button">
          <ChevronLeftIcon class="icon" />
        </button>
        <button @click="goToToday" class="today-button">hoje</button>
        <button @click="nextMonth" class="control-button">
          <ChevronRightIcon class="icon" />
        </button>
      </div>
    </div>

    <!-- Calendar Grid -->
    <div class="calendar-grid">
      <div v-for="day in weekDays" :key="day" class="day-header">{{ day }}</div>

      <div 
        v-for="(day, index) in calendarDays" 
        :key="index"
        :class="[ 
          'calendar-day', 
          isToday(day) ? 'today' : '', 
          !isCurrentMonth(day) ? 'inactive' : '' 
        ]"
        @click="openModal(day)" 
      >
        <div class="day-content">
          <span :class="['day-number', isToday(day) ? 'highlight' : '']">
            {{ day.getDate() }}
          </span>
          <div class="event-indicators">
            <!-- Event slots would go here -->
          </div>
        </div>
      </div>
    </div>

    <ReservationModal
      :show="showModal"
      :date="selectedDate"
      :availableTimes="availableTimes"
      :rooms="rooms"
      @close="closeModal"
      @save="handleSave"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'
import ReservationModal from '../components/ReservationModal.vue'

const currentDate = ref(new Date())
const showModal = ref(false)
const selectedDate = ref(null)
const availableTimes = ref(['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00']) // Exemplos de horários disponíveis
const rooms = ref([{ id: 1, name: 'Sala A' }, { id: 2, name: 'Sala B' }]) // Exemplos de salas

const weekDays = ['dom.', 'seg.', 'ter.', 'qua.', 'qui.', 'sex.', 'sáb.']

const currentMonth = computed(() => {
  const options = { month: 'long', year: 'numeric' }
  return currentDate.value.toLocaleDateString('pt-BR', options)
})

const calendarDays = computed(() => {
  const year = currentDate.value.getFullYear()
  const month = currentDate.value.getMonth()
  
  // Get the first day of the month
  const firstDay = new Date(year, month, 1)
  const lastDay = new Date(year, month + 1, 0)
  const firstDayOfWeek = firstDay.getDay()
  const daysFromPrevMonth = firstDayOfWeek
  const totalDays = Math.ceil((daysFromPrevMonth + lastDay.getDate()) / 7) * 7
  
  const days = []
  
  // Add days from previous month
  for (let i = daysFromPrevMonth - 1; i >= 0; i--) {
    days.push(new Date(year, month, -i))
  }
  
  // Add days from current month
  for (let i = 1; i <= lastDay.getDate(); i++) {
    days.push(new Date(year, month, i))
  }
  
  // Add days from next month
  const remainingDays = totalDays - days.length
  for (let i = 1; i <= remainingDays; i++) {
    days.push(new Date(year, month + 1, i))
  }
  
  return days
})

const isToday = (date) => {
  const today = new Date()
  return date.getDate() === today.getDate() &&
         date.getMonth() === today.getMonth() &&
         date.getFullYear() === today.getFullYear()
}

const isCurrentMonth = (date) => {
  return date.getMonth() === currentDate.value.getMonth()
}

const openModal = (day) => {
  selectedDate.value = day.toISOString().split('T')[0] // Armazena a data selecionada
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

const previousMonth = () => {
  currentDate.value = new Date(
    currentDate.value.getFullYear(),
    currentDate.value.getMonth() - 1,
    1
  )
}

const nextMonth = () => {
  currentDate.value = new Date(
    currentDate.value.getFullYear(),
    currentDate.value.getMonth() + 1,
    1
  )
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

.control-button {
  padding: 0.5rem;
  border-radius: 9999px;
  transition: background-color 0.2s;
}

.control-button:hover {
  background-color: #e5e7eb;
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
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background-color: white;
}

.day-header {
  padding: 0.5rem 0;
  text-align: center;
  font-size: 0.875rem;
  font-weight: 500;
  color: #6b7280;
  border-bottom: 1px solid #e5e7eb;
}

.calendar-day {
  height: 8.5rem;
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  transition: background-color 0.2s;
}

.calendar-day:hover {
  background-color: #f9fafb;
}

.today {
  background-color: #feebc8;
}

.inactive {
  color: #9ca3af;
}

.day-content {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.day-number {
  font-size: 0.875rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 9999px;
}

.highlight {
  background-color: #4c51bf;
  color: white;
}

.event-indicators {
  flex-grow: 1;
  overflow-y: auto;
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
