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
const boards = ref([]);

async function getBoardList() {
  const data = await useMyFetch('/api/boards/list');

  boards.value = data.boards;
}

getBoardList();
</script>
