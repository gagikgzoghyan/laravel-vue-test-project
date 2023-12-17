import { createApp } from 'vue'

import store from './store'
import router from './routes'
import App from './components/App.vue'

import ElementPlus from 'element-plus'

import 'element-plus/dist/index.css'
import './assets/index.scss'

const app  = createApp(App)
app.use(store)
app.use(router)
app.use(ElementPlus)

app.mount("#app")

