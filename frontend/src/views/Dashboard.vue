<template>
  <div class="dashboard">
    <AdminSidebar />

    <div class="main-content">
      <h1 class="py-5">Dashboard de Agendamento</h1>

      <div class="summary-cards">
        <div v-for="(card, index) in summaryCards" :key="index" class="card">
          <div class="card-content">
            <i :class="card.icon" class="card-icon pr-5"></i>
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

      <!-- Novo componente de calendário -->
      <div class="calendar-container">
        <h2>Calendário de Reuniões</h2>
        <MeetingCalendar />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import RoomOccupancyChart from "../components/RoomOccupancyChart.vue";
import ReservationsPerDayChart from "../components/ReservationsPerDayChart.vue";
import AdminSidebar from "../components/AdminSidebar.vue";
import MeetingCalendar from "../components/MeetingCalendar.vue";

const summaryCards = ref([
  { title: "Total de Reservas", value: "Carregando...", icon: "fas fa-calendar" },
  { title: "Salas Disponíveis", value: "Carregando...", icon: "fas fa-th" },
  { title: "Usuários", value: "Carregando...", icon: "fas fa-users" }, // Ajustado para "Usuários"
]);

async function fetchSummaryData() {
  try {
    const response = await axios.get("/users/summary-data");

    const data = response.data;

    summaryCards.value = [
      { title: "Total de Reservas", value: data.totalReservas, icon: "fas fa-calendar" },
      { title: "Salas Disponíveis", value: data.salasDisponiveis, icon: "fas fa-th" },
      { title: "Usuários", value: data.totalUsuarios, icon: "fas fa-users" }, // Substituído para usar totalUsuarios
    ];
  } catch (error) {
    console.error("Erro ao buscar dados do resumo:", error);
  }
}

onMounted(fetchSummaryData);
</script>




<style scoped>
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

.main-content {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
}

.header {
  background-color: #fff;
  padding: 1rem;
  margin-bottom: 2rem;
  border-radius: 8px;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dashboard {
  padding: 20px;
  margin-left: 250px;
  background: #f8f9fa;
  font-family: Inter;
}

.summary-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin-bottom: 40px;
}

.card {
  background-color: #fff;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
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
  margin-top: 20px;
}

.chart-card {
  background-color: #fff;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.chart {
  height: 300px;
}

.calendar-container {
  margin-top: 40px; /* Espaçamento para separar do conteúdo acima */
}

i{
  color:#2B73B4;
  font-size: 30px;
}
.card-value{
  font-size: 30px;
  font-weight: 600;
}
</style>
