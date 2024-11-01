<template>
  <Transition appear name="modal">
    <div class="modal-overlay" @click="$emit('close')">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Reservar {{ room.name }}</h3>
          <button class="close-button" @click="$emit('close')">×</button>
        </div>
        <form @submit.prevent="submitReservation">
          <div class="modal-body">
            <label for="date">Data</label>
            <input type="date" id="date" v-model="reservation.date" required />
            
            <label for="time">Horário de Início</label>
            <select id="time" v-model="reservation.startTime" required>
              <option v-for="slot in room.availableSlots" :key="slot" :value="slot">{{ slot }}</option>
            </select>

            <label for="endTime">Horário de Término</label>
            <select id="endTime" v-model="reservation.endTime" required>
              <option v-for="slot in availableEndTimes" :key="slot" :value="slot">{{ slot }}</option>
            </select>

            <label for="participants">Participantes</label>
            <input type="number" id="participants" v-model.number="reservation.participants" required min="1" :max="room.capacity" />
            <p>Capacidade máxima: {{ room.capacity }}</p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="submit-button">Confirmar Reserva</button>
            <button type="button" @click="$emit('close')" class="cancel-button">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({ room: Object })
const emit = defineEmits(['close', 'submit'])

const reservation = ref({ date: '', startTime: '', endTime: '', participants: 1 })

// Computed para calcular os horários de término disponíveis com base no horário de início
const availableEndTimes = computed(() => {
  const endTimes = []
  const startIndex = props.room.availableSlots.indexOf(reservation.value.startTime)

  // Adiciona os horários de término a partir do horário de início selecionado
  for (let i = startIndex + 1; i < props.room.availableSlots.length; i++) {
    endTimes.push(props.room.availableSlots[i])
  }
  
  return endTimes
})

const submitReservation = () => {
  if (reservation.value.participants > props.room.capacity) {
    alert('O número de participantes excede a capacidade da sala.')
    return
  }
  
  // Lógica para garantir que o horário de término seja posterior ao horário de início
  if (reservation.value.endTime <= reservation.value.startTime) {
    alert('O horário de término deve ser posterior ao horário de início.')
    return
  }

  emit('submit', { ...reservation.value, roomId: props.room.id })
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7); /* Escurecendo um pouco mais */
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  border-radius: 0.5rem;
  padding: 2rem; /* Aumentando o padding para um layout mais espaçado */
  width: 90%;
  max-width: 400px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Sombras mais suaves */
  transition: transform 0.3s ease; /* Transição suave */
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem; /* Espaço entre o cabeçalho e o corpo */
}

.close-button {
  background: none;
  border: none;
  font-size: 1.5rem;
  color: #333; /* Cor escura para o botão de fechar */
  cursor: pointer;
}

.modal-body {
  margin-bottom: 1rem; /* Espaço abaixo do corpo */
}

.modal-body label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold; /* Texto em negrito */
}

.modal-body input,
.modal-body select {
  width: 100%;
  padding: 0.5rem; /* Padding interno */
  border: 1px solid #ccc; /* Borda clara */
  border-radius: 0.25rem; /* Bordas arredondadas */
  margin-bottom: 1rem; /* Espaçamento entre os campos */
}

.modal-footer {
  display: flex;
  justify-content: space-between;
}

.submit-button {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.25rem;
  background-color: #4c51bf; /* Azul */
  color: white;
  cursor: pointer;
  transition: background-color 0.2s; /* Transição de cor */
}

.submit-button:hover {
  background-color: #434190; /* Cor mais escura no hover */
}

.cancel-button {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.25rem;
  background-color: #e2e8f0; /* Cor clara */
  color: #4a5568; /* Cor escura */
  cursor: pointer;
  transition: background-color 0.2s; /* Transição de cor */
}

.cancel-button:hover {
  background-color: #edf2f7; /* Cor mais clara no hover */
}
</style>
