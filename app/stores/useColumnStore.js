import { defineStore } from 'pinia';
import columnApi from './api/columnApi';

const COLUMN_DATA = {
  title: '',
  board_id: '',
};

export const useColumnStore = defineStore('columns', {
  state: () => {
    return {
      columns: [],
      creating: false,
      columnIdToDelete: '',
      openDeleteModal: false,
      newColumn: { ...COLUMN_DATA },
    };
  },

  actions: {
    async getColumnList() {
      const route = useRoute();

      const { onResult } = await columnApi.getColumnList(route.params.id);

      onResult(({ data }) => {
        const columns = data?.columns?.data;

        this.columns = useCloneDeep(columns);
      });
    },

    async createColumn() {
      const route = useRoute();

      this.creating = true;
      this.newColumn.board_id = route.params.id;

      const { mutate, onDone } = await columnApi.createColumn(this.newColumn);

      mutate();

      onDone(({ data }) => {
        this.columns = this.columns.concat({ ...data.createColumn });
      });

      this.creating = false;
      this.newColumn = { ...COLUMN_DATA };
    },

    showDeleteModal(columnId) {
      this.openDeleteModal = true;
      this.columnIdToDelete = columnId;
    },

    addCardToColumn(columnId, newCard, position = null) {
      const column = this.columns.find((column) => column.uuid === columnId);

      if (column) {
        if (position) {
          column.cards.splice(position, 0, newCard);
        } else {
          column.cards.push(useCloneDeep(newCard));
        }
      }
    },

    removeCardFromColumn(columnId, cardPosition) {
      const column = this.columns.find((column) => column.uuid === columnId);

      column.cards.splice(cardPosition, 1);
    },

    async deleteColumn() {
      const { mutate, onDone } = await columnApi.deleteColumn(
        this.columnIdToDelete
      );

      mutate();

      onDone(({ data }) => {
        this.columns = this.columns.filter(
          (column) => column.uuid !== data.deleteColumn.uuid
        );
      });

      this.openDeleteModal = false;
    },
  },
});
