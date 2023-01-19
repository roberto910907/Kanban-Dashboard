<template>
  <div :id="`card_${card.id}`" class="card" @click.prevent="showEditModal">
    <div class="flex">
      <span class="grow text-sm font-bold">{{ card.title }}</span>
      <button data-tooltip-target="drag-icon" data-tooltip-placement="right">
        <Icon name="system-uicons:drag-vertical" class="hover:bg-white"></Icon>
      </button>
      <div
        id="drag-icon"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
      >
        Drag card in the same or other column
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>
    <div class="text-xs mt-1 text-gray-700">
      {{ card.description }}
    </div>

    <ModalEdit
      :open="openEditModal"
      :item="card"
      @confirmed="updateCard($event)"
      @close="closeModal"
    ></ModalEdit>

    <NotificationSuccess
      :show="showNotification"
      title="Successfully Saved!"
      message="Card information has been updated."
      @close="showNotification = false"
    ></NotificationSuccess>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { initTooltips } from 'flowbite';
import { useMyFetch } from '../composables/baseFetch';

const props = defineProps({
  card: {
    type: Object,
    required: true,
  },
});

const openEditModal = ref(false);
const showNotification = ref(false);

function showEditModal() {
  openEditModal.value = true;
}

function closeModal() {
  openEditModal.value = false;
}

async function updateCard(card) {
  const data = await useMyFetch(`/api/cards/update/${card.id}`, {
    method: 'PUT',
    body: card,
  });

  if (data.status === 'success') {
    closeModal();

    showNotification.value = true;
  }
}

onMounted(() => {
  initTooltips();
});
</script>
