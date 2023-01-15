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

      <div
        v-if="!creating"
        class="bg-column cursor-pointer flex p-2.5 ml-3 rounded-md w-72 h-20 text-center"
        @click="creating = true"
      >
        <span
          class="w-full my-auto mx-auto px-4 py-1.5 text-blue-500 bg-gray-300 rounded-md hover:underline"
        >
          + Add new column
        </span>
      </div>
      <div v-else class="bg-column p-2.5 ml-3 rounded-md w-72 h-fit">
        <input
          v-model="newColumn.title"
          placeholder="Enter column title..."
          type="text"
          class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500"
          @keydown.enter="saveColumn"
        />

        <div class="flex mt-2">
          <button
            type="button"
            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            @click.prevent="saveColumn"
          >
            Save Column
          </button>
          <span
            class="cursor-pointer ml-2 p-2 my-auto text-blue-500 hover:bg-gray-300 hover:rounded-md"
            @click="creating = false"
          >
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
    const data = await useMyFetch('/api/columns/add', {
      method: 'POST',
      body: newColumn.value,
    });

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
