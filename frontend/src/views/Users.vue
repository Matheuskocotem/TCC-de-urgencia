<template>
    <div class="users">
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
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const users = ref([]) // Sua lista de usuários aqui
  
  const editUser = (user) => {
    // Lógica para editar usuário
  }
  
  const deleteUser = (id) => {
    // Lógica para excluir usuário
  }
  </script>
  
  <style scoped>
  .users {
    padding: 20px;
  }
  
  .users-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .users-table th,
  .users-table td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  </style>
  