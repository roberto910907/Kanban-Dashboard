<template>
  <div class="bg-column h-screen">
    <Navbar></Navbar>

    <div class="flex flex-row mt-1">
      <BoardCard
        v-for="board in boards"
        :key="board.uuid"
        :board="board"
      ></BoardCard>
    </div>

    <BoardModalEdit
      :open="openEditModal"
      :item="newBoard"
      @close="store.closeModal"
      @confirmed="store.createBoard"
    ></BoardModalEdit>

    <button
      class="ml-4 mt-4 bg-sky-500 hover:bg-sky-700 px-5 py-2.5 text-sm leading-5 rounded-md font-semibold text-white"
      @click.prevent="store.showEditModal()"
    >
      + Add New Dashboard
    </button>
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import { useBoardStore } from '../../stores/useBoardStore';

const store = useBoardStore();

const { boards, newBoard, openEditModal } = storeToRefs(store);

store.getBoardList();
</script>
