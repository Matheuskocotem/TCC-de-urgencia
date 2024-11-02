<template>
    <div>
      <button @click="showToast">Mostrar Toast</button>
    </div>
  </template>
  
  <script>
  import { ToastContainer, toast } from "vue3-toastify";
  import "vue3-toastify/dist/index.css";
  
  export default {
    components: {
      ToastContainer
    },
    methods: {
      showToast() {
        toast("Isso é um toast!");
      }
    }
  };
  </script>
  