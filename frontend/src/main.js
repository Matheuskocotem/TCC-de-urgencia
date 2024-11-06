import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Toast from 'vue-toastification';

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

const app = createApp(App);

// Use o router e o store
app.use(router);
app.use(store);

// Verifique a autenticação assim que a aplicação iniciar
store.dispatch('checkAuth').then((authenticated) => {
  console.log('Usuário autenticado:', authenticated); // Verifique se a verificação de autenticação ocorre corretamente
  if (!authenticated) {
    router.push('/login');
  }
});


// Configuração do Toast
app.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
});

app.mount('#app');
