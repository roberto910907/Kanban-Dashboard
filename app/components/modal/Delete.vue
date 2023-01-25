<template>
  <TransitionRoot as="template" :show="props.open">
    <Dialog as="div" class="relative z-10" @close="emit('close')">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                  <span
                    class="bg-white text-gray-400 hover:text-gray-600"
                    @click="emit('close')"
                  >
                    <Icon name="heroicons:x-mark-solid" class="h-6 w-6" />
                  </span>
                </div>
                <div class="sm:flex sm:items-start">
                  <div
                    class="mx-auto flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-red-100"
                  >
                    <Icon
                      name="heroicons:exclamation-triangle"
                      class="h-14 w-14 text-red-600"
                    />
                  </div>
                  <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <DialogTitle as="h3" class="text-lg font-bold leading-6">
                      Delete Column
                    </DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-600">
                        Are you sure you want to delete the column? All the
                        related cards will be removed.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-gray-100 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
              >
                <button
                  type="button"
                  class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                  @click="emit('confirmed')"
                >
                  Delete
                </button>
                <button
                  ref="cancelButtonRef"
                  type="button"
                  class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                  @click="emit('close')"
                >
                  Cancel
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';

const emit = defineEmits(['close', 'confirmed']);

const props = defineProps({
  open: {
    required: true,
    type: Boolean,
  },
});
</script>
