<template>
  <div class="tabs w-full">
    <ul class="nav nav-tabs flex  list-none border-b-0 pl-0" id="wpg-tabs-tab"
        role="tablist">
      <li v-for="title in tabTitles"
          :key="title"
          @click="onTabChange(title)"
          class="
            nav-link
            "
          :class="{ active: title == selectedTitle}"
      >
        {{ title }}
      </li>
    </ul>
    <slot/>
  </div>
</template>

<script setup>
import {ref, provide, useSlots, defineEmits} from 'vue';
const slots = useSlots()
const tabTitles = ref(slots.default().map( tab => tab.props.title))
const selectedTitle = ref(tabTitles.value[0])
provide('selectedTitle', selectedTitle)


const onTabChange = (title)=>{
  selectedTitle.value = title
  window.dispatchEvent( new CustomEvent('bcm:tabChanged', { detail: title}))
}

</script>

<style >

</style>