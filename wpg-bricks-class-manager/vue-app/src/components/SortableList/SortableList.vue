<template>
  <v-container>
    <v-card color="primary-darken-1">
      <div class="pa-2">
        <h4>Legend</h4>
        <v-table density="compact">
          <thead>
          <tr>
            <th class="text-left">L</th>
            <th class="text-left">Detection</th>
            <th class="text-left">Description</th>
          </tr>
          </thead>
          <tbody>
          <tr class="class-type-F">
            <td class="p-1"><span>F</span></td>
            <td class="p-1">
              <pre>Class starts with f-, x- </pre>
            </td>
            <td class="p-1">External Framework Utility</td>
          </tr>
          <tr class="class-type-BU">
            <td class="p-1"><span>BU</span></td>
            <td class="p-1">
              <pre>Class starts with b- </pre>
            </td>
            <td class="p-1">Bricks class system Utility</td>
          </tr>
          <tr class="class-type-B">
            <td class="p-1"><span>B</span></td>
            <td class="p-1">
              <pre>Class only has standard separator &quot;-&quot; </pre>
            </td>
            <td class="p-1">BLOCK</td>
          </tr>
          <tr class="class-type-E">
            <td class="p-1"><span>E</span></td>
            <td class="p-1">
              <pre>Class contains Element indicator &quot;__&quot; </pre>
            </td>
            <td class="p-1">ELEMENT</td>
          </tr>
          <tr class="class-type-M">
            <td class="p-1"><span>M</span></td>
            <td class="p-1">
              <pre>Class contains Modifier indicator &quot;--&quot; </pre>
            </td>
            <td class="p-1">MODIFIER</td>
          </tr>
          </tbody>
        </v-table>
      </div>
    </v-card>
  </v-container>
  <v-container id="class-list-wrapper">
    <div>
      <div>

        <div class="text-h6 builder-color--accent text-s" >Active List</div>
        <div id="active-list-container">

            <v-card color="primary-darken-1" class="pa-2" id="tempClassListWrapper" v-show="showTempList">
              <div class="text-h6 builder-color--accent text-s" >Temp List</div>
              <div class="pa-2 border-b-sm ">
                <VueDraggableNext
                    group="class-list"
                    id="tempClassList"
                    class="dragArea list-group w-full"
                    :list="classStore.tempClasses"
                    ghost-class="ghost"
                >
                  <ClassListItem
                      @click="handleItemClick(element)"
                      class="mb-1"
                      :class="{
                    ['class-type-' + getClassTag(element.name)]: true,
                    selected: element === selectedItem
                  }"
                      v-for="(element, index) in classStore.tempClasses"
                      :key="element.id"

                  >

                    <v-row justify="space-between"  align="center" class="ma-0">
                      <span>{{ index }}: <span class="badge">({{ element.set_name }})</span> {{ element.name }}</span>
                      <v-icon :icon="mdiCog" v-show="Object.keys(element.settings).length"/>
                    </v-row>
                  </ClassListItem>
                </VueDraggableNext>
              </div>
            </v-card>

          <VueDraggableNext

              group="class-list"
              id="active-class-list"
              class="dragArea list-group pa-2"
              :list="classStore.classes"
              @change="log"
              ghost-class="ghost"

          >
            <ClassListItem
                @click="handleItemClick(element)"
                :class="{
                    ['class-type-' + getClassTag(element.name)]: true,
                    selected: element === selectedItem
                  }"
                v-for="(element, index) in classStore.classes"
                :key="element.id"
            >
              <v-row justify="space-between"  align="center" class="ma-0">
                <span>{{ index }}: <span class="badge">({{ element.set_name }})</span> {{ element.name }}</span>
                <v-icon :icon="mdiCog" v-show="Object.keys(element.settings).length"/>
              </v-row>

            </ClassListItem>

          </VueDraggableNext>
        </div>
      </div>
    </div>

    <div>
      <div class="text-h6 builder-color--accent text-s" >Details</div>
      <div class="text-h6">
            <pre class="break-spaces">
              {{ JSON.stringify(selectedItem, null, "\t") }}
            </pre>
      </div>
    </div>
  </v-container>

</template>
<script setup>
import {onMounted, ref} from 'vue'

import * as ClassParser from '../../services/class-parser.js'
import ClassListItem from './ClassListItem.vue'
import {VueDraggableNext} from "vue-draggable-next";
import {useGlobalClassStore} from "../../stores/GlobalClasses.js"

/*icons */
import { mdiCog } from '@mdi/js'

const classStore = useGlobalClassStore()

const selectedItem = ref({})
const showTempList = ref(false)

const getClassTag = (val) => {
  return ClassParser.getClassTag(val);
}

const handleItemClick = (e) => {
  selectedItem.value = e;
}

/*
Show temp list after scrolling
 */
const scrollPxForTempList = 250

window.addEventListener('scroll', e => {
  if(window.scrollY > scrollPxForTempList && showTempList.value === false){
    showTempList.value = true
    console.log('>', window.scrollY, showTempList.value )
  }else if(window.scrollY < scrollPxForTempList && showTempList.value === true){
    showTempList.value = false
    console.log('<', window.scrollY, showTempList.value )
  }
})
</script>

<style scoped>
#class-list-wrapper {
  position: relative;
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
}

#active-list-container{
  position: relative;

}

#tempClassListWrapper{
  width: 300px;
  position: fixed;
  z-index: 10000;
  top: 100px;
  left: 200px;
}
#tempClassList {
  min-height: 50px;

  border: 1px solid var(--builder-color-accent);

}

#active-class-list {
  border: 1px solid var(--builder-color-accent);
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-auto-flow: row;
  gap: 5px;
  max-height: 70vh;
  overflow: auto;
}


.list-group-item.selected {
  border: 2px solid var(--builder-color-accent);
  scale: 1.06;
  transition: scale 0.3s ease-out;
}


.ghost {
  background: goldenrod !important;
  color: black !important;
}

.class-list {
  max-height: 70vh;
  overflow-y: scroll;
}


.list-group-item:hover {
  cursor: move;
}
</style>