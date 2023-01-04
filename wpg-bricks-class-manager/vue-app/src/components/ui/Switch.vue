<template>

    <label class="switch">
      <input type="checkbox" v-model="currentState" @click="$emit('switchChange', !currentState)">
      <div class="slider round"></div>
    </label>

</template>

<script setup>
import {onMounted, ref} from 'vue'
const currentState = ref( false )

const props = defineProps(
    {
      'labelEnabled' :{
        type: String,
        required: true
      },

      'labelDisabled' :{
        type: String,
        required: true
      },

      'initialState' :{
        type: Boolean,
        required: true
      }
  }
)

onMounted(()=>{
 currentState.value = props.initialState
})

</script>

<style scoped>

</style>