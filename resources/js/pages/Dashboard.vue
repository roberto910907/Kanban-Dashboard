<template>
  <div>
    <Navbar></Navbar>

    <div class="flex flex-row mt-1">
      <Column
        v-for="column in columns"
        :key="column.id"
        :column="column"
      ></Column>

      <div class="column h-60" @click="addColumn">
        <p class="text-center">+ Add new column</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from '../components/Navbar.vue';
import Column from '../components/Column.vue';

export default {
  name: 'Dashboard',
  components: { Navbar, Column },
  data() {
    return {
      columns: [],
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

    async addColumn() {
      try {
        const { data } = await axios.post('/api/columns/add', {
          title: 'New Column',
        });

        // Column successfully created
        if (data.id) {
          await this.getColumnList();
        }
      } catch (error) {
        // Show user UI error notification
      }
    },
  },
};
</script>
