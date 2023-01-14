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
        <p class="text-center link">+ Add new column</p>
      </div>
      <div v-else class="column h-90">
        <input
            v-model="newColumn.title"
            placeholder="Enter column title..."
            type="text"
            class="form-control h-36"
            @keydown.enter="saveColumn"
        />

        <div class="flex mt-1">
          <button class="button primary" @click.prevent="saveColumn">
            Save Column
          </button>
          <span class="cursor-pointer ml-1 link" @click="creating = false">
            Cancel
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useMyFetch } from '../composables/baseFetch';

const COLUMN_DATA = {
  title: '',
};

const creating = ref(false);
const columns = ref([]);
const newColumn = ref(COLUMN_DATA);

async function getColumnList() {
  const data = await useMyFetch('/api/columns/list');

  columns.value = data.columns;
}

async function saveColumn() {
  try {
    const data = await useMyFetch('/api/columns/add', { method: 'POST', body: newColumn.value });

    // Column successfully created
    if (data.id) {
      await getColumnList();
    }
  } catch (error) {
    // Show user UI error notification
  }

  newColumn.value = { ...COLUMN_DATA };
  creating.value = false;
}

getColumnList();
</script>
