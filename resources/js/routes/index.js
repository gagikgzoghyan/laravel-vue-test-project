import { createRouter, createWebHashHistory } from 'vue-router'

import Login from 'components/views/auth/Login.vue'

const routes = [
    {
        name: 'main',
        path: '/',
        component: Login,
        meta: {auth: 'guest'}
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})

// router.beforeEach(async(to, from, next) => {
//
// });

export default router;
