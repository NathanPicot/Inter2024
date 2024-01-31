import { createApp } from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import { createPinia } from 'pinia'
import { loadFonts } from './plugins/webfontloader'

loadFonts()
const app = createApp(App)
app.use(createPinia())
  .use(vuetify)
  .mount('#app')
