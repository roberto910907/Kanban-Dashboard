<template>
  <div class="bg-column p-2.5 ml-3 rounded-md w-72 h-fit">
    <div class="flex">
      <span class="grow text-lg text-title font-medium">
        {{ column.title }}
      </span>
      <Icon
        icon-name="delete"
        class="text-red cursor-pointer"
        @click="deleteColumn"
      ></Icon>
    </div>

    <div v-if="column.cards.length" class="flex">
      <input
        v-model="search"
        type="text"
        placeholder="Search card by title..."
        class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500"
      />
    </div>

    <Draggable
      :id="`column_${column.id}`"
      item-key="id"
      group="cards"
      :list="filteredCards"
      @end="updateDraggedCard"
    >
      <template #item="{ element }">
        <Card :card="element"></Card>
      </template>
    </Draggable>

    <div v-if="!creating" class="cursor-pointer mt-3" @click="creating = true">
      <span
        class="px-4 py-1.5 underline text-blue-500 hover:bg-gray-300 hover:rounded-md hover:no-underline"
      >
        + Add new card
      </span>
    </div>
    <div
      v-else
      class="my-1 p-2.5 bg-white border text-gray-700 shadow-md cursor-pointer rounded-lg hover:border-gray-400"
    >
      <textarea
        v-model="newCard.title"
        rows="3"
        class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm"
        @keydown.enter="saveCard"
      ></textarea>

      <div class="flex mt-2">
        <button
          type="button"
          class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          @click="saveCard"
        >
          Save Card
        </button>
        <span
          class="cursor-pointer ml-2 p-2 my-auto text-blue-500 hover:bg-gray-300 hover:rounded-md"
          @click="creating = false"
        >
          Cancel
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Draggable from 'vuedraggable';
import { useMyFetch } from '../composables/baseFetch';

const CARD_DATA = {
  title: '',
};

const search = ref('');
const creating = ref(false);
const newCard = ref(CARD_DATA);

const props = defineProps({
  column: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['column-updated', 'column-deleted']);

const filteredCards = computed(() => {
  return search.value
    ? props.column.cards.filter((card) => card.title.includes(search.value))
    : props.column.cards;
});

async function refreshCards() {
  try {
    const data = await useMyFetch(`/api/cards/${props.column.id}/list`);

    emit('column-updated', data.cards);
  } catch (error) {
    // Show UI error notification
  }
}

async function updateCardPosition(event) {
  const cardId = parseInt(event.item.id.split('_')[1], 10);
  const newPosition = event.newIndex;

  const data = await useMyFetch(`/api/cards/update/${cardId}/position`, {
    method: 'PUT',
    body: { position: newPosition },
  });

  if (data.status === 'success') {
    // Show success message here

    await refreshCards();
  }
}

async function updateCardColumn(event) {
  const cardId = parseInt(event.item.id.split('_')[1], 10);
  const columnId = parseInt(event.to.id.split('_')[1], 10);
  const newPosition = event.newIndex;

  const data = await useMyFetch(`/api/cards/update/${cardId}/column`, {
    method: 'PUT',
    body: {
      column_id: columnId,
      position: newPosition,
    },
  });

  if (data.status === 'success') {
    // Show success message here

    await refreshCards();
  }
}

function updateDraggedCard(event) {
  if (event.from === event.to) {
    updateCardPosition(event);
  } else if (event.pullMode && event.from !== event.to) {
    updateCardColumn(event);
  }
}

async function deleteColumn() {
  await useMyFetch(`/api/columns/${props.column.id}/delete`, {
    method: 'DELETE',
  });

  emit('column-deleted');
}

async function saveCard() {
  const data = await useMyFetch(`/api/cards/${props.column.id}/add`, {
    method: 'POST',
    body: newCard.value,
  });

  if (data.id) {
    await refreshCards();
  }

  newCard.value = { ...CARD_DATA };
  creating.value = false;
}
</script>
