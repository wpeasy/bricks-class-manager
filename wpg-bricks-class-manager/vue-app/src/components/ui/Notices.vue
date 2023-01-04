<template>
  <v-snackbar
      v-model="appStore.showTimedNoticeFlag"
      :timeout="appStore.timeout"
      location="center"
      color="success"
  >
    {{ appStore.timedNoticeMessage }}
  </v-snackbar>
</template>

<script setup>
import {useAppStateStore} from '../../stores/AppState.js'
const appStore = useAppStateStore()

</script>

<style scoped>

</style>