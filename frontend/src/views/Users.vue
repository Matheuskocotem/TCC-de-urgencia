<template>
  <div class="manage-users">
    <!-- Componente da Sidebar de navegação -->
    <AdminSidebar />

    <!-- Cabeçalho da seção de gerenciamento de usuários -->
    <header class="header">
      <h1>Gerenciar Usuários</h1>
    </header>

    <!-- Conteúdo principal da tabela de usuários -->
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
      users: [
        { id: 1, name: 'Alice', email: 'alice@example.com' },
        { id: 2, name: 'Bob', email: 'bob@example.com' },
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
</style>
