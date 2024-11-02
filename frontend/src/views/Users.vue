<template>
  <div class="manage-users">
    <AdminSidebar />
    <header class="header">
      <h1>Gerenciar Usuários</h1>
      <button class="btn btn-add" @click="showModal = true">Adicionar Usuário</button>
    </header>

    <main>
      <div class="users-list">
        <h2>Usuários Registrados</h2>
        <table class="users-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>
                <button class="btn btn-edit" @click="editUser(user)">Editar</button>
                <button class="btn btn-delete" @click="deleteUser(user.id)">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Modal de Adicionar Usuário -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="showModal = false">&times;</span>
        <h2>Adicionar Usuário</h2>
        <form @submit.prevent="addUser">
          <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" v-model="newUser.name" required />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" v-model="newUser.email" required />
          </div>
          <div class="form-group">
            <label for="role">Função:</label>
            <select v-model="newUser.role" required>
              <option value="" disabled selected>Selecione uma função</option>
              <option value="admin">Administrador</option>
              <option value="user">Usuário</option>
              <option value="moderator">Moderador</option>
            </select>
          </div>
          <button type="submit" class="btn btn-add">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import AdminSidebar from '../components/AdminSidebar.vue'

export default {
  components: {
    AdminSidebar
  },
  data() {
    return {
      showModal: false,
      newUser: { name: '', email: '', role: '' },
      users: [
        { id: 1, name: 'Alice', email: 'alice@example.com', role: 'admin' },
        { id: 2, name: 'Bob', email: 'bob@example.com', role: 'moderator' },
        // Adicione mais usuários conforme necessário
      ],
    };
  },
  methods: {
    editUser(user) {
      // Lógica para editar o usuário
      console.log('Editando usuário:', user);
    },
    deleteUser(userId) {
      // Lógica para excluir o usuário
      console.log('Excluindo usuário com ID:', userId);
    },
    addUser() {
      const newId = this.users.length + 1; // Simulando ID único
      this.users.push({ id: newId, ...this.newUser });
      this.newUser = { name: '', email: '', role: '' }; // Limpa o formulário
      this.showModal = false; // Fecha o modal
      console.log('Usuário adicionado:', this.newUser);
    }
  },
};
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
.manage-users {
  padding: 1.5rem;
  margin-left: 250px; /* Ajusta para acomodar a sidebar */
}

.header h1 {
  font-size: 1.75rem;
  margin-bottom: 1.5rem;
}

.header .btn-add {
  background-color: #3b82f6; /* Cor do botão de adicionar */
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.header .btn-add:hover {
  background-color: #2563eb;
}

.users-list {
  margin-top: 1rem;
}

/* Estilo da tabela de usuários */
.users-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.users-table th,
.users-table td {
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  text-align: left;
}

.users-table th {
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

/* Estilos do modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  padding: 2rem; /* Aumentado para dar espaço */
  border-radius: 8px; /* Arredondar os cantos */
  width: 400px; /* Largura maior */
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Sombra mais suave */
  position: relative;
}

/* Botão de fechar */
.close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  cursor: pointer;
  font-size: 1.5rem;
  color: #ef4444; /* Cor do botão de fechar */
}

/* Estilo dos inputs */
input,
select {
  width: 100%;
  padding: 0.75rem; /* Aumentado para mais conforto */
  margin-bottom: 1rem;
  border: 1px solid #e5e7eb;
  border-radius: 4px;
}

/* Estilo do grupo de formulários */
.form-group {
  margin-bottom: 1rem;
}

label {
  font-weight: bold; /* Negrito para os rótulos */
  margin-bottom: 0.5rem; /* Espaço abaixo do rótulo */
  display: block; /* Para garantir que os rótulos ocupem toda a largura */
}

.btn-add {
  background-color: #3b82f6; /* Cor do botão de salvar */
  color: white;
  padding: 0.75rem; /* Aumentado para mais conforto */
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-add:hover {
  background-color: #2563eb;
}
</style>
