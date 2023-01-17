<template>
  <div class="navbar bg-navbar px-4 py-3">
    <div class="flex">
      <p class="grow text-white m-0 text-xl">Kanban Board</p>
      <button
        type="button"
        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        @click="openRegisterModal"
      >
        Create Account
      </button>
    </div>
  </div>
</template>

<script setup>
async function openRegisterModal() {}
</script>
