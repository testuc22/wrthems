<template>
	<div>
		<div class="wr-products">
    		<div class="container-fluid">
				<div class="row heading">
					<div class="col-md-8">
						<h3>{{productDetails.productName}}</h3>
						<p class="mt-2" v-html="productDetails.description"></p>
					</div>
					<div class="col-md-4 text-right">
						<router-link class="cta-yellow our-services" :to="{ path:'/login'}" v-if="!isLoggedIn">Download full project - {{productDetails.price}} $</router-link>
						<a href="javascript:;" class="cta-yellow our-services" v-if="isLoggedIn" @click="addToCart(productDetails.id)">Download full project - {{productDetails.price}} $</a>
						<!-- <router-link class="cta-yellow our-services" :to="{ path:'/cart'}" v-if="isLoggedIn">Download full project - {{productDetails.price}} Rs</router-link> -->
					</div>
				</div>
				<div class="row">
        			<div class="col-md-3">
        				<div class="sidebar">
        					<h5>Template Tags</h5>
        					<div class="line"></div>
        					<ul class="list-group  list-group-flush">
        						<li class="list-group-item" v-for="tag in productDetails.product_tags">
        						<router-link :to="{path:'/templates-by-tag/'+tag.id}">{{tag.tag_name}}</router-link>				
        						</li>
        					</ul>
        					<!-- <div class="custom-control custom-checkbox">
				              <input type="checkbox" class="custom-control-input" id="CircleIndicator" checked>
				              <label class="custom-control-label" for="CircleIndicator">Circle Indicator<span>3</span></label>
				            </div> -->
        				</div>
        			</div>
        			<div class="col-md-9">
        				<div class="row">
        					<div class="masonry">
								<div class="brick" v-for="product in productDetails.product_files">
								    <img :src="product.imagePath">
								</div>
							</div>
        				</div>
        			</div>
        		</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				productDetails:{},
				isLoggedIn:localStorage.getItem('userToken')!=null
			}
		},
		mounted(){
			let id=this.getProductDetails();
		},
		beforeMount(){
			if(localStorage.getItem('userToken') != null){
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('userToken')
            }
		},
		methods:{
			getProductDetails() {
				axios.get('/api/web-template-details',{params:{id:this.$route.params.id}}).then(response=>{
					console.log(response.data)
					this.productDetails=response.data
					$('.lazy').lazyload();
				}).catch(error=>{
					console.log(error)
				})
			},
			addToCart(pid) {
				axios.post('/api/add-to-cart',{product:pid}).then(response=>{
					this.$router.push('/cart')
				}).catch(error=>{
					console.log(error)
				})
			}
		}
	};
</script>
<style>
	
</style>