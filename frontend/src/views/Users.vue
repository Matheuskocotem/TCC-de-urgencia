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
          <button class="btn btn-primary" @click="openModal">
            Adicionar Usuário
          </button>
        </div>
        <table class="users-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>CPF</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.name }}</td>
              <td>{{ user.cpf }}</td>
              <td>
                <button class="btn btn-edit btn-secondary mx-1" @click="editUser(user)">
                  Editar
                </button>
                <button class="btn btn-danger mx-1" @click="deleteUser(user.id)">
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Modal de Adicionar/Editar Usuário -->
    <div class="modal fade" :class="{ show: showModal, 'd-block': showModal }" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.5)">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header d-flex justify-content-between">
            <h5 class="modal-title">{{ isEditing ? "Editar Usuário" : "Adicionar Usuário" }}</h5>
            <button class="close btn btn-danger" @click="closeModal">X</button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveUser">
              <div class="form-group m-3">
                <label for="name">Nome:</label>
                <input type="text" id="name" class="form-control" v-model="newUser.name" required />
              </div>
              <div class="form-group m-3">
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" v-model="newUser.email" required />
              </div>
              <div class="form-group m-3">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" class="form-control" v-model="newUser.cpf" required />
              </div>
              <div class="form-group m-3">
                <label for="password">Senha:</label>
                <input type="password" id="password" class="form-control" v-model="newUser.password" required />
              </div>
              <div class="form-group m-3">
                <label for="confirmation_password">Confirme sua Senha:</label>
                <input type="password" id="confirmation_password" class="form-control" v-model="newUser.password_confirmation" required />
              </div>
              <div class="form-group m-3">
                <label for="role">Função:</label>
                <select id="role" class="form-control" v-model="newUser.role" required>
                  <option value="" disabled>Selecione uma função</option>
                  <option value="admin">Administrador</option>
                  <option value="user">Usuário</option>
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
import axios from 'axios';
import AdminSidebar from "../components/AdminSidebar.vue";

export default {
  components: {
    AdminSidebar,
  },
  data() {
    return {
      showModal: false,
      isEditing: false,
      newUser: { id: null, name: "", email: "", role: "", cpf: "", password: "", password_confirmation: "",},
      users: [],
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('http://localhost:8000/api/users/index');
        this.users = response.data.users;
      } catch (error) {
        console.error("Erro ao buscar usuários:", error.response ? error.response.data : error.message);
        alert("Erro ao carregar usuários: " + (error.response?.data?.message || "Erro desconhecido."));
      }
    },


    openModal() {
      this.isEditing = false;
      this.newUser = { id: null, name: "", email: "", role: "", password: "", password_confirmation: "", cpf: ""};
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.newUser = { id: null, name: "", email: "", role: "" };
    },
    async saveUser() {
      try {
        if (this.isEditing) {
          await axios.put(`http://localhost:8000/api/users/${this.newUser.id}`, this.newUser);
          alert("Usuário atualizado com sucesso!");
        } else {
          const response = await axios.post('http://localhost:8000/api/users/add-admin', this.newUser);
          this.users.push(response.data);
          alert("Usuário adicionado com sucesso!");
        }
        this.fetchUsers(); 
        this.closeModal();
      } catch (error) {
        console.error("Erro ao salvar usuário:", error.response?.data);
        alert("Erro ao salvar usuário: " + (error.response?.data?.message || "Erro desconhecido."));
      }
    },
    async deleteUser(userId) {
      if (!confirm("Tem certeza que deseja excluir este usuário?")) return;
      try {
        await axios.delete(`http://localhost:8000/api/users/${userId}`);
        this.users = this.users.filter(user => user.id !== userId);
        alert("Usuário excluído com sucesso!");
      } catch (error) {
        console.error("Erro ao excluir usuário:", error.response?.data);
        alert("Erro ao excluir usuário: " + (error.response?.data?.message || "Erro desconhecido."));
      }
    },
    editUser(user) {
      this.isEditing = true;;;
      this.newUser = { ...user };
      this.showModal = true;
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
  margin-left: 250px;
  /* Ajusta para acomodar a sidebar */
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

/* Modal transitions */
.modal.fade.show {
  opacity: 1;
  transition: opacity 0.3s ease;
}
.modal.fade {
  opacity: 0;
}

</style>
