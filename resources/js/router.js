import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import home from './components/pages/home'
import dashboard from './components/dashboard'
import product_category from './components/pages/category'
import department from './components/pages/department'
import item from './components/pages/item'
import table from './components/pages/table'
import device from './components/pages/device'
import cashin from './components/pages/cashin'
import cashout from './components/pages/cashout'
import suppliers from './components/pages/supplier'
import purchase_order from './components/pages/purchaseorder'

import account_expense from './components/pages/accountexpense'
import kitchen_dashboard from './components/kitchen_dashboard'
import bar_dashboard from './components/bar_dashboard'
import outsourced_dashboard from './components/outsourced_dashboard'
import new_kitchen_dashboard from './components/new_kitchen_dashboard'
import table_dashboard from './components/table_dashboard'


import user from './components/pages/user'
import role from './components/pages/role'
import assignRole from './components/pages/assignRole'

import reports from './components/reports'
import inventory from './components/inventory'
import expense from './components/expense'

import raw_materials from './components/raw_materials'

const routes = [

    {
        path:'/',
        component: home
    },

    {
        path:'/dashboard',
        component: dashboard
    },

    {
        path:'/category',
        component: product_category
    },

    {
        path:'/department',
        component: department
    },
    {
        path:'/suppliers',
        component: suppliers
    },
    {
        path:'/purchase_order',
        component: purchase_order
    },

    {
        path:'/item',
        component: item
    },

    {
        path:'/table',
        component: table
    },

    {
        path:'/device',
        component: device
    },

    {
        path:'/cashin',
        component: cashin
    },


    {
        path:'/cashout',
        component: cashout
    },

    {
        path:'/account_expense',
        component: account_expense
    },


    {
        path:'/kitchen_dashboard',
        component: kitchen_dashboard
    },

    {
        path:'/bar_dashboard',
        component: bar_dashboard
    },

    {
        path:'/outsourced_dashboard',
        component: outsourced_dashboard
    },

    {
        path:'/new_kitchen_dashboard',
        component: new_kitchen_dashboard
    },

    {
        path:'/table_dashboard',
        component: table_dashboard
    },

    {
        path:'/user',
        component: user
    },

    {
        path:'/role',
        component: role
    },

    {
        path:'/assignRole',
        component: assignRole
    },
    {
        path: '/reports',
        component: reports
    },
    {
        path: '/inventory',
        component: inventory
    },
    {
        path: '/expense',
        component: expense
    },
    {
        path: '/raw_materials',
        component: raw_materials
    }
]

export default new Router({
    mode:'history',
    routes
})
