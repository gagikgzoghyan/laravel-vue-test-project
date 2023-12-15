import { createApp } from 'vue'

import store from './store'
import router from './routes'
import App from './App.vue'
import lodash from 'lodash'
import 'element-plus/dist/index.css'

const app  = createApp(App)
app.use(store)
app.use(router)
app.use(lodash)

app.mount("#app")

