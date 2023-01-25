<template>
  <div
    :id="`card_${card.id}`"
    class="card group"
    @click.prevent="store.showEditModal(card)"
  >
    <div class="flex">
      <span class="grow text-sm font-bold">{{ card.title }}</span>
      <button
        class="invisible group-hover:visible hover:bg-gray-300 hover:rounded-full"
      >
        <Icon name="system-uicons:create" class="text-gray-500"></Icon>
      </button>
    </div>
    <div class="text-xs mt-1 text-gray-700">
      {{ card.description }}
    </div>
  </div>
</template>

<script setup>
import { useCardStore } from '../stores/useCardStore';

defineProps({
  card: {
    type: Object,
    required: true,
  },
});

const store = useCardStore();
</script>
