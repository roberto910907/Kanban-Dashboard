<template>
  <div class="bg-column p-2.5 ml-3 rounded-md w-72 h-fit">
    <div class="flex">
      <span class="grow ml-1 text-md font-bold border hover:border-blue-300">
        {{ column.title }}
      </span>
      <Icon
        name="mdi-light:delete"
        class="text-gray-600 hover:bg-gray-300"
        size="18"
        @click="columnStore.showDeleteModal(column.id)"
      ></Icon>
    </div>

    <div v-if="column.cards.length" class="flex relative">
      <Icon
        name="heroicons-outline:magnifying-glass"
        size="16"
        class="text-icon absolute top-4 left-2"
      ></Icon>
      <input
        v-model="search"
        type="text"
        placeholder="Search card..."
        class="search mt-1 block w-full rounded-lg p-2.5 pl-8 text-xs"
      />
    </div>

    <Draggable
      :id="`column_${column.uuid}`"
      v-model="filteredCards"
      item-key="uuid"
      group="cards"
      @end="updateDraggedCard"
    >
      <template #item="{ element }">
        <Card :card="element"></Card>
      </template>
    </Draggable>

    <div v-if="!creating" class="cursor-pointer mt-3" @click="creating = true">
      <span class="link rounded-md hover:bg-gray-300 hover:underline">
        + Add New Card
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
import { storeToRefs } from 'pinia';
import { useCardStore } from '../stores/useCardStore';
import { useColumnStore } from '../stores/useColumnStore';

const props = defineProps({
  column: {
    type: Object,
    required: true,
  },
});

const cardStore = useCardStore();
const columnStore = useColumnStore();

const search = ref('');
const creating = ref(false);
const { newCard } = storeToRefs(cardStore);

const filteredCards = computed(() => {
  return search.value
    ? props.column.cards.filter((card) => card.title.includes(search.value))
    : props.column.cards;
});

function updateDraggedCard(event) {
  if (event.from === event.to) {
    cardStore.updateCardPosition(event);
  } else if (event.pullMode && event.from !== event.to) {
    cardStore.updateCardColumn(event);
  }
}

async function saveCard() {
  await cardStore.createCard(props.column.uuid);

  creating.value = false;
}
</script>
