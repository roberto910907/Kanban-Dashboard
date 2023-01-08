<template>
  <div class="column">
    <span>{{ column.title }}</span>

    <Card v-for="card in column.cards" :key="card.id" :card="card"></Card>

    <div @click="addCard">
      <span>+ Add new card</span>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Card from './Card.vue';

export default {
  name: 'Column',
  components: { Card },
  props: {
    column: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      newCard: {
        name: 'New Card!!',
      },
    };
  },

  methods: {
    async refreshCards() {
      try {
        const { data } = await axios.get(`/api/cards/${this.column.id}/list`);

        this.column.cards = data.cards; // TODO: Refactor this with a emitted event
      } catch (error) {
        // Show UI error notification
      }
    },

    async addCard() {
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
    },
  },
};
</script>
