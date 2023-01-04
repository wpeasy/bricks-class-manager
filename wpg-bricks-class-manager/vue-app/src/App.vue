<template>
  <v-app >
    <Notices/>

    <v-card >
      <v-tabs
          v-model="tab"
          bg-color="primary"
          @update:modelValue="handleTabChange"

      >
        <v-tab value="active" color="accent" :transition="false">Active Classes</v-tab>
        <v-tab value="manage" color="accent"  :transition="false">Manage Sets</v-tab>
      </v-tabs>

      <v-card-text>
        <div v-show="tab === 'active'"><ActivePage/></div>
        <div v-show="tab === 'manage'"><ManagePage/></div>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script setup>
import {ref} from 'vue'
import ActivePage from "./views/ActivePage.vue";
import ManagePage from "./views/ManagePage.vue";
import {useGlobalClassStore} from './stores/GlobalClasses.js'
import {useImportedClassStore} from './stores/ImportedClasses.js'
import Notices from "./components/ui/Notices.vue";


const tab = ref(null)
const classStore = useGlobalClassStore()
const importedStore = useImportedClassStore()

const handleTabChange =  name =>{

  switch(name){
    case 'active':
      classStore.getData()
      break;

    case 'manage':
      importedStore.getData()
      break;
  }

}




</script>