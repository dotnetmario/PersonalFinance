import Vue from 'vue';
import VueRouter from 'vue-router';
// authentication
import Login from '@/js/pages/login';
import Register from '@/js/pages/register';
// main app pages
import Home from '@/js/pages/Home';
import Incomes from '@/js/pages/Incomes';
import IncomesDetails from '@/js/pages/IncomesDetails';
import Dashboard from '@/js/pages/Dashboard';
import Expenses from '@/js/pages/Expenses';


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', name: 'home', component: Home},
        {path: '/dashboard', name: 'dashboard', component: Dashboard},
        {path: '/login', name: 'login', component: Login},
        {path: '/register', name: 'register', component: Register},

        // income routes
        {path: '/incomes', name: 'incomes', component: Incomes},
        {path: '/incomes-details', name: 'incomes-details', component: IncomesDetails},


        // expenses routes
        {path: '/expenses', name: 'expenses', component: Expenses},
    ],
});

export default router;