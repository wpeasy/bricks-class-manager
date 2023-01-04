import {defineStore} from 'pinia'
import REST_Client from "../services/REST_Client.js";


export const useGlobalClassStore = defineStore('globalClassStore', {
    state: ()=>({
        classes: {},
        tempClasses: [],
        fetching: false
    }),

    getters: {
      getCount(){
          return Object.keys(this.classes).length
      },
        isFetching(){
          return this.fetching
        }
    },

    actions: {
        getData(){
            this.fetching = true
            REST_Client.get('get_class_list')
                .then( result => {
                    this.classes = result.body_response
                    this.tempClasses = [];
                })
                .catch( error => { console.log(error)})
                .finally(()=>{ this.fetching = false})
         },
        save(){
            this.fetching = true
            REST_Client.post('update_class_list', this.classes)
                .catch( error => { console.log(error)})
                .finally(()=>{ this.fetching = false})
        }

    }
})
