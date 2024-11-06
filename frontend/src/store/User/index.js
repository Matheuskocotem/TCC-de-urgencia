import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      token: null,
      email: null,
    };
  },
  mutations: {
    setResetPasswordData(state, { token, email }) {
      state.token = token;
      state.email = email;
    },
  },
  actions: {
    setResetPasswordData({ commit }, { token, email }) {
      commit('setResetPasswordData', { token, email });
    },
  },
});

export default store;
