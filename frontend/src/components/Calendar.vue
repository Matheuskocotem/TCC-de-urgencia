<template>
  <div class="calendar">
    <!-- Calendar Header -->
    <div class="calendar-header">
      <h2 class="calendar-title">{{ currentMonth }}</h2>
      <div class="calendar-controls">
        <button @click="previousMonth" class="control-button">
          <ChevronLeftIcon class="icon" />
        </button>
        <button @click="goToToday" class="today-button">
          hoje
        </button>
        <button @click="nextMonth" class="control-button">
          <ChevronRightIcon class="icon" />
        </button>
      </div>
    </div>

    <!-- Calendar Grid -->
    <div class="calendar-grid">
      <!-- Week days header -->
      <div v-for="day in weekDays" :key="day" class="day-header">
        {{ day }}
      </div>

      <!-- Calendar days -->
      <div 
        v-for="(day, index) in calendarDays" 
        :key="index"
        :class="[
          'calendar-day',
          isToday(day) ? 'today' : '',
          !isCurrentMonth(day) ? 'inactive' : ''
        ]"
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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'

const currentDate = ref(new Date())

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
  // Get the last day of the month
  const lastDay = new Date(year, month + 1, 0)
  
  // Get the day of the week for the first day (0-6)
  const firstDayOfWeek = firstDay.getDay()
  
  // Calculate how many days we need from the previous month
  const daysFromPrevMonth = firstDayOfWeek
  
  // Calculate total days needed (35 or 42 depending on the month)
  const totalDays = Math.ceil((daysFromPrevMonth + lastDay.getDate()) / 7) * 7
  
  // Generate array of dates
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
  height: 100%; /* Ou defina uma altura específica, como 80vh ou 600px */
  width: 100%;
}


.calendar-header {
  padding: 1rem;
  background-color: #f9fafb; /* gray-50 */
  border-bottom: 1px solid #e5e7eb; /* gray-300 */
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.calendar-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #4b5563; /* gray-800 */
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
  background-color: #e5e7eb; /* gray-200 */
}

.today-button {
  padding: 0.5rem 0.75rem;
  font-size: 0.875rem;
  background-color: #4a5568; /* gray-700 */
  color: white;
  border-radius: 0.375rem;
  transition: background-color 0.2s;
}

.today-button:hover {
  background-color: #4c51bf; /* blue-700 */
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
  color: #6b7280; /* gray-500 */
  border-bottom: 1px solid #e5e7eb; /* gray-300 */
}

.calendar-day {
  height: 8.5rem; /* Aumentar a altura dos dias */
  border: 1px solid #e5e7eb; /* gray-100 */
  padding: 0.5rem; /* Aumentar o padding para mais espaço interno */
  transition: background-color 0.2s;
}

.calendar-day:hover {
  background-color: #f9fafb; /* gray-50 */
}

.today {
  background-color: #feebc8; /* yellow-50 */
}

.inactive {
  color: #9ca3af; /* gray-400 */
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
  background-color: #4c51bf; /* blue-600 */
  color: white;
}

.event-indicators {
  flex-grow: 1;
  overflow-y: auto;
}

/* Hide scrollbar for Chrome, Safari and Opera */
::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
* {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>
