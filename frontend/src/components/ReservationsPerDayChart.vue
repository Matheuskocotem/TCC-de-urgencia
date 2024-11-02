<template>
    <canvas ref="chartContainer"></canvas>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import Chart from 'chart.js/auto'
  
  const chartContainer = ref(null)
  
  onMounted(() => {
    const ctx = chartContainer.value.getContext('2d')
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        datasets: [{
          label: 'Reservas',
          data: [12, 19, 15, 17, 14, 8, 5],
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Número de Reservas'
            }
          }
        }
      }
    })
  })
  </script>