<template>
  <div class="card">
    <span>{{ card.name }}</span>
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: {
    card: {
      type: Object,
      required: true,
    },
  },
};
</script>
