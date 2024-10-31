<template>
    <Transition appear name="modal">
      <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
          <Transition appear name="modal-backdrop">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="$emit('close')"></div>
          </Transition>
  
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
  
          <Transition appear name="modal-content">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
              <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="$emit('close')">
                  <span class="sr-only">Fechar</span>
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                      Reservar {{ room.name }}
                    </h3>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">
                        Preencha os detalhes abaixo para reservar esta sala de reunião.
                      </p>
                    </div>
                  </div>
                </div>
                <form @submit.prevent="submitReservation" class="mt-5 sm:mt-6">
                  <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                      <label for="date" class="block text-sm font-medium text-gray-700">Data</label>
                      <div class="mt-1">
                        <input type="date" id="date" v-model="reservation.date" required
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                      </div>
                    </div>
                    <div class="sm:col-span-3">
                      <label for="time" class="block text-sm font-medium text-gray-700">Horário</label>
                      <div class="mt-1">
                        <select id="time" v-model="reservation.time" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                          <option v-for="slot in room.availableSlots" :key="slot" :value="slot">
                            {{ slot }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="sm:col-span-6">
                      <label for="participants" class="block text-sm font-medium text-gray-700">Número de Participantes</label>
                      <div class="mt-1">
                        <input type="number" id="participants" v-model.number="reservation.participants" required min="1" :max="room.capacity"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                      </div>
                      <p class="mt-2 text-sm text-gray-500">Capacidade máxima: {{ room.capacity }} pessoas</p>
                    </div>
                  </div>
                  <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                      Confirmar Reserva
                    </button>
                    <button type="button" @click="$emit('close')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                      Cancelar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const props = defineProps({
    room: Object
  })
  
  const emit = defineEmits(['close', 'submit'])
  
  const reservation = ref({
    date: '',
    time: '',
    participants: 1
  })
  
  const submitReservation = () => {
    if (reservation.value.participants > props.room.capacity) {
      alert('O número de participantes excede a capacidade da sala.')
      return
    }
    emit('submit', { ...reservation.value, roomId: props.room.id })
  }
  </script>
  
  <style scoped>
  .modal-enter-active,
  .modal-leave-active {
    transition: opacity 0.3s ease;
  }
  
  .modal-enter-from,
  .modal-leave-to {
    opacity: 0;
  }
  
  .modal-backdrop-enter-active,
  .modal-backdrop-leave-active {
    transition: opacity 0.3s ease;
  }
  
  .modal-backdrop-enter-from,
  .modal-backdrop-leave-to {
    opacity: 0;
  }
  
  .modal-content-enter-active,
  .modal-content-leave-active {
    transition: all 0.3s ease;
  }
  
  .modal-content-enter-from,
  .modal-content-leave-to {
    opacity: 0;
    transform: scale(0.9);
  }
  </style>