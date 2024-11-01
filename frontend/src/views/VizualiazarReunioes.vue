<template>
    <div class="visualizar-reunioes">
      <h1>Visualizar Reuniões</h1>
  
      <!-- Lista de reuniões -->
      <div v-if="reunioes.length > 0" class="reunioes-list">
        <div v-for="reuniao in reunioes" :key="reuniao.id" class="reuniao-card">
          <div class="reuniao-info">
            <h3>{{ reuniao.title }}</h3>
            <p><strong>Sala:</strong> {{ reuniao.room.name }}</p>
            <p><strong>Data e Hora:</strong> {{ new Date(reuniao.time).toLocaleString() }}</p>
          </div>
        </div>
      </div>
  
      <!-- Caso não haja reuniões -->
      <div v-else>
        <p class="no-meetings">Não há reuniões agendadas.</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        reunioes: [
          { id: 1, title: "Reunião de Planejamento", room: { name: "Sala de Reuniões" }, time: "2024-10-20T10:00:00" },
          { id: 2, title: "Reunião de Equipe", room: { name: "Sala de Conferências" }, time: "2024-10-21T14:00:00" },
          { id: 3, title: "Reunião Executiva", room: { name: "Sala de Diretoria" }, time: "2024-10-22T09:00:00" },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  .visualizar-reunioes {
    padding: 20px;
    background-color: #f9f9f9; /* Fundo claro */
    border-radius: 8px; /* Bordas arredondadas */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
  }
  
  .reunioes-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .reuniao-card {
    background-color: #ffffff; /* Fundo branco */
    padding: 15px;
    border-radius: 8px; /* Bordas arredondadas */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
    transition: transform 0.2s; /* Transição suave para hover */
  }
  
  .reuniao-card:hover {
    transform: translateY(-3px); /* Levanta o cartão ao passar o mouse */
  }
  
  .reuniao-info h3 {
    margin: 0;
    font-size: 20px; /* Tamanho da fonte aumentado */
    font-weight: bold;
    color: #4c51bf; /* Cor do texto */
  }
  
  .reuniao-info p {
    margin: 5px 0;
    color: #666; /* Cor do texto mais suave */
  }
  
  .reuniao-info strong {
    color: #333; /* Cor escura para os rótulos */
  }
  
  .no-meetings {
    font-size: 18px; /* Tamanho da fonte */
    color: #777; /* Cor do texto suave */
    text-align: center; /* Centraliza a mensagem */
  }
  </style>
  