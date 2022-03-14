import vueRouter from 'vue-router';
import Bookables from "./components/bookables/Bookables";
import Bookable from "./components/Bookable/Bookable";
import Review from "./components/review/Review";
import Basket from "./components/basket/Basket";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";
const routes = [
    {
        path: '/',
        component:Bookables,
        name: 'home'
    },
    {
    path: '/bookables/:id',
    component:Bookable,
    name: 'bookable'
    },
    {
        path: '/review/:id',
        component: Review,
        name: 'review'
    },
    {
        path:'/basket',
        component: Basket,
        name:'basket'
    },
    {
        path:'/auth/login',
        component: Login,
        name:'login'
    },
    {
        path:'/auth/register',
        component: Register,
        name:'register'
    }
];

const router = new vueRouter({
   routes,
    mode: 'history'
});

export default router;
