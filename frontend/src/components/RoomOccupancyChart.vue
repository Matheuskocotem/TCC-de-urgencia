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
      type: 'bar',
      data: {
        labels: ['Sala A', 'Sala B', 'Sala C', 'Sala D', 'Sala E'],
        datasets: [{
          label: 'Horas Ocupadas',
          data: [8, 6, 5, 7, 4],
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
    })
  })
  </script>