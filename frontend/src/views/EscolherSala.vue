<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar fixa à esquerda -->
    <SideBar class="sidebar" />

    <!-- Conteúdo principal -->
    <div class="content">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Salas de Reunião</h1>

      <RoomList 
        :rooms="filteredRooms" 
        @open-reservation="openReservationModal"
      />

      <!-- Modal de Reserva -->
      <ReservationModal 
        v-if="showReservationModal"
        :room="selectedRoom"
        @close="closeReservationModal"
        @submit="submitReservation"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import RoomList from '../components/RoomList.vue';
import ReservationModal from '../components/ReservationModalSalas.vue';
import SideBar from '../components/Sidebar.vue';
import api from '../services/HttpService.js';

// Dados mockados
const rooms = ref([]);
const filteredRooms = computed(() => rooms.value);

const showReservationModal = ref(false);
const selectedRoom = ref(null);


const isAuthenticated = () => {
  const token = localStorage.getItem('token');
  return token !== null;
};

// Função para buscar as salas
const fetchRooms = async () => {
  if (!isAuthenticated()) {
    console.error('Usuário não autenticado');
    // Aqui você pode redirecionar para a página de login, se necessário
    return;
  }
  
  try {
    const response = await api.get('/api/meeting-rooms');
    rooms.value = response.data; 
  } catch (error) {
    console.error('Erro ao buscar salas:', error.response?.data || error.message);
  }
};

// Funções para abrir e fechar o modal de reserva
const openReservationModal = (room) => {
  selectedRoom.value = room;
  showReservationModal.value = true;
}

const closeReservationModal = () => {
  showReservationModal.value = false;
  selectedRoom.value = null;
}

// Função para submeter a reserva
const submitReservation = async (reservationData) => {
  try {
    const response = await api.post('/api/meetings', reservationData); 
    console.log('Reserva submetida:', response.data);
    closeReservationModal();
  } catch (error) {
    console.error('Erro ao submeter reserva:', error.response?.data || error.message);
  }
};

// Chama a função fetchRooms ao montar o componente
onMounted(fetchRooms);
</script>

<style scoped>
/* Estilos gerais */
.min-h-screen {
  background-color: #f7fafc; /* Fundo cinza claro */
  display: flex;
}

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

.content {
  margin-left: 250px; /* Margem para o conteúdo principal */
  flex: 1; /* Permite que o conteúdo principal ocupe o espaço restante */
  padding: 1rem; /* Espaçamento interno */
}

/* Estilos do RoomList */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Colunas responsivas */
  gap: 1rem; /* Espaçamento entre os cartões */
}

/* Cartões de salas */
.bg-white {
  background-color: #ffffff; /* Fundo branco dos cartões */
}

.rounded-lg {
  border-radius: 0.5rem; /* Bordas arredondadas */
}

.shadow {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra dos cartões */
}

/* Estilos dos botões */
button {
  background-color: #4c51bf; /* Cor do botão */
  color: #ffffff; /* Texto branco no botão */
}

button:hover {
  background-color: #434190; /* Cor do botão ao passar o mouse */
}
</style>
