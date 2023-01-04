<template>
  <LoadingOverlay v-show="fetchingStyles" />
  <table >
    <thead>
    <tr>
      <th>Set</th>
      <th>Comment</th>
      <th>Original SRC</th>
      <th>Enabled</th>
      <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(value, key) in importedStyles" :key="key" >
      <td>{{ key }}</td>
      <td>{{ value.comment }}</td>
      <td>{{ value.original_src }}</td>
      <td>

      </td>
      <td>
        TEST

      </td>
    </tr>
    </tbody>
  </table>
</template>

<script setup>
import {ref} from 'vue'

import LoadingOverlay from "../ui/LoadingOverlay.vue";

const importedStyles = ref([])
const fetchingStyles = ref(false)





</script>

<style scoped>

</style>