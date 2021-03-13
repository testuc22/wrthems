<template>
  

<div class="wr-dashboard">
   <div class="container-fluid">
      <div class="row">
         <ul class="dashboard-product-listing">
            <li><a href="#" class="active">All orders</a></li>
         </ul>
      </div>
   </div>
</div>
<div class="wr-dashboard-table">
   <div class="container-fluid">
      <div class="row">
         <table class="table table-bordered dashboard-table">
         	<tr>
            <th scope="row">Id</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Order status</th>
            <th>Download</th>
        </tr>
            <tr v-for="order in orders">
               <td>{{order.id}}</td>
               <td>{{moment(order.created_at).format("MM/DD/YYYY")}}</td>
               <td>{{order.price}}</td>
               <td><span class="green">Completed</span></td>
               <td><a :href="order.download_url" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></td>
            </tr>
         </table>
      </div>
   </div>
</div>


</template>
<script>
import { mapGetters } from 'vuex'
	export default {
		data() {
			return {
				// orders:[]
			}
		},
		computed :{
			...mapGetters(['orders'])
		},
		mounted() {
			this.getUserOrders();
		},
		beforeMount(){
			if(localStorage.getItem('userToken') != null){
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('userToken')
            }
		},
		methods:{
			downloadFile(order){
				axios.post('download-file',{order:order}).then(response=>{
					console.log(response.data)
				}).catch(err=>{
					console.log(err)
				})
			},
			getUserOrders() {
				this.$store.commit('getUserOrders');
				/*axios.get('api/get-user-orders').then(response=>{
					this.orders=response.data
				}).catch(err=>{
					console.log(err)
				})*/
			}
		}
	};
</script>
<style>
	
</style>