<template>
  <div :id="`card_${card.id}`" class="card">
    <span>{{ card.title }}</span>
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
