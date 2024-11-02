<template>
  <div id="main">
    <div id="main-container">
      <!-- Logo do DITIS -->
      <div id="logoArea">
        <img src="../Img/Logoditis.png" alt="Logo DITIS" />
      </div>

      <!-- Título do formulário -->
      <div id="titleArea">
        <p>Entre com seu CPF e senha</p>
      </div>

      <!-- Formulário de login -->
      <form id="form" @submit.prevent="handleLogin">
        <!-- Campo de CPF -->
        <input
          type="text"
          placeholder="Digite seu CPF"
          v-model="cpf"
          @input="formatCpf"
          maxlength="14"
          required
          aria-label="CPF"
        />

        <!-- Campo de Senha -->
        <input
          type="password"
          placeholder="Digite sua senha"
          v-model="password"
          required
          aria-label="Senha"
        />

        <!-- Link de esqueci a senha -->
        <a href="#" class="forgot-password">Esqueceu sua senha?</a>

        <!-- Botão de Login -->
        <button type="submit">Entrar</button>
      </form>

      <!-- Link de registro -->
      <div id="linkForm">
        <a href="register" class="link">Não tem uma conta? Registre-se</a>
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
import { toast } from 'vue3-toastify';

export default {
  data() {
    return {
      cpf: '',
      password: '',
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          cpf: this.cpf.replace(/\D/g, ''), 
          password: this.password,
        });

        console.log("Login realizado", response.data);
        localStorage.setItem('token', response.data.token);
        toast.success("Login realizado com sucesso!", { autoClose: 5000 });
        this.$router.push('/');
      } catch (error) {
        console.error("Erro ao fazer login:", error.response.data);
        toast.error("Login falhou. Verifique seu CPF e senha.", { autoClose: 5000 });
      }
    },
    formatCpf() {
      let cpf = this.cpf.replace(/\D/g, ''); 

      if (cpf.length <= 11) {
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      }

      this.cpf = cpf;
    },
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

.forgot-password {
  width: 100%;
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  color: #555;
  text-align: left;
  margin-top: -5px;
  margin-bottom: 15px;
  cursor: pointer;
  text-decoration: none;
}

#linkForm {
  display: flex;
  justify-content: center;
  margin-top: 15px;
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
