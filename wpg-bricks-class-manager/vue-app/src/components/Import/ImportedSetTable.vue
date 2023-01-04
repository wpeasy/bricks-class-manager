<template>
  <v-dialog
      v-model="viewSet"
      id="set-view"
      scrollable
      :scrim="false"
      fullscreen
  >
    <SetView @close-dialog="handleClose" :set-name="setName" :set-object="selectedSet" class="pl-10 pt-10"/>
  </v-dialog>
  <ConfirmDialog
      title="Are you sure"
      v-model="confirmDeleteOpen"
      @confirmed="doDelete()"
      @close-dialog="closeConfirm()"
  >
    <p>Are you sure you want to delete this set?</p>
    <p>Once deleted, it is removed from the database.</p>
  </ConfirmDialog>
  <div class="">Count: {{ importedClassStore.getCount }}</div>
  <v-table class="table--striped">
    <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Set</th>
      <th>Comment</th>
      <th>Original Source</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(item, key,index) in importedClassStore.sets" :key="index">
      <td>
        <v-row justify="space-between" align="center" class="gap1">
            <v-btn
                density="compact"
                color="accent"
                size="24"
                class="pa-1"
                @click="openView(key, item)"
            >
              <v-icon :icon="mdiEye"/>
            </v-btn>

            <v-btn
                density="compact"
                color="accent"
                size="24"
                class="pa-1"
                @click="handleDeleteSet(key)"
            >
              <v-icon :icon="mdiTrashCan"/>
            </v-btn>
        </v-row>

      </td>
      <td>{{ key }}</td>
      <td>{{ item.comment }}</td>
      <td>{{ item.original_src }}</td>
    </tr>
    </tbody>
  </v-table>
</template>

<script setup>
import {ref} from 'vue'
import {mdiTrashCan, mdiEye} from '@mdi/js'
import {useImportedClassStore} from "../../stores/ImportedClasses.js"
import SetView from "./SetView.vue";
import ConfirmDialog from "../ui/ConfirmDialog.vue";

const importedClassStore = useImportedClassStore()

const viewSet = ref(false)
const selectedSet = ref(null)
const setName = ref(null)
const confirmDeleteOpen = ref(false)

let setNameToDelete = '';

const openView = (name, obj) => {
  setName.value = name
  selectedSet.value = obj
  viewSet.value = true
  document.body.classList.remove('auto-fold')
  document.body.classList.add('folded')
}

const handleDeleteSet = setName => {
  confirmDeleteOpen.value = true
  setNameToDelete = setName
}
const closeConfirm = ()=>{
  confirmDeleteOpen.value = false
}
const doDelete = ()=>{
  confirmDeleteOpen.value = false
  importedClassStore.deleteSet(setNameToDelete)
      .then(
          ()=> {
            importedClassStore.getData()
            console.log('DELETED:' + setNameToDelete)
          }
      )
}

const handleClose = ()=>{
  viewSet.value = false
  document.body.classList.remove('folded')
  document.body.classList.add('auto-fold')
}

</script>

<style >


</style>