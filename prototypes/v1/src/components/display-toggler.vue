<template>
  <slot
    v-bind:display="display"
    v-bind:toggle="toggle"
  />
</template>

<script setup>
import { ref } from 'vue'

const display = ref(false)

function toggle () {
  // Toggle the value.
  display.value = !display.value
}
</script>
