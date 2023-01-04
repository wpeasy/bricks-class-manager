<template>
  <v-overlay v-model="classStore.isFetching" class="align-center justify-center" :close-on-back="false">
    <v-progress-circular
        indeterminate
        size="64"
        color="primary"
    ></v-progress-circular>
  </v-overlay>
  <v-toolbar color="secondary"  class="pa-2">
    <v-btn color="accent" @click="classStore.getData">Reload</v-btn>
    <v-btn color="accent" @click="classStore.save">Save</v-btn>
    <v-spacer></v-spacer>
    Active class count <v-chip color="accent">{{ classStore.getCount}}</v-chip>
  </v-toolbar>
  <SortableList/>
  <v-toolbar color="secondary"  class="pa-2">
    <v-btn color="accent" @click="classStore.getData">Reload</v-btn>
    <v-btn color="accent" @click="classStore.save">Save</v-btn>
    <v-spacer></v-spacer>
    Active class count <v-chip color="accent">{{ classStore.getCount}}</v-chip>
  </v-toolbar>
</template>

<script setup>
import {ref} from 'vue'
import {useGlobalClassStore} from "../stores/GlobalClasses.js"
import SortableList from "../components/SortableList/SortableList.vue";

const classStore = useGlobalClassStore()
const overlay = ref(true)

</script>

<style scoped>

</style>