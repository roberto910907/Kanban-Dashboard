<template>
  <div
    aria-live="assertive"
    class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6"
  >
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
      <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="props.show"
          class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
        >
          <div class="p-4 bg-green-50">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <Icon
                  name="heroicons:check-circle"
                  class="h-12 w-12 text-green-400"
                />
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-bold text-gray-900">
                  {{ props.title }}
                </p>
                <p class="mt-1 text-sm text-gray-500">
                  {{ props.message }}
                </p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button
                  type="button"
                  class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  @click="closeNotification"
                >
                  <Icon
                    name="heroicons:x-mark-solid"
                    class="h-5 w-5 bg-green-50"
                  />
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script setup>
const emit = defineEmits(['close']);

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },

  title: {
    type: String,
    required: true,
  },

  message: {
    type: String,
    required: false,
    default: '',
  },
});

function closeNotification() {
  emit('close');
}

setTimeout(closeNotification, 5000);
</script>
