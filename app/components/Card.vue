<template>
  <div
    :id="`card_${card.id}`"
    class="card cursor-pointer"
    @click="openEditModal"
  >
    <div class="flex">
      <span class="grow">{{ card.title }}</span>
      <span>:::</span>
    </div>

<!--    <Modal :name="modalCardId">-->
<!--      <div class="pa-30">-->
<!--        <div class="title">Card Information (#{{ card.id }})</div>-->
<!--        <div class="mt-1">-->
<!--          <input-->
<!--            v-model="card.title"-->
<!--            placeholder="Enter card title..."-->
<!--            type="text"-->
<!--            class="form-control w-full h-36"-->
<!--          />-->
<!--        </div>-->
<!--        <div class="mt-1">-->
<!--          <textarea-->
<!--            v-model="card.description"-->
<!--            rows="5"-->
<!--            placeholder="Card description..."-->
<!--            class="form-control w-full"-->
<!--          ></textarea>-->
<!--        </div>-->
<!--        <div class="flex mt-1">-->
<!--          <button class="button primary" @click="updateCard">-->
<!--            Update Card-->
<!--          </button>-->
<!--          <span class="cursor-pointer ml-1 link" @click="closeModal">-->
<!--            Cancel-->
<!--          </span>-->
<!--        </div>-->
<!--      </div>-->
<!--    </Modal>-->
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useMyFetch } from '../composables/baseFetch';

const props = defineProps({
  card: {
    type: Object,
    required: true,
  },
});

const modalCardId = computed(() => {
  return `modal_card_${props.card.id}`;
});

function openEditModal() {
  $modal.show(modalCardId);
}

function closeModal() {
  $modal.hide(modalCardId);
}

async function updateCard() {
  const data = await useMyFetch(`/api/cards/update/${props.card.id}`, { method: 'PUT', body: props.card});

  if (data.status === 'success') {
    closeModal();
  }
}
</script>
