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
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import { useBoardStore } from '../../stores/useBoardStore';

const store = useBoardStore();

const { boards } = storeToRefs(store);

store.getBoardList();
</script>
