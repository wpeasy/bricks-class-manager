<template>
  <v-app >
    <v-overlay v-model="store.isFetching" class="align-center justify-center" :close-on-back="false">
      <v-progress-circular
          indeterminate
          size="64"
          color="primary"
      ></v-progress-circular>
    </v-overlay>
    <v-card >
      <v-tabs
          v-model="tab"
          bg-color="primary"
          @update:modelValue="handleTabChange"
      >
        <v-tab value="imported-sets" color="accent" :transition="false">Imported Sets</v-tab>
        <v-tab value="import" color="accent"  :transition="false">Import</v-tab>
      </v-tabs>

      <v-card-text>
        <div v-show="tab === 'imported-sets'">
          <ImportedSetTable />
        </div>
        <div v-show="tab === 'import'">
          <ImportSet/>
        </div>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script setup>
import {ref} from "vue";
import {useImportedClassStore} from "../stores/ImportedClasses.js"
import ImportedSetTable from "../components/Import/ImportedSetTable.vue";
import ImportSet from "../components/Import/ImportSet.vue";
const store = useImportedClassStore()

const tab = ref(null)
const handleTabChange =  name =>{
  if(name === 'imported-sets'){
    store.getData()
  }
}
</script>

<style scoped>

</style>