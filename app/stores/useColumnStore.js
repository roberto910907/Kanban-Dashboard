import { defineStore } from 'pinia';
import columnApi from './api/columnApi';

export const useColumnStore = defineStore('columns', {
  data: () => {
    return {
      columns: [],
    };
  },

  actions: {
    async getColumnList() {
      const route = useRoute();

      const { onResult } = await columnApi.getColumnList(route.params.id);

      onResult(({ data }) => {
        this.columns = data?.columns?.data;
      });
    },
  },
});
