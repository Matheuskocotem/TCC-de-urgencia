<template>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
      <div class="relative py-3 sm:max-w-xl sm:mx-auto w-full px-4 sm:px-0">
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
          <div class="max-w-md mx-auto">
            <div>
              <h1 class="text-2xl font-semibold mb-6">Editar Reserva de Sala</h1>
            </div>
            <form @submit.prevent="saveBooking" class="space-y-4">
              <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Título da Reunião</label>
                <input type="text" id="title" v-model="booking.title" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>
              <div>
                <label for="room" class="block text-sm font-medium text-gray-700">Sala</label>
                <select id="room" v-model="booking.room" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option value="Sala A">Sala A</option>
                  <option value="Sala B">Sala B</option>
                  <option value="Sala C">Sala C</option>
                </select>
              </div>
              <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Data</label>
                <input type="date" id="date" v-model="booking.date" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>
              <div class="flex space-x-4">
                <div class="flex-1">
                  <label for="startTime" class="block text-sm font-medium text-gray-700">Hora de Início</label>
                  <input type="time" id="startTime" v-model="booking.startTime" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
                <div class="flex-1">
                  <label for="endTime" class="block text-sm font-medium text-gray-700">Hora de Término</label>
                  <input type="time" id="endTime" v-model="booking.endTime" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Participantes</label>
                <div v-for="(participant, index) in booking.participants" :key="index" class="flex mb-2">
                  <input type="text" v-model="booking.participants[index]"
                    class="flex-grow border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                  <button @click="removeParticipant(index)" type="button"
                    class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                  >
                    Remover
                  </button>
                </div>
                <button @click="addParticipant" type="button"
                  class="mt-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Adicionar Participante
                </button>
              </div>
              <div class="flex items-center justify-end mt-6">
                <button type="submit"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Salvar Alterações
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Toast de notificação -->
      <div 
        v-if="showNotification" 
        class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg transition-opacity duration-500"
        :class="{ 'opacity-100': showNotification, 'opacity-0': !showNotification }"
      >
        Reserva atualizada com sucesso!
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, reactive } from 'vue'
  
  const booking = reactive({
    title: 'Reunião de Planejamento',
    room: 'Sala A',
    date: '2023-06-15',
    startTime: '09:00',
    endTime: '10:00',
    participants: ['João Silva', 'Maria Oliveira']
  })
  
  const showNotification = ref(false)
  
  const addParticipant = () => {
    booking.participants.push('')
  }
  
  const removeParticipant = (index) => {
    booking.participants.splice(index, 1)
  }
  
  const saveBooking = () => {
    // Simular uma chamada de API para salvar as alterações
    console.log('Salvando reserva:', booking)
    setTimeout(() => {
      showNotification.value = true
      setTimeout(() => {
        showNotification.value = false
      }, 3000)
    }, 1000)
  }
  </script>