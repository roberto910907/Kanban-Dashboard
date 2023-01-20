<template>
  <div class="card ml-2">
    <div class="flex flex-1 flex-col p-8">
      <h3 class="mt-6 text-sm font-medium text-gray-900">
        {{ props.board.name }}
      </h3>
      <dl class="mt-1 flex flex-grow flex-col justify-between">
        <dd class="text-sm text-gray-500">{{ props.board.uuid }}</dd>
      </dl>
    </div>
    <div>
      <div class="-mt-px flex divide-x divide-gray-200">
        <div class="flex w-0 flex-1">
          <a
            class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
          >
            <EnvelopeIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            <span class="ml-3">Email</span>
          </a>
        </div>
        <div class="-ml-px flex w-0 flex-1">
          <NuxtLink
            :to="`/boards/${props.board.uuid}`"
            class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
          >
            <PhoneIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            <span class="ml-3">Open Dashboard</span>
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
  board: {
    type: Object,
    required: true,
  },
});
</script>
