<template>
  <div><h6>Click chips to copy</h6></div>
  <v-container fluid>
  <v-chip
      v-for="(className, index) in classes"
      :key="index"
      :color="color"
      class="ma-1 pointer"
      @click="onClick(className.name)"
  >
    .{{className.name}}
  </v-chip>
  </v-container>
</template>

<script setup>
import {useAppStateStore} from '../../stores/AppState.js'

defineProps({
  classes: {
    type: Array,
    required: true
  },
  color: {
    type: String,
    default: 'accent'
  }
})

const appStore = useAppStateStore()

const onClick = (name)=>{
  navigator.clipboard.writeText(name)
  appStore.showTimedNotice('Copied to clipboard')
}
</script>

<style scoped>

</style>