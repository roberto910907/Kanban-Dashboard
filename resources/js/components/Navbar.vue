<template>
  <div class="navbar">
    <div class="flex">
      <p class="grow">Kanban Board</p>
      <button
        class="button primary"
        :disabled="creating"
        @click="exportDatabase"
      >
        <Spinner v-if="creating" class="mr-1"></Spinner>
        {{ exportButtonText }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Spinner from './Spinner.vue';

export default {
  name: 'Navbar',
  components: { Spinner },
  data() {
    return {
      creating: false,
    };
  },

  computed: {
    exportButtonText() {
      return this.creating ? 'Exporting...' : 'Export Database';
    },
  },

  methods: {
    async exportDatabase() {
      this.creating = true;

      try {
        const { data } = await axios.get('/api/export/database');

        if (data.file) {
          window.location = data.file;
        }
      } catch (error) {
        // Show UI error notification
      }

      this.creating = false;
    },
  },
};
</script>
