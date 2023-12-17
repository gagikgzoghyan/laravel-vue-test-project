import { createRouter, createWebHashHistory } from 'vue-router'

import store from '../store/index.js'
import apiUsers from '@/api/users'

import Activities from '@/components/views/activities/index.vue'
import Users from '@/components/views/users/index.vue'
import Login from '@/components/auth/login/index.vue'
import Register from '@/components/auth/register/index.vue'

const routes = [
    {
        name: 'main',
        path: '/',
        component: Activities,
        meta: {auth: 'auth'},
    },
    {
        name: 'users',
        path: '/users',
        component: Users,
        meta: {
            auth: 'auth',
            roles: ['admin']
        },
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {auth: 'guest'}
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {auth: 'guest'}
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})

router.beforeEach(async(to, from, next) => {
    let user = null
    let isLogged = store.getters.getIsLogged

    let clearStorage = () => {
        store.commit('setAccessToken', null)
        store.commit('setIsLogged', false)
        store.commit('setUser', null)
        next('/login')
    };

    if (isLogged) {
        await apiUsers
            .account()
            .then(response => {
                user = response.data
                store.commit('setUser', user)
            }).catch(() => {
                clearStorage()
            })
    }

    if (to.meta['auth'] === 'guest') {
        if (isLogged) {
            next('/')
        } else {
            next()
        }
    } else if (to.meta['auth'] === 'auth') {
        if (user) {
            let access = true

            if (to.meta['roles'] !== undefined && to.meta['roles'].length) {
                access = user.roles.some(role => to.meta['roles'].includes(role.name))
            }

            if (access) {
                next()
            } else {
                next('/')
            }
        } else {
            next('/login')
        }
    } else {
        next();
    }
});

export default router;
