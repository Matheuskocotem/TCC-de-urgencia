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
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

.app-container {
  display: flex;
  height: 100vh;
}

main {
  flex-grow: 1;
  overflow-y: auto;
}
</style>
