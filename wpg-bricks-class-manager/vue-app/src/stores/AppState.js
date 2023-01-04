import {defineStore} from 'pinia'



export const useAppStateStore = defineStore('appStateStore', {
    state: ()=>({
        showTimedNoticeFlag: false,
        timedNoticeMessage: '',
        timeout: 2000
    }),


    actions: {
        showTimedNotice(message){
            this.showTimedNoticeFlag = true
            this.timedNoticeMessage = message;
            console.log(message)
         }
    }
})
