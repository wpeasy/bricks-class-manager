<template>
  <v-form v-model="valid">
    <v-container>
      <v-row>
        <v-col
            cols="12"
            md="5"
        >
          <v-text-field
              color="accent"
              bg-color="primary"
              variant="outlined"
              v-model="url"
              :rules="urlRules"
              label="URL"
              required
          ></v-text-field>
        </v-col>

        <v-col
            cols="12"
            md="3"
        >
          <v-text-field
              v-model="comment"
              color="accent"
              bg-color="primary"
              variant="outlined"
              :rules="commentRules"
              label="Comment"
              required
          ></v-text-field>
        </v-col>

        <v-col
            cols="12"
            md="3"
        >
          <v-text-field
              v-model="set_name"
              color="accent"
              bg-color="primary"
              variant="outlined"
              :rules="setNameRules"
              label="Set Name"
              required
          ></v-text-field>
        </v-col>
        <v-col
            cols="12"
            md="1"
        >
          <v-btn color="accent" @click="fetchURL" :disabled="!valid">Fetch URL</v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>

  <v-container fluid>

    <v-row>
      <v-col
          cols="12"
      >
        <h3 class="builder-color--accent">Classes</h3>
        <ClassChips :classes="Object.values(parsedResult)[0].classes"/>
      </v-col>

    </v-row>
    <v-row>
      <v-col
          cols="12"
      >
        <h3 class="builder-color--accent">Variables</h3>
        <VariableChips :classes="Object.values(parsedResult)[0].vars"/>
      </v-col>


    </v-row>
  </v-container>
  <v-container fluid>
    <v-row>
      <v-col cols="12>">
        <v-btn color="accent" v-show="Object.values(parsedResult).length > 0" @click="doImport">
          Import into Database
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import {ref} from 'vue'
import {useImportedClassStore} from "../../stores/ImportedClasses.js"
import {useAppStateStore} from "../../stores/AppState.js"
import ClassChips from "../ui/ClassChips.vue";
import VariableChips from "../ui/VariableChips.vue";

const classStore = useImportedClassStore();
const appStore = useAppStateStore();

const valid = ref(null)
const url = ref(null);
const comment = ref(null);
const set_name = ref(null);

const parsedResult = ref(
    [
      {
        classes: [],
        vars: []
      }
    ]
)

const urlRules = [
  v => !!v || "Url is required",
  v => /^http(s?):\/\/[^\s$.?#].[^\s]*$/.test(v) || 'URL must be valid',
]
const commentRules = [
  v => !!v || "Comment is required"
]

const setNameRules = [
  v => !!v || "Set Name is required"
]

const fetchURL = () => {
  classStore.fetchFromURL(url.value, comment.value, set_name.value)
      .then(
          (result) => {
            parsedResult.value = result.body_response
          }
      )
      .catch(error => {
        console.log(error)
      })
}

const doImport = ()=> {
  classStore.doImport(parsedResult.value)
      .then(
          (result) => {
            appStore.showTimedNotice('Class set imported')
            parsedResult.value = [
              {
                classes: [],
                vars: []
              }
            ]
          }
      )
      .catch(error => {
        console.log(error)
      })
}

</script>

<style scoped>

</style>