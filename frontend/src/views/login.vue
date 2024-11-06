<template>
  <div id="main">
    <div id="main-container">
      <div id="logoArea">
        <img src="../Img/Logoditis.png" alt="Logo DITIS" />
      </div>
      <div id="titleArea">
        <p>Entre com seu CPF e senha</p>
      </div>
      <form id="form" @submit.prevent="handleLogin">
        <input
          type="text"
          placeholder="Digite seu CPF"
          v-model="cpf"
          @input="formatCpf"
          maxlength="14"
          required
          aria-label="CPF"
        />
        <input
          type="password"
          placeholder="Digite sua senha"
          v-model="password"
          required
          aria-label="Senha"
        />
        <a href="forgot-password" class="forgot-password">Esqueceu sua senha?</a>
        <button type="submit">Entrar</button>
      </form>
      <div id="linkForm">
        <a href="register" class="link">Não tem uma conta? Registre-se</a>
      </div>
    </div>
    <footer id="footer">
      <p>© 2024 by Nexgen Arch</p>
    </footer>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { toast } from 'vue3-toastify';

export default {
  data() {
    return {
      cpf: '',
      password: '',
    };
  },
  methods: {
    ...mapActions(['login']),
    async handleLogin() {
      try {
        const response = await this.$store.dispatch('login', {
          cpf: this.cpf,
          password: this.password,
        });

        console.log("Dados do usuário:", response);

        localStorage.setItem('token', response.token);
        localStorage.setItem('role', response.role);
        toast.success("Login realizado com sucesso!", { autoClose: 5000 });

        if (response.role) {
          if (response.role === 'admin') {
            this.$router.push({ name: 'admindash' });
          } else {
            this.$router.push({ name: 'VizualiazarReunioes' });
          }
        } else {
          console.error("Papel do usuário não encontrado");
          toast.error("Papel do usuário não encontrado. Tente novamente.", { autoClose: 5000 });
        }
      } catch (error) {
        console.error("Erro ao fazer login:", error.response ? error.response.data : error.message);
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
  width: 90%;
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
  border-color: #28a745;
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

@media (max-width: 480px) {
  #main-container {
    width: 100%;
    padding: 20px;
    box-shadow: none;
    border-radius: 0;
  }

  #logoArea img {
    width: 120px;
  }

  #titleArea p {
    font-size: 12px;
  }

  #form input, #form button {
    font-size: 13px;
    padding: 8px;
  }

  .forgot-password, #linkForm .link {
    font-size: 11px;
  }

  #footer p {
    font-size: 9px;
  }
}
</style>
