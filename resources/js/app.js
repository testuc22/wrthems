require('./bootstrap');
import mitt from 'mitt';
import moment from 'moment';
import {createApp} from 'vue';
import { createWebHistory, createRouter } from "vue-router";
import MainComponent from './components/MainComponent.vue';
import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import Cart from './components/Cart.vue';
import Checkout from './components/Checkout.vue';
import Dashboard from './components/Dashboard.vue';
import Tag from './components/Tag.vue';
import SingleTemplateComponent from './components/SingleTemplateComponent.vue';
import store from './store.js';
const emitter = mitt();
const routes=[
	{
		path:'/web-templates/:id',
		name:'SingleTemplateComponent',
		component:SingleTemplateComponent
	},
	{
		path:'/templates-by-tag/:id',
		name:'Tag',
		component:Tag
	},
	{
		path:'/',
		name:'Home',
		component:Home
	},
	{
		path:'/register',
		name:'Register',
		component:Register
	},
	{
		path:'/login',
		name:'Login',
		component:Login
	},
	{
		path:'/cart',
		name:'Cart',
		component:Cart,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/checkout',
		name:'Checkout',
		component:Checkout,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/dashboard',
		name:'Dashboard',
		component:Dashboard,
		meta:{
			requiresAuth:true
		}
	}
];
const router=createRouter({
	history: createWebHistory(),
	routes
});

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if (localStorage.getItem('userToken') == null) {
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() 
  }
})

const app =createApp(MainComponent);
app.config.globalProperties.emitter = emitter
app.config.globalProperties.moment = moment
app.use(router)
app.use(store)
app.mount("#wrapp");
console.log(app)
