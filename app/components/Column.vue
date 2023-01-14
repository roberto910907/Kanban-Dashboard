<template>
  <div class="column">
    <div class="flex">
      <span class="grow title ml-1">{{ column.title }}</span>
      <Icon
        icon-name="delete"
        class="bg-red cursor-pointer"
        @click="deleteColumn"
      ></Icon>
    </div>

    <div v-if="column.cards.length" class="flex mt-1">
      <input
        v-model="search"
        type="text"
        placeholder="Search card by title..."
        class="form-control w-full h-36"
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

    <div v-if="!creating" class="cursor-pointer mt-1" @click="creating = true">
      <span class="link">+ Add new card</span>
    </div>
    <div v-else class="card">
      <textarea
        v-model="newCard.title"
        rows="3"
        class="form-control"
        @keydown.enter="saveCard"
      ></textarea>

      <div class="flex mt-1">
        <button class="button primary" @click="saveCard">Save Card</button>
        <span class="cursor-pointer ml-1 link" @click="creating = false">
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
