import {
    createRouter,
    createWebHistory,
} from 'vue-router'

import HomeView from '../views/HomeView.vue';

const routes = [
    { 
        path: '/', 
        meta : {layout : 'panel'},
        name : 'home',
        component: HomeView ,
    },
    
    { 
        path: '/page-one', 
        name : 'page-one',
        component: () =>import('../views/PageOneView.vue'),
    },
    { 
        path: '/page-two', 
        name : 'page-two',
        component: () =>import('../views/PageTwoView.vue'),
    },
    {
        path : '/page-three',
        name : 'page-three',
        component : () => import('../views/PageThreeView.vue')
    }
    
]

const router = createRouter({
    history: createWebHistory('/store/'),
    routes,
})

router.beforeEach((to, from, next) => {
    // const authStore = useAuthStore()
    // if(to.meta.onlyWaiter && !authStore.isWaiter){
    //     return next({name : 'login'})
    // }
    // if(to.meta.requiresAuth && !to.meta.onlyWaiter && authStore.isWaiter){
    //     console.log('wait')
    //     return next({name : 'waiter-home'})
    // }
    // if(to.meta.requiresAuth && !authStore.isLoggedIn){
    //     if(to.params.restaurant){
    //         authStore.sendBackData = to.fullPath;
    //     }
    //     return next({name : 'login'})
    // }
    next()
})

export default router;