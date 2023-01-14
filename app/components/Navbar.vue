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
