<template>
  <div
    class="fixed bottom-0 right-0 py-1.5 px-3 bg-black text-white text-lg z-9999"
    v-if="dev"
  >
    <span>Current breakpoint: </span>
    <span class="sm:hidden md:hidden lg:hidden xl:hidden font-bold font">&lt; sm</span>
    <span class="hidden sm:inline md:hidden font-bold font">sm</span>
    <span class="hidden md:inline lg:hidden font-bold font">md</span>
    <span class="hidden lg:inline xl:hidden font-bold font">lg</span>
    <span class="hidden xl:inline 2xl:hidden font-bold font">xl</span>
    <span class="hidden 2xl:inline 3xl:hidden font-bold font">2xl</span>
    <span class="hidden 3xl:inline font-bold font">3xl</span>
  </div>
</template>

<script setup>
// https://vitejs.dev/guide/env-and-mode.html#env-variables
const dev = import.meta.env.DEV
</script>
