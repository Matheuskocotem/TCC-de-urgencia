<template>
  <div class="manage-users">
    <AdminSidebar />
    <header class="py-1">
      <h2>Gerenciar Usuários</h2>
    </header>

    <main>
      <div class="py-4">
        <div class="d-flex justify-content-between">
          <h4>Usuários Registrados</h4>
          <button class="btn btn-primary" @click="showModal = true">
            Adicionar Usuário
          </button>
        </div>
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
                <button
                  class="btn btn-edit btn-secondary mx-1"
                  @click="editUser(user)"
                >
                  Editar
                </button>
                <button
                  class="btn btn-danger mx-1"
                  @click="deleteUser(user.id)"
                >
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Modal de Adicionar Usuário -->
    <div
      class="modal fade"
      :class="{ show: showModal, 'd-block': showModal }"
      tabindex="-1"
      role="dialog"
      style="background: rgba(0, 0, 0, 0.5)"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header d-flex justify-content-between">
            <h5 class="modal-title">Adicionar Usuário</h5>
            <button
              class="close btn btn-danger"
              @click="showModal = false"
            >X
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="addUser">
              <div class="form-group m-3">
                <label for="name">Nome:</label>
                <input
                  type="text"
                  id="name"
                  class="form-control"
                  v-model="newUser.name"
                  required
                />
              </div>
              <div class="form-group m-3">
                <label for="email">Email:</label>
                <input
                  type="email"
                  id="email"
                  class="form-control"
                  v-model="newUser.email"
                  required
                />
              </div>
              <div class="form-group m-3">
                <label for="role">Função:</label>
                <select
                  id="role"
                  class="form-control"
                  v-model="newUser.role"
                  required
                >
                  <option value="" disabled>Selecione uma função</option>
                  <option value="admin">Administrador</option>
                  <option value="user">Usuário</option>
                  <option value="moderator">Moderador</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary m-3">Salvar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AdminSidebar from "../components/AdminSidebar.vue";

export default {
  components: {
    AdminSidebar,
  },
  data() {
    return {
      showModal: false,
      newUser: { name: "", email: "", role: "" },
      users: [
        { id: 1, name: "Alice", email: "alice@example.com", role: "admin" },
        { id: 2, name: "Bob", email: "bob@example.com", role: "moderator" },
        // Adicione mais usuários conforme necessário
      ],
    };
  },
  methods: {
    editUser(user) {
      // Lógica para editar o usuário
      console.log("Editando usuário:", user);
    },
    deleteUser(userId) {
      // Lógica para excluir o usuário
      console.log("Excluindo usuário com ID:", userId);
    },
    addUser() {
      const newId = this.users.length + 1; // Simulando ID único
      this.users.push({ id: newId, ...this.newUser });
      this.newUser = { name: "", email: "", role: "" }; // Limpa o formulário
      this.showModal = false; // Fecha o modal
      console.log("Usuário adicionado:", this.newUser);
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

</style>
