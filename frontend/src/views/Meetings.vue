<template>
  <div class="meetings">
    <AdminSidebar />

    <h2>Próximas Reuniões</h2>
    <button class="btn btn-primary" @click="showAddMeetingModal = true">
      Adicionar Nova Reunião
    </button>
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

    <!-- Modal diretamente na tela -->
    <div v-if="showAddMeetingModal" class="modal-overlay" @click.self="showAddMeetingModal = false">
      <div class="modal-content">
        <h2>Adicionar Nova Reunião</h2>
        <form @submit.prevent="addMeeting">
          <div class="form-group">
            <label for="meetingRoom">Sala:</label>
            <input type="number" id="meetingRoom" v-model="newMeeting.room_id" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingUser">Responsável (ID do usuário):</label>
            <input type="number" id="meetingUser" v-model="newMeeting.user_id" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingTitle">Título da Reunião:</label>
            <input type="text" id="meetingTitle" v-model="newMeeting.title" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingDescription">Descrição:</label>
            <textarea id="meetingDescription" v-model="newMeeting.description" class="form-input"></textarea>
          </div>
          <div class="form-group">
            <label for="meetingDate">Data:</label>
            <input type="date" id="meetingDate" v-model="newMeeting.date" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingStartTime">Horário de Início:</label>
            <input type="time" id="meetingStartTime" v-model="newMeeting.start_time" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingEndTime">Horário de Término:</label>
            <input type="time" id="meetingEndTime" v-model="newMeeting.end_time" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingStatus">Status:</label>
            <select id="meetingStatus" v-model="newMeeting.status" required class="form-input">
              <option value="0">Pendente</option>
              <option value="1">Confirmada</option>
              <option value="2">Cancelada</option>
            </select>
          </div>

          <div class="modal-actions">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <button type="button" class="btn btn-secondary" @click="showAddMeetingModal = false">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AdminSidebar from '../components/AdminSidebar.vue';

const upcomingMeetings = ref([]);
const showAddMeetingModal = ref(false);
const newMeeting = ref({
  room_id: '',
  user_id: '',
  title: '',
  description: '',
  date: '',
  start_time: '',
  end_time: '',
  status: '0',
});

const apiUrl = 'http://localhost:8000/api/meetings/';

const fetchMeetings = async () => {
  try {
    const response = await axios.get(apiUrl);
    // Mapeia as reuniões para incluir um formato legível para o horário
    upcomingMeetings.value = response.data.map(meeting => ({
      ...meeting,
      date: meeting.date, // Exibe a data
      time: `${meeting.start_time} - ${meeting.end_time}`, // Combina start_time e end_time em uma string para exibição
      organizer: meeting.user_id, // Assume que o user_id representa o organizador (ajuste conforme necessário)
      room: meeting.room_id
    }));
  } catch (error) {
    console.error('Erro ao buscar reuniões:', error);
  }
};


const addMeeting = async () => {
  try {
    const meeting = {
      room_id: newMeeting.value.room_id,
      user_id: newMeeting.value.user_id,
      title: newMeeting.value.title,
      description: newMeeting.value.description,
      date: newMeeting.value.date,
      start_time: newMeeting.value.start_time,
      end_time: newMeeting.value.end_time,
      status: newMeeting.value.status,
    };

    const response = await axios.post(apiUrl, meeting);
    // Adiciona a nova reunião à lista de reuniões, com o formato correto
    upcomingMeetings.value.push({
      ...response.data,
      date: response.data.date,
      time: `${response.data.start_time} - ${response.data.end_time}`,
      organizer: response.data.user_id,
      room: response.data.room_id
    });
    
    // Resetando o formulário
    newMeeting.value = {
      room_id: '',
      user_id: '',
      title: '',
      description: '',
      date: '',
      start_time: '',
      end_time: '',
      status: '0',
    };
    showAddMeetingModal.value = false;
  } catch (error) {
    console.error('Erro ao adicionar reunião:', error);
  }
};



onMounted(fetchMeetings);
</script>


<style scoped>
/* Sidebar */
.sidebar {
  position: fixed;
  /* Fixa a barra lateral */
  left: 0;
  top: 0;
  height: 100vh;
  /* Altura total da tela */
  width: 250px;
  /* Largura da sidebar */
  background-color: #ffffff;
  /* Cor de fundo da sidebar */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  /* Sombra suave */
  z-index: 10;
  /* Coloca a sidebar acima do conteúdo */
}

/* Main Content */
.meetings {
  padding: 20px;
  margin-left: 250px;
  /* Adiciona margem à esquerda igual à largura da sidebar */
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  height: 100vh;
  /* Garante que a altura do container seja 100% da viewport */
  overflow-y: auto;
  /* Permite rolagem se o conteúdo for maior que a tela */
}

.meetings-title {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 20px;
}

/* Button Styles */
.btn {
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-right: 10px;
  /* Adiciona espaço entre os botões */
}

.btn-primary {
  background-color: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background-color: #2563eb;
}

.btn-edit {
  background-color: #10b981;
  color: #fff;
}

.btn-edit:hover {
  background-color: #059669;
}

.btn-delete {
  background-color: #ef4444;
  color: #fff;
}

.btn-delete:hover {
  background-color: #dc2626;
}

/* Table Styles */
.meetings-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.meetings-table th,
.meetings-table td {
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  text-align: left;
}

.meetings-table th {
  background-color: #f3f4f6;
  color: #333;
}

/* Modal Overlay */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  /* Fundo escuro translúcido */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  /* Coloca o modal acima de outros elementos */
}

/* Modal Content */
.modal-content {
  background: white;
  padding: 20px;
  width: 90%;
  max-width: 500px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  /* Sombra */
  position: relative;
  animation: fadeIn 0.3s ease;
  /* Animação de aparecimento */
}

/* Modal Actions */
.modal-actions {
  margin-top: 1rem;
  display: flex;
  justify-content: space-between;
}

/* Form Group */
.form-group {
  margin-bottom: 1rem;
}

/* Input Style */
.form-input {
  width: 100%;
  padding: 8px;
  border: 1px solid #e5e7eb;
  border-radius: 4px;
}

.form-input:focus {
  border-color: #3b82f6;
  outline: none;
  box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
}

/* Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.9);
  }

  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
