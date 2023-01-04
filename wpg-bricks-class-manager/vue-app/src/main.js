import { createApp } from 'vue'
import './index.scss'
import vuetify from './vuetify.js'
import App from './App.vue'
import {createPinia} from "pinia";



const app = createApp(App)
app.use(vuetify)
    .use(createPinia())
    .mount("#app");