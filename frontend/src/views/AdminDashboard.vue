<template>
  <div class="admin-dashboard">
    <Sidebar :active-page="activePage" @change-page="changePage" />
    
    <div class="main-content">
      <header class="header">
        <div class="header-content">
          <h1>{{ pageTitle }}</h1>
          <button v-if="activePage === 'meetings'" class="btn btn-primary" @click="showAddReservationModal = true">
            <PlusIcon class="icon" />
            Nova Reserva
          </button>
        </div>
      </header>

      <main>
        <template v-if="activePage === 'dashboard'">
          <div class="summary-cards">
            <div v-for="(card, index) in summaryCards" :key="index" class="card">
              <div class="card-content">
                <component :is="card.icon" class="card-icon" />
                <div>
                  <p class="card-title">{{ card.title }}</p>
                  <p class="card-value">{{ card.value }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="charts-container">
            <div class="chart-card">
              <h2>Ocupação das Salas</h2>
              <div class="chart">
                <RoomOccupancyChart />
              </div>
            </div>

            <div class="chart-card">
              <h2>Reservas por Dia</h2>
              <div class="chart">
                <ReservationsPerDayChart />
              </div>
            </div>
          </div>
        </template>

        <template v-else-if="activePage === 'rooms'">
          <h2>Gerenciar Salas</h2>
          <button class="btn btn-primary" @click="showAddRoomModal = true">
            Adicionar Nova Sala
          </button>
          <table class="rooms-table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Capacidade</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="room in rooms" :key="room.id">
                <td>{{ room.name }}</td>
                <td>{{ room.capacity }}</td>
                <td>
                  <button class="btn btn-edit" @click="editRoom(room)">Editar</button>
                  <button class="btn btn-delete" @click="deleteRoom(room.id)">Excluir</button>
                </td>
              </tr>
            </tbody>
          </table>
        </template>

        <template v-else-if="activePage === 'meetings'">
          <h2>Próximas Reuniões</h2>
          <table class="meetings-table">
            <thead>
              <tr>
                <th>Sala</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Responsável</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="meeting in upcomingMeetings" :key="meeting.id">
                <td>{{ meeting.room }}</td>
                <td>{{ meeting.date }}</td>
                <td>{{ meeting.time }}</td>
                <td>{{ meeting.organizer }}</td>
                <td>
                  <button class="btn btn-edit" @click="editMeeting(meeting)">Editar</button>
                  <button class="btn btn-delete" @click="deleteMeeting(meeting.id)">Cancelar</button>
                </td>
              </tr>
            </tbody>
          </table>
        </template>

        <template v-else-if="activePage === 'users'">
          <h2>Gerenciar Usuários</h2>
          <p>Conteúdo da página de usuários...</p>
        </template>
      </main>
    </div>

    <Modal :show="showAddRoomModal" @close="showAddRoomModal = false" title="Adicionar Nova Sala">
      <template #default>
        <form @submit.prevent="addRoom">
          <div class="form-group">
            <label for="roomName">Nome da Sala:</label>
            <input type="text" id="roomName" v-model="newRoom.name" required>
          </div>
          <div class="form-group">
            <label for="roomCapacity">Capacidade:</label>
            <input type="number" id="roomCapacity" v-model="newRoom.capacity" required min="1">
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <button type="button" class="btn btn-secondary" @click="showAddRoomModal = false">Cancelar</button>
          </div>
        </form>
      </template>
    </Modal>

    <Modal :show="showAddReservationModal" @close="showAddReservationModal = false" title="Adicionar Nova Reserva">
      <template #default>
        <form @submit.prevent="addReservation">
          <div class="form-group">
            <label for="reservationRoom">Sala:</label>
            <select id="reservationRoom" v-model="newReservation.room" required>
              <option v-for="room in rooms" :key="room.id" :value="room.name">{{ room.name }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="reservationDate">Data:</label>
            <input type="date" id="reservationDate" v-model="newReservation.date" required>
          </div>
          <div class="form-group">
            <label for="reservationTime">Horário:</label>
            <input type="time" id="reservationTime" v-model="newReservation.time" required>
          </div>
          <div class="form-group">
            <label for="reservationOrganizer">Responsável:</label>
            <input type="text" id="reservationOrganizer" v-model="newReservation.organizer" required>
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <button type="button" class="btn btn-secondary" @click="showAddReservationModal = false">Cancelar</button>
          </div>
        </form>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { CalendarIcon, UsersIcon, LayoutIcon, PlusIcon } from 'lucide-vue-next'
import Sidebar from '../components/AdminSidebar.vue'
import RoomOccupancyChart from '../components/RoomOccupancyChart.vue'
import ReservationsPerDayChart from '../components/ReservationsPerDayChart.vue'
import Modal from '../components/modal.vue'

const activePage = ref('dashboard')
const showAddRoomModal = ref(false)
const showAddReservationModal = ref(false)

const pageTitle = computed(() => {
  switch (activePage.value) {
    case 'dashboard': return 'Dashboard de Agendamento'
    case 'rooms': return 'Gerenciar Salas'
    case 'meetings': return 'Próximas Reuniões'
    case 'users': return 'Gerenciar Usuários'
    default: return 'Dashboard de Agendamento'
  }
})

const summaryCards = ref([
  { title: 'Total de Reservas', value: '156', icon: CalendarIcon },
  { title: 'Salas Disponíveis', value: '8', icon: LayoutIcon },
  { title: 'Usuários Ativos', value: '42', icon: UsersIcon },
])

const rooms = ref([
  { id: 1, name: 'Sala A', capacity: 10 },
  { id: 2, name: 'Sala B', capacity: 8 },
  { id: 3, name: 'Sala C', capacity: 15 },
])

const upcomingMeetings = ref([
  { id: 1, room: 'Sala A', date: '2023-11-03', time: '09:00 - 10:00', organizer: 'João Silva' },
  { id: 2, room: 'Sala B', date: '2023-11-03', time: '11:00 - 12:00', organizer: 'Maria Santos' },
  { id: 3, room: 'Sala C', date: '2023-11-04', time: '14:00 - 15:00', organizer: 'Carlos Almeida' },
])

const newRoom = ref({ name: '', capacity: 1 })
const newReservation = ref({ room: '', date: '', time: '', organizer: '' })

const changePage = (page) => {
  activePage.value = page
}

const addRoom = () => {
  rooms.value.push({
    id: rooms.value.length + 1,
    ...newRoom.value
  })
  showAddRoomModal.value = false
  newRoom.value = { name: '', capacity: 1 }
  updateSummaryCards()
}

const editRoom = (room) => {
  // Implement room editing logic
  console.log('Editing room:', room)
}

const deleteRoom = (roomId) => {
  rooms.value = rooms.value.filter(room => room.id !== roomId)
  updateSummaryCards()
}

const addReservation = () => {
  upcomingMeetings.value.push({
    id: upcomingMeetings.value.length + 1,
    ...newReservation.value
  })
  showAddReservationModal.value = false
  newReservation.value = { room: '', date: '', time: '', organizer: '' }
  updateSummaryCards()
}

const editMeeting = (meeting) => {
  // Implement meeting editing logic
  console.log('Editing meeting:', meeting)
}

const deleteMeeting = (meetingId) => {
  upcomingMeetings.value = upcomingMeetings.value.filter(meeting => meeting.id !== meetingId)
  updateSummaryCards()
}

const updateSummaryCards = () => {
  summaryCards.value = [
    { title: 'Total de Reservas', value: upcomingMeetings.value.length.toString(), icon: CalendarIcon },
    { title: 'Salas Disponíveis', value: rooms.value.length.toString(), icon: LayoutIcon },
    { title: 'Usuários Ativos', value: '42', icon: UsersIcon }, // This would typically be updated from a backend
  ]
}
</script>

<style scoped>
.sidebar {
  position: fixed; /* Fixa a barra lateral */
  left: 0;
  top: 0;
  height: 100vh; /* Altura total da tela */
  width: 250px; /* Largura da sidebar */
  background-color: #ffffff; /* Cor de fundo da sidebar */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
  z-index: 10; /* Coloca a sidebar acima do conteúdo */
}

.admin-dashboard {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
}

.header {
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1rem;
  margin-bottom: 2rem;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.summary-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin-bottom: 2rem;
}

.card {
  background-color: #fff;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-content {
  display: flex;
  align-items: center;
}

.card-icon {
  width: 2rem;
  height: 2rem;
  margin-right: 1rem;
}

.charts-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-bottom: 2rem;
}

.chart-card {
  background-color: #fff;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.chart {
  height: 300px;
}

.rooms-table,
.meetings-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.rooms-table th,
.rooms-table td,
.meetings-table th,
.meetings-table td {
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  text-align: left;
}

.rooms-table th,
.meetings-table th {
  background-color: #f3f4f6;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 4px;
  font-size: 0.875rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-primary {
  background-color: #3b82f6;
  color: #fff;
  border: none;
}

.btn-primary:hover {
  background-color: #2563eb;
}

.btn-secondary {
  background-color: #9ca3af;
  color: #fff;
  border: none;
}

.btn-secondary:hover {
  background-color: #6b7280;
}

.btn-edit {
  background-color: #10b981;
  color: #fff;
  border: none;
  margin-right: 0.5rem;
}

.btn-edit:hover {
  background-color: #059669;
}

.btn-delete {
  background-color: #ef4444;
  color: #fff;
  border: none;
}

.btn-delete:hover {
  background-color: #dc2626;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #e5e7eb;
  border-radius: 4px;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}

@media (max-width: 768px) {
  .admin-dashboard {
    flex-direction: column;
  }

  .charts-container {
    grid-template-columns: 1fr;
  }
}
</style>