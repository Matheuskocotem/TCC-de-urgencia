<template>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
      <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
          <div class="max-w-md mx-auto">
            <div>
              <h1 class="text-2xl font-semibold">Editar Perfil de Usuário</h1>
            </div>
            <div class="divide-y divide-gray-200">
              <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                <div class="flex flex-col">
                  <label class="leading-loose">Nome</label>
                  <input 
                    type="text" 
                    v-model="user.name" 
                    class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" 
                    placeholder="Nome completo"
                  >
                </div>
                <div class="flex flex-col">
                  <label class="leading-loose">Email</label>
                  <input 
                    type="email" 
                    v-model="user.email" 
                    class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" 
                    placeholder="Email"
                  >
                </div>
                <div class="flex flex-col">
                  <label class="leading-loose">Telefone</label>
                  <input 
                    type="tel" 
                    v-model="user.phone" 
                    class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" 
                    placeholder="Telefone"
                  >
                </div>
                <div class="flex flex-col">
                  <label class="leading-loose">Cargo</label>
                  <input 
                    type="text" 
                    v-model="user.role" 
                    class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" 
                    placeholder="Cargo"
                  >
                </div>
              </div>
              <div class="pt-4 flex items-center space-x-4">
                <button 
                  class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none"
                  @click="saveChanges"
                >
                  Salvar Alterações
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Toast de notificação -->
      <div 
        v-if="showNotification" 
        class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg transition-opacity duration-500"
        :class="{ 'opacity-100': showNotification, 'opacity-0': !showNotification }"
      >
        Alterações salvas com sucesso!
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, reactive } from 'vue'
  
  const user = reactive({
    name: 'João Silva',
    email: 'joao.silva@example.com',
    phone: '(11) 98765-4321',
    role: 'Desenvolvedor'
  })
  
  const showNotification = ref(false)
  
  const saveChanges = () => {
    // Simular uma chamada de API para salvar as alterações
    setTimeout(() => {
      showNotification.value = true
      setTimeout(() => {
        showNotification.value = false
      }, 3000)
    }, 1000)
  }
  </script>