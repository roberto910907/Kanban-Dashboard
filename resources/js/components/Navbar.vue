<template>
  <div class="navbar">
    <div class="flex">
      <p class="grow">Kanban Board</p>
      <button class="button primary" @click="exportDatabase">
        Export Database
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Navbar',
  methods: {
    async exportDatabase() {
      try {
        const { data } = await axios.get('/api/export/database');

        if (data.file) {
          window.location = data.file;
        }
      } catch (error) {
        // Show UI error notification
      }
    },
  },
};
</script>
