<template>
  <div class="tab-content" v-show="title == selectedTitle">
    <slot></slot>
  </div>
</template>

<script setup>
import {inject,defineProps} from 'vue'

defineProps(['title'])
const selectedTitle = inject('selectedTitle');
</script>

<style scoped>

</style>