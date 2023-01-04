import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'


const myCustomLightTheme = {
    dark: false,
    colors: {
        background: '#000000',
        surface: '#000000',
        primary: '#2a2a2a',
        'primary-darken-1': '#181818',
        secondary: '#2c2413',
        'secondary-darken-1': '#211c0f',
        accent: "#ffd34e",
        error: '#B00020',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FB8C00',
    }
}

export default createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
    theme: {
        defaultTheme: 'myCustomLightTheme',
        themes: {
            myCustomLightTheme,
        }
    }
})