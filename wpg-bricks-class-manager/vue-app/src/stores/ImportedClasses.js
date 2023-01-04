import {defineStore} from 'pinia'
import REST_Client from "../services/REST_Client.js";


export const  useImportedClassStore = defineStore('importedClassStore', {
    state: () => ({
        sets: {},
        fetching: false
    }),

    getters: {
        getCount() {
            return Object.keys(this.sets).length
        },
        getSets(){
            return this.sets;
        },
        isFetching() {
            return this.fetching
        }
    },

    actions: {
        getData() {
            this.fetching = true
            return new Promise((resolve, reject) => {
                REST_Client.get('get_imported_class_list')
                    .then(result => {
                        this.sets = result.body_response
                        resolve('OK')
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        this.fetching = false
                    })
            })
        },

        deleteSet(setName){
            this.fetching = true
            return new Promise((resolve, reject)=>{
                REST_Client.post('delete_from_imported_class_list', {set_name: setName} )
                    .then( result => {
                        if(result.status === 200){
                            resolve('OK')
                        }else{
                            reject('NOT OK')
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        this.fetching = false
                    })
            })
        },

        updateStatus(setName, status){
            this.fetching = true
            return new Promise((resolve, reject)=>{
                REST_Client.post('update_status', {set_name: setName, status: status} )
                    .then( result => {
                        if(result === 'OK'){
                            resolve('OK')
                        }else{
                            reject('NOT OK')
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        this.fetching = false
                    })
            })
        },
        fetchFromURL(url,comment,setName){
            this.fetching = true
            return new Promise((resolve, reject)=>{
                REST_Client.post('parse_css_from_url', {url: url, comment:comment, set_name: setName} )
                    .then( result => {
                        resolve(result)
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        this.fetching = false
                    })
            })
        },

        doImport(obj){
            this.fetching = true
            return new Promise((resolve, reject)=>{
                REST_Client.post('add_to_imported_class_list', obj )
                    .then( result => {
                        resolve(result)
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        this.fetching = false
                    })
            })
        }
    }
})
