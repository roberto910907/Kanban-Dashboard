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

    <Modal :name="modalCardId">
      <div class="pa-30">
        <div class="title">Card Information (#{{ card.id }})</div>
        <div class="mt-1">
          <input
            v-model="card.title"
            placeholder="Enter card title..."
            type="text"
            class="form-control w-full h-36"
          />
        </div>
        <div class="mt-1">
          <textarea
            v-model="card.description"
            rows="5"
            placeholder="Card description..."
            class="form-control w-full"
          ></textarea>
        </div>
        <div class="flex mt-1">
          <button class="button primary" @click="updateCard">
            Update Card
          </button>
          <span class="cursor-pointer ml-1 link" @click="closeModal">
            Cancel
          </span>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Card',
  props: {
    card: {
      type: Object,
      required: true,
    },
  },

  computed: {
    modalCardId() {
      return `modal_card_${this.card.id}`;
    },
  },

  methods: {
    openEditModal() {
      this.$modal.show(this.modalCardId);
    },

    async updateCard() {
      try {
        const { data } = await axios.put(
          `/api/cards/update/${this.card.id}`,
          this.card
        );

        if (data.status === 'success') {
          this.closeModal();
        }
      } catch (error) {
        // Show user UI error notification
      }
    },

    closeModal() {
      this.$modal.hide(this.modalCardId);
    },
  },
};
</script>
