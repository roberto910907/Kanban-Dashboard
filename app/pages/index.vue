<template>
  <div>
    <Navbar></Navbar>

    <div class="flex flex-row mt-1">
      <Column
        v-for="column in columns"
        :key="column.id"
        :column="column"
        @column-updated="(cards) => (column.cards = cards)"
        @delete-triggered="showDeleteModal($event)"
      ></Column>

      <ModalDelete
        :open="openDeleteModal"
        :item-id="columnIdToDelete"
        @confirmed="deleteColumn($event)"
        @close="openDeleteModal = false"
      ></ModalDelete>

      <div
        v-if="!creating"
        class="bg-column cursor-pointer flex p-2.5 ml-3 rounded-md w-72 h-20 text-center"
        @click="creating = true"
      >
        <span
          class="bg-primary link w-full my-auto mx-auto rounded-md hover:underline"
        >
          + Add New Column
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
import { useMyFetch } from '../composables/baseFetch';

const COLUMN_DATA = {
  title: '',
};

const creating = ref(false);
const columns = ref([]);
const openDeleteModal = ref(false);
const columnIdToDelete = ref(0);
const newColumn = ref({ ...COLUMN_DATA });

function showDeleteModal(columnId) {
  columnIdToDelete.value = columnId;
  openDeleteModal.value = true;
}

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

async function deleteColumn(columnId) {
  await useMyFetch(`/api/columns/${columnId}/delete`, {
    method: 'DELETE',
  });

  openDeleteModal.value = false;

  await getColumnList();
}

getColumnList();
</script>
