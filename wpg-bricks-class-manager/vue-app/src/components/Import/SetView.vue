<template>
  <v-card>
    <v-card-title>
      <v-btn @click="$emit('closeDialog')">Close</v-btn>
      <v-tabs
          v-model="tab"
          bg-color="primary"
          @update:modelValue="handleChange"

      >
        <v-tab value="classes" color="accent" :transition="false">Classes</v-tab>
        <v-tab value="variables" color="accent" :transition="false">Variables</v-tab>
        <v-tab value="original" color="accent" :transition="false">Original</v-tab>

      </v-tabs>
    </v-card-title>
    <v-card-text>
      <div v-show="tab === 'classes'">
        <div class="pa-2">
          <h3 class="builder-color--accent">Set Name: {{ setName }}</h3>
          <h4 class="builder-color--accent">Source: {{ setObject.original_src }}</h4>
        </div>
        <v-container fluid class="d-flex flex-row gap1">
          <v-switch
              v-model="setObject.status.enabled"
              color="accent"
              density="compact"
              label="Enable"
              hide-details
              class="flex-grow-0"
              @change="updateStatus(setName,setObject.status)"
          />

          <!--
          <v-switch
              v-show="setObject.status.enabled"
              v-model="setObject.status.local"
              color="accent"
              density="compact"
              label="Host Locally"
              hide-details
              class="flex-grow-0"
              @change="updateStatus(setName,setObject.status)"
          />

          <v-switch
              v-show="setObject.status.enabled"
              v-model="setObject.status.enqueue"
              color="accent"
              density="compact"
              label="Auto Enqueue"
              hide-details
              class="flex-grow-0"
              @change="updateStatus(setName,setObject.status)"
          />
          -->
        </v-container>
        <v-container>
          <h3 class="builder-color--accent">Classes</h3>
          <ClassChips :classes="setObject.classes"/>
        </v-container>
      </div>
      <div v-show="tab === 'variables'">
        <v-container>
          <h3 class="builder-color--accent">Variables</h3>
          <VariableChips :classes="setObject.vars"/>
        </v-container>
      </div>
      <div v-show="tab === 'original'">
        Original TBA
      </div>
    </v-card-text>
  </v-card>
</template>

<script setup>
import {ref} from "vue";
import {useAppStateStore} from '../../stores/AppState.js'
import {useImportedClassStore} from '../../stores/ImportedClasses.js'
import ClassChips from "../ui/ClassChips.vue";
import VariableChips from "../ui/VariableChips.vue";

const appStore = useAppStateStore()
const importedStore = useImportedClassStore()

defineProps({
  "setName": {
    type: String,
    required: true
  },
  "setObject": {
    type: Object,
    required: true
  }
})

const tab = ref(null)

const copyToClipboard = name => {
  navigator.clipboard.writeText(name)
  appStore.showTimedNotice('Copied to Clipboard')
}

const updateStatus = (setName, status) => {
  importedStore.updateStatus(setName, status)
      .then(
          () => {
            console.log('OK')
          },
          () => {
            console.log('not OK')
          }
      )
}

const handleChange = name => {
  if( name === ''){

  }
}
</script>

<style scoped>

</style>