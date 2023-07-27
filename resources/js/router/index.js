import {createRouter,createWebHistory} from "vue-router";

import Index from '../views/rds/Index.vue'
import Show from '../views/rds/Show.vue'


const routes = [
    {
        path : '/dashboard',
        name : 'rds.index',
        component : Index
    },
    {
        path : '/dashboard/rds/:DBInstanceIdentifier/:region',
        name : 'rds.index.show',
        component : Show
    }
]

export default createRouter({
    history:createWebHistory(),
    routes
})
