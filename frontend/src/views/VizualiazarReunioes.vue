<template>
  <div class="visualizar-reunioes">
    <!-- Sidebar fixa à esquerda -->
    <SideBar class="sidebar" />

    <div class="content">
      <h1>Visualizar Reuniões</h1>
  
      <!-- Lista de reuniões -->
      <div v-if="reunioes.length > 0" class="reunioes-list">
        <div v-for="reuniao in reunioes" :key="reuniao.id" class="reuniao-card">
          <div class="reuniao-info">
            <h3>{{ reuniao.title }}</h3>
            <p><strong>Sala:</strong> {{ reuniao.room.nome }}</p>
            <p><strong>Data e Hora:</strong> {{ new Date(reuniao.start_time).toLocaleString() }}</p>
          </div>
        </div>
      </div>
  
      <!-- Caso não haja reuniões -->
      <div v-else>
        <p class="no-meetings">Não há reuniões agendadas.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import SideBar from '../components/Sidebar.vue';

export default {
  components: {
    SideBar,
  },
  data() {
    return {
      reunioes: [], // Inicializa o array vazio
    };
  },
  created() {
    this.fetchMeetings(); // Chama a função para buscar as reuniões quando o componente for criado
  },
  methods: {
    async fetchMeetings() {
      try {
        const response = await axios.get('http://localhost:8000/api/meetings');
        this.reunioes = response.data; // Atribui os dados da resposta à variável reunioes
      } catch (error) {
        console.error('Erro ao buscar reuniões:', error);
      }
    },
  },
};
</script>


<style scoped>
.visualizar-reunioes {
  display: flex; /* Alinha sidebar e conteúdo em linha */
  padding: 20px;
  background-color: #f9f9f9; /* Fundo claro */
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
  margin-left: 250px; /* Espaço para a sidebar */
  padding: 20px; /* Adiciona espaçamento ao conteúdo */
  flex: 1; /* Permite que o conteúdo ocupe o espaço restante */
  background-color: #f9f9f9; /* Fundo claro */
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
