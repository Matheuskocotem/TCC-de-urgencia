import { createStore } from 'vuex';
import axios from 'axios'; 

axios.defaults.baseURL = 'http://localhost:8000/api';

axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers['Authorization'] = 'Bearer ' + token;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

const store = createStore({
  state: {
    token: localStorage.getItem('token') || null,
    role: localStorage.getItem('role') || null,
  },
  getters: {
    isAuthenticated(state) {
      return !!state.token;
    }
  },
  mutations: {
    setToken(state, token) {
      console.log('Token sendo armazenado:', token); // Verifique se o token está sendo armazenado corretamente
      state.token = token;
      localStorage.setItem('token', token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    
    setRole(state, role) {
      state.role = role;
      localStorage.setItem('role', role);
    },
    clearAuth(state) {
      state.token = null;
      state.role = null;
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      delete axios.defaults.headers.common['Authorization'];
    },
  },
  actions: {
    async login({ commit }, { cpf, password }) {
      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          cpf: cpf.replace(/\D/g, ''),
          password,
        });

        commit('setToken', response.data.token);
        commit('setRole', response.data.role);
        return response.data; 
      } catch (error) {
        throw error; 
      }
    },

    // Verifica se o usuário está autenticado e se o token é válido
    async checkAuth({ state, dispatch }) {
      console.log('Verificando token:', state.token); // Verifique se o token está sendo carregado corretamente
    
      if (state.token) {
        try {
          const response = await axios.get('http://localhost:8000/api/check-token', {
            headers: {
              Authorization: `Bearer ${state.token}`,
            },
          });
    
          if (response.data.valid) {
            return true; // Token é válido
          } else {
            dispatch('logout');
            return false; // Token inválido
          }
        } catch (error) {
          dispatch('logout');
          return false; // Se a requisição falhar, desloga o usuário
        }
      }
      return false; // Se não houver token
    },
    
    logout({ commit }) {
      commit('clearAuth');
    },
  },
});

export default store;