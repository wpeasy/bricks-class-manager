<template>
  <v-dialog
      persistent
      max-width="350px"
  >
    <v-card density="compact" >
      <v-card-title >{{ title }}</v-card-title>
      <v-card-text>
        <slot/>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="$emit('confirmed', Math.random())">Yes</v-btn>
        <v-btn @click="$emit('close-dialog', Math.random())">no</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>

defineProps(['title'])
</script>

<style scoped>

</style>