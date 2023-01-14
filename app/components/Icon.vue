<template>
  <svg
      :width="iconSize.width"
      :height="iconSize.height"
      :viewBox="`0 0 ${iconSize.width} ${iconSize.height}`"
      xmlns="http://www.w3.org/2000/svg"
      v-bind="$attrs"
      v-html="iconSvg"
  ></svg>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  iconName: {
    type: String,
    required: true,
  },

  iconColor: {
    type: String,
    default: '',
    required: false,
  },

  iconSize: {
    type: Object,
    required: false,
    default: () => {
      return {
        width: 24,
        height: 24,
      };
    },
  },

  iconTitle: {
    type: String,
    required: false,
  },
});

const iconSvg = ref('');

async function getIconSvg() {
  const { icon } = await import(`./icons/${props.iconName}.js`);

  iconSvg.value = icon;
}

getIconSvg();
</script>
