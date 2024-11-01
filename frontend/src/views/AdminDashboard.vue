<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="bg-gray-900 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
      <h2 class="text-2xl font-semibold text-center mb-5">Admin Dashboard</h2>
      <nav>
        <a @click="currentView = 'rooms'" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white" :class="{ 'bg-gray-700': currentView === 'rooms' }">
          Rooms
        </a>
        <a @click="currentView = 'users'" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white" :class="{ 'bg-gray-700': currentView === 'users' }">
          Users
        </a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 overflow-y-auto">
      <h1 class="text-3xl font-semibold mb-6">{{ currentView === 'rooms' ? 'Meeting Rooms' : 'Users' }}</h1>

      <!-- Rooms View -->
      <div v-if="currentView === 'rooms'">
        <!-- Create Room Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
          <h2 class="text-xl font-semibold mb-4">Create New Room</h2>
          <form @submit.prevent="createRoom" class="space-y-4">
            <div>
              <label for="roomName" class="block text-sm font-medium text-gray-700">Room Name</label>
              <input v-model="newRoom.name" type="text" id="roomName" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
              <label for="roomCapacity" class="block text-sm font-medium text-gray-700">Capacity</label>
              <input v-model="newRoom.capacity" type="number" id="roomCapacity" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              Create Room
            </button>
          </form>
        </div>

        <!-- Room List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="room in rooms" :key="room.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ room.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ room.capacity }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Users View -->
      <div v-else-if="currentView === 'users'">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="user in users" :key="user.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

// Current view state
const currentView = ref('rooms')

// Rooms data
const rooms = ref([
  { id: 1, name: 'Conference Room A', capacity: 20 },
  { id: 2, name: 'Meeting Room B', capacity: 10 },
  { id: 3, name: 'Board Room', capacity: 15 },
])

// New room form data
const newRoom = reactive({
  name: '',
  capacity: null
})

// Users data
const users = ref([
  { id: 1, name: 'John Doe', email: 'john@example.com' },
  { id: 2, name: 'Jane Smith', email: 'jane@example.com' },
  { id: 3, name: 'Bob Johnson', email: 'bob@example.com' },
])

// Function to create a new room
const createRoom = () => {
  const room = {
    id: rooms.value.length + 1,
    name: newRoom.name,
    capacity: parseInt(newRoom.capacity)
  }
  rooms.value.push(room)
  newRoom.name = ''
  newRoom.capacity = null
}
</script>