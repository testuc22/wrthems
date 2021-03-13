<template>
	<div class="container">
		<div class="row">
  			<div class="col-md-12 mt-5 mb-5">
				<!-- <button class="btn btn-warning" @click="placeOrder">Place Order</button> -->
				<div id="paypal-button-container"></div>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters } from 'vuex'
	export default {
		data() {
			return {
				totalPrice:0
			}
		},
		mounted() {
			paypal.Buttons({
			    createOrder: (data, actions)=> {
			      return axios.post('api/place-order').then(res=>{
			      	console.log(res.data)
					return res.data.result.id;
					}).catch(err=>{
						console.log(err)
					})
			    },
			    onApprove: (data)=> {
			    	console.log(data)
				  return axios.post('api/capture-paypal-transaction',{orderid:data.orderID}).then((res)=> {
				  	console.log(res)
				    if (res.data.result.status=="COMPLETED") {
				    	this.$router.push('dashboard')
				    }
				  })
				}
			  }).render('#paypal-button-container');
		},
		beforeMount(){
			if(localStorage.getItem('userToken') != null){
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('userToken')
            }
		},
		computed:{
			...mapGetters({
				totalSum:'totalSum'
				})
		},
		methods:{
			placeOrder(){
				axios.post('api/place-order').then(response=>{
					console.log(response.data)
				}).catch(err=>{
					console.log(err)
				})
			}
		}
	};
</script>
<style>
	
</style>