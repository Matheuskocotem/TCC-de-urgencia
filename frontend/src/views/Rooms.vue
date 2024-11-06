<template>
  <div class="rooms">
    <AdminSidebar />
    <div class="d-flex justify-content-between">
      <h2>Gerenciar Salas</h2>
      <button class="btn btn-primary" @click="showAddRoomModal = true">
        Adicionar Nova Sala
      </button>
    </div>
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
          <td>{{ room.nome }}</td>
          <td>{{ room.capacidade }}</td>
          <td>
            <button class="btn btn-edit" @click="openEditModal(room)">Editar</button>
            <button class="btn btn-delete" @click="deleteRoom(room.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal de Adição de Sala -->
    <div v-if="showAddRoomModal" class="modal-overlay">
      <div class="modal-content">
        <h3>Adicionar Nova Sala</h3>
        <form @submit.prevent="addRoom">
          <div class="form-group">
            <label for="roomName">Nome da Sala:</label>
            <input type="text" id="roomName" v-model="newRoom.nome" required>
          </div>
          <div class="form-group">
            <label for="roomLocation">Localização:</label>
            <input type="text" id="roomLocation" v-model="newRoom.localizacao" required>
          </div>
          <div class="form-group">
            <label for="roomCapacity">Capacidade:</label>
            <input type="number" id="roomCapacity" v-model="newRoom.capacidade" required min="1">
          </div>
          <div class="form-group">
            <label for="roomResources">Recursos:</label>
            <input type="text" id="roomResources" v-model="newRoom.recursos">
          </div>
          <div class="form-group">
            <label for="roomAvailability">Disponibilidade:</label>
            <input type="text" id="roomAvailability" v-model="newRoom.disponibilidade">
          </div>
          <div class="form-group">
            <label for="roomImage">Imagem:</label>
            <input type="text" id="roomImage" v-model="newRoom.imagem">
          </div>
          <div class="form-group">
            <label for="roomDescription">Descrição:</label>
            <textarea id="roomDescription" v-model="newRoom.descricao"></textarea>
          </div>
          <div class="form-group">
            <label for="roomActive">Ativo:</label>
            <input type="checkbox" id="roomActive" v-model="newRoom.ativo">
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <button type="button" class="btn btn-secondary" @click="showAddRoomModal = false">Cancelar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal de Edição de Sala -->
    <div v-if="showEditRoomModal" class="modal-overlay">
      <div class="modal-content">
        <h3>Editar Sala</h3>
        <form @submit.prevent="updateRoom">
          <div class="form-group">
            <label for="editRoomName">Nome da Sala:</label>
            <input type="text" id="editRoomName" v-model="selectedRoom.nome" required>
          </div>
          <div class="form-group">
            <label for="editRoomLocation">Localização:</label>
            <input type="text" id="editRoomLocation" v-model="selectedRoom.localizacao" required>
          </div>
          <div class="form-group">
            <label for="editRoomCapacity">Capacidade:</label>
            <input type="number" id="editRoomCapacity" v-model="selectedRoom.capacidade" required min="1">
          </div>
          <div class="form-group">
            <label for="editRoomResources">Recursos:</label>
            <input type="text" id="editRoomResources" v-model="selectedRoom.recursos">
          </div>
          <div class="form-group">
            <label for="editRoomAvailability">Disponibilidade:</label>
            <input type="text" id="editRoomAvailability" v-model="selectedRoom.disponibilidade">
          </div>
          <div class="form-group">
            <label for="editRoomImage">Imagem:</label>
            <input type="text" id="editRoomImage" v-model="selectedRoom.imagem">
          </div>
          <div class="form-group">
            <label for="editRoomDescription">Descrição:</label>
            <textarea id="editRoomDescription" v-model="selectedRoom.descricao"></textarea>
          </div>
          <div class="form-group">
            <label for="editRoomActive">Ativo:</label>
            <input type="checkbox" id="editRoomActive" v-model="selectedRoom.ativo">
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <button type="button" class="btn btn-secondary" @click="showEditRoomModal = false">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AdminSidebar from '../components/AdminSidebar.vue';
import axios from 'axios';

const rooms = ref([]);
const showAddRoomModal = ref(false);
const showEditRoomModal = ref(false);
const newRoom = ref({ nome: '', capacidade: null, localizacao: '', recursos: '', ativo: false, disponibilidade: '', imagem: '', descricao: '' });
const selectedRoom = ref(null);

const addRoom = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/meeting-rooms', { ...newRoom.value });
    rooms.value.push(response.data);
    showAddRoomModal.value = false;
    resetRoomData(newRoom);
  } catch (error) {
    console.error("Erro ao adicionar sala:", error);
  }
};

const openEditModal = (room) => {
  selectedRoom.value = { ...room };
  showEditRoomModal.value = true;
};

const updateRoom = async () => {
  try {
    await axios.put(`http://localhost:8000/api/meeting-rooms/${selectedRoom.value.id}`, { ...selectedRoom.value });
    const index = rooms.value.findIndex((r) => r.id === selectedRoom.value.id);
    if (index !== -1) rooms.value[index] = { ...selectedRoom.value };
    showEditRoomModal.value = false;
  } catch (error) {
    console.error("Erro ao atualizar sala:", error);
  }
};

const deleteRoom = async (id) => {
  try {
    await axios.delete(`http://localhost:8000/api/meeting-rooms/${id}`);
    rooms.value = rooms.value.filter((room) => room.id !== id);
  } catch (error) {
    console.error("Erro ao excluir sala:", error);
  }
};

const resetRoomData = (room) => {
  room.value = { nome: '', capacidade: null, localizacao: '', recursos: '', ativo: false, disponibilidade: '', imagem: '', descricao: '' };
};

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/meeting-rooms');
    rooms.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar salas:", error);
  }
});
</script>



<style scoped>
/* Estilo da Sidebar */
.sidebar {
  position: fixed; 
  left: 0;
  top: 0;
  height: 100vh;
  width: 250px;
  background-color: #ffffff; 
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); 
  z-index: 10;
}

/* Layout principal */
.rooms {
  font-family: Inter;
  margin-left: 250px;
  padding: 1rem; 
}

/* Estilo da tabela de salas */
.rooms-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.rooms-table th,
.rooms-table td {
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  text-align: left;
}

.rooms-table th {
  background-color: #f3f4f6;
}

/* Estilos dos botões */
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

/* Estilo do modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 20;
}

.modal-content {
  background: #ffffff;
  padding: 1.5rem;
  width: 100%;
  max-width: 500px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 1rem;
}
</style>
