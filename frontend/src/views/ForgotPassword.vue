<template>
    <div id="main">
      <div id="main-container">
        <!-- Logo do DITIS -->
        <div id="logoArea">
          <img src="../Img/Logoditis.png" alt="Logo DITIS" />
        </div>
  
        <!-- Título do formulário -->
        <div id="titleArea">
          <p>Redefina sua senha preenchendo o e-mail abaixo</p>
        </div>
  
        <!-- Formulário de Reset de Senha -->
        <form id="form" @submit.prevent="handleResetPassword">
          <!-- Campo de E-mail -->
          <input
            type="email"
            placeholder="Digite seu e-mail"
            v-model="form.email"
            required
            aria-label="E-mail"
          />
    
          <!-- Botão de Envio -->
          <button type="submit">Enviar E-mail de Redefinição</button>
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
          email: '',
        },
      };
    },
    methods: {
      async handleResetPassword() {
        const formToSubmit = { ...this.form };
  
        try {
          const response = await axios.post('http://localhost:8000/api/forgot-password', formToSubmit);
          console.log('E-mail de redefinição enviado com sucesso', response.data);
          alert('E-mail de redefinição enviado! Verifique sua caixa de entrada.');
          this.$router.push('/login');
        } catch (error) {
          console.error('Erro ao enviar e-mail', error.response?.data);
          alert('Erro ao enviar o e-mail: ' + (error.response?.data?.message || 'Erro desconhecido.'));
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilo mantido igual ao original */
  
  #main {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh;
    padding: 10px;
    margin: 0;
  }
  
  #main-container {
    width: 100%;
    max-width: 400px;
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
  
  #titleArea p {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
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
    border-color: #28a745;
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
  
  /* Responsividade para telas menores */
  @media (max-width: 768px) {
    #main-container {
      padding: 20px;
      width: 90%;
    }
  
    #titleArea p {
      font-size: 14px;
    }
  
    #form input {
      font-size: 13px;
    }
  
    #form button {
      font-size: 13px;
      padding: 8px;
    }
  
    #footer p {
      font-size: 9px;
    }
  }
  
  @media (max-width: 480px) {
    #main-container {
      padding: 15px;
    }
  
    #logoArea img {
      width: 120px;
    }
  
    #titleArea p {
      font-size: 12px;
    }
  
    #form input, #form button {
      font-size: 12px;
    }
  
    #footer p {
      font-size: 8px;
    }
  }
  </style>