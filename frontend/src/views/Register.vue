<template>
    <div id="main">
      <div id="main-container">
        <!-- Logo do DITIS -->
        <div id="logoArea">
          <img src="../Img/Logoditis.png" alt="Logo DITIS" />
        </div>
  
        <!-- Título do formulário -->
        <div id="titleArea">

          <p>Crie sua conta preenchendo os dados abaixo</p>
        </div>
  
        <!-- Formulário de registro -->
        <form id="form" @submit.prevent="handleRegister">
          <!-- Campo de Nome -->
          <input
            type="text"
            placeholder="Digite seu nome"
            v-model="form.name"
            required
            aria-label="Nome"
          />
  
          <!-- Campo de E-mail -->
          <input
            type="email"
            placeholder="Digite seu e-mail"
            v-model="form.email"
            required
            aria-label="E-mail"
          />
  
          <input
          type="text"
          placeholder="Digite seu CPF"
          v-model="form.cpf"
          @input="formatCpf"
          maxlength="14" 
          required
          aria-label="CPF"
        />
  
          <!-- Campo de Senha -->
          <input
            type="password"
            placeholder="Digite sua senha"
            v-model="form.password"
            required
            aria-label="Senha"
          />
  
          <!-- Campo de Confirmação de Senha -->
          <input
            type="password"
            placeholder="Confirme sua senha"
            v-model="form.password_confirmation"
            required
            aria-label="Confirmação de Senha"
          />
  
          <!-- Botão de Registro -->
          <button type="submit">Registrar</button>
        </form>
  
        <!-- Link de login -->
        <div id="linkForm">
          <a href="login" class="link">Já tem uma conta? Faça login.</a>
        </div>
      </div>
  
      <!-- Footer -->
      <footer id="footer">
        <p>© 2024 by Nexgen Arch</p>
      </footer>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          cpf: '',
          password: '',
          password_confirmation: '',
        },
      };
    },
    methods: {
      async handleRegister() {
        const formToSubmit = {
          ...this.form,
          cpf: this.form.cpf.replace(/\D/g, '') 
        };
  
        try {
          const response = await axios.post('http://localhost:8000/api/register', formToSubmit);
          console.log('Registro realizado', response.data);
          alert('Registro realizado com sucesso!');
          this.$router.push('/login'); 
        } catch (error) {
          console.error('Erro ao registrar', error.response?.data);
          alert('Erro ao registrar: ' + (error.response?.data?.message || 'Erro desconhecido.'));
        }
      },
      formatCpf() {
        let cpf = this.form.cpf.replace(/\D/g, '');
  
        if (cpf.length <= 11) {
          cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
          cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
          cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        }
  
        this.form.cpf = cpf;
      }
    },
  };
  </script>
  
  
  <style scoped>
  #main {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 90vh;
    margin: 0;
  }
  
  #main-container {
    width: 400px;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2), 0 4px 12px rgba(0, 0, 0, 0.3);
    text-align: center;
  }
  
  #logoArea img {
    width: 150px;
    height: auto;
    margin-bottom: 20px;
  }
  
  #titleArea .h1s {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: #333;
    margin-bottom: 10px;
  }
  
  #titleArea p {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #555;
  }
  
  #form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  #form input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.05);
  }
  
  #form input:focus {
    border-color: #28a745; /* Cor de foco verde */
    outline: none;
  }
  
  #linkForm {
    display: flex;
    justify-content: center;
    width: 100%;
    margin: 10px 0;
  }
  
  #linkForm .link {
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    color: #555;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  
  #linkForm .link:hover {
    color: #0056b3;
  }
  
  #form button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 8px;
    background-color: #28a745;
    color: white;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 15px;
  }
  
  #form button:hover {
    background-color: #218838;
  }
  
  #footer {
    margin-top: 20px;
  }
  
  #footer p {
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    color: #aaa;
    text-align: center;
  }
  </style>
  