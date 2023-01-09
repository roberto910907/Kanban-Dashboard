<template>
  <div class="column">
    <div class="flex">
      <span class="grow">{{ column.title }}</span>
      <Icon
        icon-name="delete"
        class="bg-red cursor-pointer"
        @click="deleteColumn"
      ></Icon>
    </div>

    <Draggable
      :id="`column_${column.id}`"
      group="cards"
      :list="column.cards"
      @end="updateDraggedCard"
    >
      <Card v-for="card in column.cards" :key="card.id" :card="card"></Card>
    </Draggable>

    <div v-if="!creating" class="cursor-pointer" @click="creating = true">
      <span>+ Add new card</span>
    </div>
    <div v-else class="card">
      <textarea
        v-model="newCard.title"
        rows="2"
        @keydown.enter="saveCard"
      ></textarea>

      <div class="flex mt-1">
        <button @click="saveCard">Save Card</button>
        <span class="cursor-pointer ml-1" @click="creating = false">
          Cancel
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Draggable from 'vuedraggable';
import Card from './Card.vue';
import Icon from './Icon.vue';

const CARD_DATA = {
  title: '',
};

export default {
  name: 'Column',
  components: { Card, Draggable, Icon },
  props: {
    column: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      creating: false,
      dragging: false,
      newCard: { ...CARD_DATA },
    };
  },

  methods: {
    updateDraggedCard(event) {
      if (event.from === event.to) {
        this.updateCardPosition(event);
      } else if (event.pullMode && event.from !== event.to) {
        this.updateCardColumn(event);
      }
    },

    async updateCardPosition(event) {
      const cardId = parseInt(event.item.id.split('_')[1], 10);
      const newPosition = event.newIndex;

      try {
        const { data } = await axios.put(
          `/api/cards/update/${cardId}/position`,
          {
            position: newPosition,
          }
        );

        if (data.status === 'success') {
          // Show success message here

          await this.refreshCards();
        }
      } catch (error) {
        // Show UI error notification
      }
    },

    async updateCardColumn(event) {
      const cardId = parseInt(event.item.id.split('_')[1], 10);
      const columnId = parseInt(event.to.id.split('_')[1], 10);
      const newPosition = event.newIndex;

      try {
        const { data } = await axios.put(`/api/cards/update/${cardId}/column`, {
          column_id: columnId,
          position: newPosition,
        });

        if (data.status === 'success') {
          // Show success message here

          await this.refreshCards();
        }
      } catch (error) {
        // Show UI error notification
      }
    },

    async refreshCards() {
      try {
        const { data } = await axios.get(`/api/cards/${this.column.id}/list`);

        this.$emit('column-updated', data.cards);
      } catch (error) {
        // Show UI error notification
      }
    },

    async deleteColumn() {
      try {
        await axios.delete(`/api/columns/${this.column.id}/delete`);

        this.$emit('column-deleted');
      } catch (error) {
        // Show UI error notification
      }
    },

    async saveCard() {
      try {
        const { data } = await axios.post(
          `/api/cards/${this.column.id}/add`,
          this.newCard
        );

        if (data.id) {
          await this.refreshCards();
        }
      } catch (error) {
        // Show UI error notification
      }

      this.newCard = { ...CARD_DATA };
      this.creating = false;
    },
  },
};
</script>
