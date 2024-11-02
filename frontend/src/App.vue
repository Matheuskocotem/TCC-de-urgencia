<script setup>
import { RouterView } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import 'vue3-toastify/dist/index.css'; 
</script>

<template>
  <div class="app-container">
    <main>
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
.app-container {
  display: flex;
  height: 100vh;
}

main {
  flex-grow: 1;
  padding: 2rem;
  overflow-y: auto;
}
</style>
