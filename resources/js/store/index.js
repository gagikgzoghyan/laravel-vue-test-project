import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate"
import Cookies from "js-cookie"

import auth from './modules/auth'
import user from './modules/user'

createPersistedState({storage: window.sessionStorage})

const store = createStore({
    strict: import.meta.env.APP_ENV !== 'production',
    modules: {
        auth,
        user,
    },
    plugins: [
        createPersistedState({
            storage: {
                getItem: (key) => Cookies.get(key),
                setItem: (key, value) => Cookies.set(key, value, {
                    expires: 3,
                }),
                removeItem: (key) => Cookies.remove(key)
            },
            paths: ['auth', 'user']
        })
    ]
})

export default store
