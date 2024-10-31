<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="room in rooms" :key="room.id" class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ room.name }}</h3>
          <p class="text-sm text-gray-600">Capacidade: {{ room.capacity }} pessoas</p>
          <div class="mt-2">
            <span v-for="resource in room.resources" :key="resource" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
              {{ resource }}
            </span>
          </div>
          <div class="mt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-1">Horários Disponíveis:</h4>
            <div class="flex flex-wrap gap-2">
              <span v-for="slot in room.availableSlots" :key="slot" class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                {{ slot }}
              </span>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6">
          <button 
            @click="$emit('open-reservation', room)"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm"
          >
            Reservar
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    rooms: Array
  })
  
  defineEmits(['open-reservation'])
  </script>
  