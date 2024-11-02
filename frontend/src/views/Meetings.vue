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

    <Modal :show="showAddMeetingModal" @close="showAddMeetingModal = false" title="Adicionar Nova Reunião">
      <template #default>
        <form @submit.prevent="addMeeting">
          <div class="form-group">
            <label for="meetingTitle">Título da Reunião:</label>
            <input type="text" id="meetingTitle" v-model="newMeeting.title" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingDate">Data:</label>
            <input type="date" id="meetingDate" v-model="newMeeting.date" required class="form-input">
          </div>
          <div class="form-group">
            <label for="meetingTime">Hora:</label>
            <input type="time" id="meetingTime" v-model="newMeeting.time" required class="form-input">
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <button type="button" class="btn btn-secondary" @click="showAddMeetingModal = false">Cancelar</button>
          </div>
        </form>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Modal from '../components/modal.vue';
import AdminSidebar from '../components/AdminSidebar.vue';

const upcomingMeetings = ref([
  { id: 1, room: 'Sala A', date: '2023-11-03', time: '09:00 - 10:00', organizer: 'João Silva' },
  { id: 2, room: 'Sala B', date: '2023-11-03', time: '11:00 - 12:00', organizer: 'Maria Santos' },
  { id: 3, room: 'Sala C', date: '2023-11-04', time: '14:00 - 15:00', organizer: 'Carlos Almeida' },
]);
const showAddMeetingModal = ref(false);
const newMeeting = ref({ title: '', date: '', time: '' });

const addMeeting = () => {
  const meeting = {
    id: upcomingMeetings.value.length + 1, // ID gerado com base na quantidade de reuniões
    room: 'Nova Sala', // Altere conforme necessário
    date: newMeeting.value.date,
    time: newMeeting.value.time,
    organizer: newMeeting.value.title, // Use o título como responsável ou ajuste conforme necessário
  };

  upcomingMeetings.value.push(meeting);
  newMeeting.value = { title: '', date: '', time: '' }; // Limpa o formulário
  showAddMeetingModal.value = false; // Fecha o modal após adicionar
};

const editMeeting = (meeting) => {
  // Aqui você pode implementar a lógica para editar a reunião
  console.log('Editando reunião:', meeting);
  // Adicione lógica para preencher os campos do modal com os dados da reunião a ser editada
};

const deleteMeeting = (id) => {
  upcomingMeetings.value = upcomingMeetings.value.filter(meeting => meeting.id !== id);
};
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


.meetings {
  padding: 20px;
  margin-left: 250px; /* Adiciona margem à esquerda igual à largura da sidebar */
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  height: 100vh; /* Garante que a altura do container seja 100% da viewport */
  overflow-y: auto; /* Permite rolagem se o conteúdo for maior que a tela */
}

.meetings-title {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 20px;
}

.btn {
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-right: 10px; /* Adiciona espaço entre os botões */
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

.modal-actions {
  margin-top: 1rem;
  display: flex;
  justify-content: space-between;
}

.form-group {
  margin-bottom: 1rem;
}

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
</style>
