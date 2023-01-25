<template>
  <div>
    <Navbar></Navbar>

    <div class="flex flex-row mt-1">
      <Column
        v-for="column in columns"
        :key="column.uuid"
        :column="column"
        @card-added="(card) => column.cards.push(card)"
      ></Column>

      <ModalDelete
        :open="openDeleteModal"
        @confirmed="columnStore.deleteColumn()"
        @close="openDeleteModal = false"
      ></ModalDelete>

      <ModalEdit
        :open="openEditModal"
        :item="editCard"
        @confirmed="cardStore.updateCard($event)"
        @close="cardStore.closeModal"
      ></ModalEdit>

      <NotificationSuccess
        :show="showNotification"
        title="Successfully Saved!"
        message="Card information has been updated."
        @close="showNotification = false"
      ></NotificationSuccess>

      <div
        v-if="!creating"
        class="bg-column cursor-pointer flex p-2.5 ml-3 rounded-md w-72 h-24 text-center"
        @click="creating = true"
      >
        <span
          class="bg-primary link w-full my-auto mx-auto rounded-md hover:underline !py-2"
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
          @keydown.enter="columnStore.createColumn()"
        />

        <div class="flex mt-2">
          <button
            type="button"
            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            @click.prevent="columnStore.createColumn()"
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
import { storeToRefs } from 'pinia';
import { useColumnStore } from '../../stores/useColumnStore';
import { useCardStore } from '../../stores/useCardStore';

const cardStore = useCardStore();
const columnStore = useColumnStore();

const { creating, columns, newColumn, openDeleteModal } =
  storeToRefs(columnStore);

const { editCard, openEditModal, showNotification } = storeToRefs(cardStore);

columnStore.getColumnList();
</script>
