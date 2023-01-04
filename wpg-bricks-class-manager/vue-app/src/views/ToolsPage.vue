<template>
  <v-toolbar >
    <button @click="toggleBricksModal">Delete All Bricks Globals</button>
    <button @click="toggleBricksModal">Delete All Imported CSS</button>
  </v-toolbar>

</template>

<script setup>

import {ref} from 'vue'
import REST_Client from "../services/REST_Client.js";

const bricksGlobalsModalActive = ref(false);

const toggleBricksModal = ()=>{
  bricksGlobalsModalActive.value = ! bricksGlobalsModalActive.value;
}

const closeBricksModal = ()=>{
  bricksGlobalsModalActive.value = false;
}

const deleteBricksGlobals = ()=>{
  closeBricksModal();
  REST_Client.get('delete_bricks_globals')
  .catch(error => console.log(error))
}

</script>

<style scoped>

</style>