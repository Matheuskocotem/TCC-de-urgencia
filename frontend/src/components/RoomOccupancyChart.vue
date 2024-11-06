<template>
  <canvas ref="chartContainer"></canvas>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'

const chartContainer = ref(null)
const labels = ref([])
const data = ref([])

async function fetchChartData() {
  try {
    const response = await axios.get('/meeting-rooms/occupancies'); 
    labels.value = response.data.labels; 
    data.value = response.data.data; 
  } catch (error) {
    console.error('Erro ao buscar dados do gráfico:', error);
  }
}

onMounted(async () => {
  await fetchChartData(); // Busca os dados ao montar o componente
  
  const ctx = chartContainer.value.getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels.value,
      datasets: [{
        label: 'Horas Ocupadas',
        data: data.value,
        backgroundColor: 'rgba(59, 130, 246, 0.8)',
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          max: 10,
          title: {
            display: true,
            text: 'Horas'
          }
        }
      }
    }
  });
});
</script>
