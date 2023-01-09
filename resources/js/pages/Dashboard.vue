<template>
  <div>
    <Navbar></Navbar>

    <div class="flex flex-row mt-1">
      <Column
        v-for="column in columns"
        :key="column.id"
        :column="column"
        @column-updated="(cards) => (column.cards = cards)"
        @column-deleted="getColumnList"
      ></Column>

      <div v-if="!creating" class="column h-60" @click="creating = true">
        <p class="text-center">+ Add new column</p>
      </div>
      <div v-else class="column h-60">
        <input
          v-model="newColumn.title"
          placeholder="Enter column title..."
          type="text"
          @keydown.enter="saveColumn"
        />

        <div class="flex mt-1">
          <button @click.prevent="saveColumn">Save Column</button>
          <span class="cursor-pointer ml-1" @click="creating = false">
            Cancel
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from '../components/Navbar.vue';
import Column from '../components/Column.vue';

const COLUMN_DATA = {
  title: '',
};

export default {
  name: 'Dashboard',
  components: { Navbar, Column },
  data() {
    return {
      columns: [],
      creating: false,
      newColumn: { ...COLUMN_DATA },
    };
  },

  created() {
    this.getColumnList();
  },

  methods: {
    async getColumnList() {
      try {
        const { data } = await axios.get('/api/columns/list');

        this.columns = data.columns;
      } catch (error) {
        // Show user UI error notification
      }
    },

    async saveColumn() {
      try {
        const { data } = await axios.post('/api/columns/add', this.newColumn);

        // Column successfully created
        if (data.id) {
          await this.getColumnList();
        }
      } catch (error) {
        // Show user UI error notification
      }

      this.newColumn = { ...COLUMN_DATA };
      this.creating = false;
    },
  },
};
</script>
