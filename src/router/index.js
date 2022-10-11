import Vue from 'vue'
import VueRouter from 'vue-router'

import Auth from '@/views/Auth.vue'
import Add from '@/views/Add.vue'
import Models from '@/views/Models.vue'
import Colors from '@/views/Colors.vue'
import Users from '@/views/Users.vue'
import Stores from '@/views/Stores.vue'
import History from '@/views/History.vue'
import NotFound from '@/views/NotFound.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Auth',
    component: Auth,
    meta: {
      layout: 'AuthLayout'
    }
  },
  {
    path: '/add',
    name: 'Add',
    component: Add,
    meta: {
      layout: 'Default'
    }
  },
  {
    path: '/add/models',
    name: 'Models',
    component: Models,
    meta: {
      layout: 'Default'
    }
  },
  {
    path: '/add/colors',
    name: 'Colors',
    component: Colors,
    meta: {
      layout: 'Default'
    }
  },
  {
    path: '/add/users',
    name: 'Users',
    component: Users,
    meta: {
      layout: 'Default'
    }
  },
  {
    path: '/store',
    name: 'Stores',
    component: Stores,
    meta: {
      layout: 'Default'
    }
  },
  {
    path: '/history',
    name: 'History',
    component: History,
    meta: {
      layout: 'Default'
    }
  },
  {
    path: '*',
    name: 'NotFound',
    component: NotFound,
    meta: {
      layout: 'AuthLayout'
    }
  },
]

const router = new VueRouter({
  routes,
  mode: 'history'
})

export default router
