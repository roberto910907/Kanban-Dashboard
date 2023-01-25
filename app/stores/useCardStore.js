import { defineStore } from 'pinia';
import cardApi from './api/cardApi';
import { useColumnStore } from './useColumnStore';

const CARD_DATA = {
  title: '',
};

export const useCardStore = defineStore('cards', {
  state: () => {
    return {
      creating: false,
      openEditModal: false,
      showNotification: false,
      newCard: { ...CARD_DATA },
      editCard: { ...CARD_DATA },
    };
  },

  actions: {
    showEditModal(card) {
      this.editCard = card;
      this.openEditModal = true;
    },

    closeModal() {
      this.openEditModal = false;
    },

    getCardList(columnUuid) {
      return cardApi.getCardList(columnUuid);
    },

    async createCard(columnUuid) {
      const columnStore = useColumnStore();

      this.newCard.column_id = columnUuid;

      const { mutate, onDone } = await cardApi.createCard(this.newCard);

      mutate();

      this.newCard = { ...CARD_DATA };

      onDone(({ data }) => {
        columnStore.addCardToColumn(columnUuid, data.createCard);
      });
    },

    async updateCard(updateCard) {
      const { mutate, onDone } = await cardApi.updateCard(updateCard);

      mutate();

      onDone(({ data }) => {
        this.openEditModal = false;
        this.showNotification = true;
        this.editCard = { ...CARD_DATA };
      });
    },

    async updateCardPosition(dragEvent) {
      const columnStore = useColumnStore();

      const cardId = dragEvent.item.id.split('_')[1];
      const columnId = dragEvent.to.id.split('_')[1];
      const newPosition = dragEvent.newIndex;
      const previousPosition = dragEvent.oldIndex;

      const { mutate, onDone } = await cardApi.updateCardPosition({
        id: cardId,
        position: newPosition,
      });

      mutate();

      onDone(({ data }) => {
        columnStore.removeCardFromColumn(columnId, previousPosition);
        columnStore.addCardToColumn(
          columnId,
          data.updateCardPosition,
          newPosition
        );
      });
    },

    async updateCardColumn(dragEvent) {
      const columnStore = useColumnStore();

      const cardId = dragEvent.item.id.split('_')[1];
      const oldColumnId = dragEvent.from.id.split('_')[1];
      const newColumnId = dragEvent.to.id.split('_')[1];
      const newPosition = dragEvent.newIndex;
      const previousPosition = dragEvent.oldIndex;

      const { mutate, onDone } = await cardApi.updateCardColumn({
        id: cardId,
        column_id: newColumnId,
        position: newPosition,
      });

      mutate();

      onDone(({ data }) => {
        columnStore.removeCardFromColumn(oldColumnId, previousPosition);
        columnStore.addCardToColumn(
          newColumnId,
          data.updateCardColumn,
          newPosition
        );
      });
    },
  },
});
