<template>
  <svg
    :width="iconSize.width"
    :height="iconSize.height"
    :viewBox="`0 0 ${iconSize.width} ${iconSize.height}`"
    xmlns="http://www.w3.org/2000/svg"
    v-bind="$attrs"
    v-on="$listeners"
    v-html="iconSvg"
  ></svg>
</template>

<script>
export default {
  name: 'Icon',
  props: {
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
          width: 16,
          height: 16,
        };
      },
    },

    iconTitle: {
      type: String,
      required: false,
    },
  },

  data() {
    return {
      iconSvg: '',
      isLoading: true,
    };
  },

  created() {
    this.getIconSvg();
  },

  methods: {
    getIconSvg() {
      import(`../icons/${this.iconName}.js`).then(({ icon }) => {
        this.iconSvg = icon;
      });
    },
  },
};
</script>
