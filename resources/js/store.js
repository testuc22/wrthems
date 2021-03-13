require('./bootstrap');
import { createStore } from 'vuex';
const store = createStore({
	state() {
		return {
			categories:[],
			webTemplates:[],
			orders:[],
			cartData:[]
		}
	},
	mutations: {
		getCategories(state) {
			axios.get('/api/categories').then(response=>{
				state.categories=response.data
				console.table(response.data)
			}).catch(error=>{
				console.log(error)
			})
		},
		getWebTemplates(state) {
			axios.get('/api/webtemplates').then(response=>{
					state.webTemplates=response.data
				}).catch(error=>{
					console.log(error)
				})
		},
		templateByCategory(state,payload) {
			axios.get(`/api/webtemplates-by-category`,{params:{category:payload.category}}).then(response=>{
					state.webTemplates=response.data
				}).catch(error=>{
					console.log(error)
				})
		},
		searchTemplates(state,payload) {
			axios.get('api/search-templates',{params:{search:payload.search}}).then(response=>{
					state.webTemplates=response.data
				}).catch(error=>{
					console.log(error)
				})
		},
		getTemplatesByTag(state,payload) {
			axios.get('/api/webtemplates-by-tag',{params:{id:payload.id}}).then(response=>{
					state.webTemplates=response.data
				}).catch(err=>{
					console.log(err)
				})
		},
		getUserOrders(state) {
			axios.get('api/get-user-orders').then(response=>{
					state.orders=response.data
				}).catch(err=>{
					console.log(err)
				})
		},
		getUserCart(state) {
			axios.get('api/user-cart').then(response=>{
					state.cartData=response.data
					// console.log(response.data)
				}).catch(error=>{
					console.log(error)
				})
		},
		removeFromCart(state,payload) {
			axios.delete('api/remove-from-cart/'+payload.id).then(response=>{
					let index=state.cartData.findIndex(cart=>cart.id==payload.id);
					state.cartData.splice(index,1);
				})
		},
			
	},
	getters:{
		categories(state) {
			return state.categories
		},
		templates(state) {
			return state.webTemplates
		},
		orders(state) {
			return state.orders
		},
		getCartData(state) {
			return state.cartData
		},
		totalSum(state) {
			let sum=0;
			state.cartData.forEach( function(element, index) {
				sum=sum+element.price
			});
			return sum
		}
	}
})

export default store;