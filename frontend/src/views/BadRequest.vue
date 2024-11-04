// src/views/BadRequest.vue

<template>
  <div class="bad-request">
    <h1>Acesso Negado</h1>
    <p>Você não tem permissão para acessar esta página.</p>
    <button @click="goToDashboard">Voltar para a Dashboard</button>
  </div>
</template>

<script>
export default {
  methods: {
    goToDashboard() {
      this.$router.push({ name: 'VizualiazarReunioes' });
    },
  },
};
</script>

<style scoped>
.bad-request {
  text-align: center;
  margin-top: 20px;
}
</style>
