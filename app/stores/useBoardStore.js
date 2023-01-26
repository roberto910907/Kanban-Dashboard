import { defineStore } from 'pinia';
import boardApi from './api/boardApi';

const BOARD_DATA = {
  name: '',
  is_private: true,
};

export const useBoardStore = defineStore('boards', {
  state: () => {
    return {
      boards: [],
      newBoard: { ...BOARD_DATA },
      openEditModal: false,
    };
  },

  actions: {
    showEditModal() {
      this.openEditModal = true;
    },

    closeModal() {
      this.openEditModal = false;
    },

    async getBoardList() {
      const { onResult } = await boardApi.getBoardList();

      onResult(({ data }) => {
        this.boards = useCloneDeep(data?.boards?.data);
      });
    },

    async createBoard() {
      const { mutate, onDone } = await boardApi.createBoard(this.newBoard);

      mutate();

      this.newBoard = { ...BOARD_DATA };

      onDone(({ data }) => {
        this.boards.push(useCloneDeep(data.createBoard));
      });

      this.closeModal();
    },

    async deleteBoard(boardId) {
      const { mutate, onDone } = await boardApi.deleteBoard(boardId);

      mutate();

      onDone(({ data }) => {
        this.boards = this.boards.filter(
          (board) => board.uuid !== data.deleteBoard.uuid
        );
      });
    },
  },
});
