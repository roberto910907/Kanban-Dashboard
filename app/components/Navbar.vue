<template>
  <div class="navbar bg-navbar px-4 py-3">
    <div class="flex">
      <p class="grow text-white m-0 text-xl">Kanban Board</p>
      <button
        type="button"
        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        :disabled="creating"
        @click="exportDatabase"
      >
        <Spinner v-if="creating" class="mr-1"></Spinner>
        {{ exportButtonText }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useMyFetch } from '../composables/baseFetch';

const creating = ref(false);

const exportButtonText = computed(() => {
  return creating.value ? 'Exporting...' : 'Export Database';
});

async function exportDatabase() {
  creating.value = true;

  try {
    const { data } = await useMyFetch('/api/export/database');

    if (data.file) {
      window.location = data.file;
    }
  } catch (error) {
    // Show UI error notification
  }

  creating.value = false;
}
</script>
