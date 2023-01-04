<template>
  <v-overlay v-model="classStore.isFetching" class="align-center justify-center" :close-on-back="false">
    <v-progress-circular
        indeterminate
        size="64"
        color="primary"
    ></v-progress-circular>
  </v-overlay>
 <v-alert color="accent">
   <h4>Note: for these variables to be available the CSS must be enqueued in WordPress.</h4>
   <p>Disabled sets will only affect the display of class sets in Bricks Globals.</p>
   <p>Variables will always be available for CSS enqueued in WordPress</p>
 </v-alert>

  <v-container fluid v-for="(obj,set,index) in classStore.sets" :key="index">
    <h4 class="builder-color--accent">Set Name: {{ set }}</h4>
    <VariableChips :classes="obj.vars"/>
  </v-container>
</template>

<script setup>
import {ref} from 'vue'
import {useImportedClassStore} from "../stores/ImportedClasses.js"
import VariableChips from "../components/ui/VariableChips.vue";

const classStore = useImportedClassStore()
const overlay = ref(true)

</script>

<style scoped>

</style>