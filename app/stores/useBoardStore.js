import { defineStore } from 'pinia';
import boardApi from './api/boardApi';

export const useBoardStore = defineStore('boards', {
  state: () => {
    return {
      boards: [],
    };
  },

  actions: {
    async getBoardList() {
      const { onResult } = await boardApi.getBoardList();

      onResult(({ data }) => {
        this.boards = data?.boards?.data;
      });
    },
  },
});
