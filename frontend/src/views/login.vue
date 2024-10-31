<template>
    <div id="main">
      <div id="main-container">
        <!-- Logo do DITIS -->
        <div id="logoArea">
          <img src="../Img/Logoditis.png" alt="Logo DITIS">
        </div>
  
        <!-- Título do formulário -->
        <div id="titleArea">
          <h2 class="h1s">Login</h2>
          <p>Entre com seu CPF e senha</p>
        </div>
  
        <!-- Formulário de login -->
        <form id="form">
          <!-- Campo de CPF -->
          <input type="text" placeholder="Digite seu CPF" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite um CPF válido no formato 000.000.000-00">
  
          <!-- Campo de Senha -->
          <input type="password" placeholder="Digite sua senha" required>
  
          <!-- Botão de Login -->
          <button type="submit">Entrar</button>
        </form>
  
        <!-- Link de esqueci a senha -->
        <div id="linkForm">
          <a href="#" class="link">Esqueci minha senha</a>
          <a href="#" class="link">Registre-se</a>
        </div>
      </div>
  
      <!-- Footer -->
      <footer id="footer">
        <p>© 2024 by Nexgen Arch</p>
      </footer>
    </div>
  </template>
  
  <style scoped>
  #main {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 90vh;
    margin: 0;
    background-size: cover;
    background-position: center;
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
  
  #linkForm {
    display: flex;
    justify-content: center;
    width: 100%;
    margin: 10px 0;
  }
  
  #linkForm .link {
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    color: #007BFF;
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
  