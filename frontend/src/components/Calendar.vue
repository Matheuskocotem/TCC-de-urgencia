<script setup>
import { ref, onMounted, watch } from 'vue'
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const props = defineProps({
  events: {
    type: Array,
    default: () => []
  },
  height: {
    type: String,
    default: '100%'
  }
})

const emit = defineEmits(['dateClick', 'eventClick'])

const calendarEl = ref(null)
let calendar = null

onMounted(() => {
  createCalendar()
})

watch(() => props.height, () => {
  if (calendar) {
    calendar.destroy()
    createCalendar()
  }
})

function createCalendar() {
  calendar = new Calendar(calendarEl.value, {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    locale: 'Br',
    events: props.events,
    height: props.height,
    dateClick: (info) => {
      emit('dateClick', info)
    },
    eventClick: (info) => {
      emit('eventClick', info)
    }
  })

  calendar.render()
}
</script>

<template>
  <div ref="calendarEl" :style="{ height: height}"></div>
</template>

<style scoped>
/* Add any additional styles here if needed */
</style>