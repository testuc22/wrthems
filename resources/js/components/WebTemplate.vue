<template>
	<div>
		<div class="row search-form">
		            <div class="col-md-12">
		              <form @submit.prevent="searchTemplates">
		                <input type="search" name="" id="" placeholder="Search like : ecommerce cart, produt detail page, filter, login, signup" v-model="search">
		              </form>
		            </div>
		          </div>
		         <div class="row">
					<ul class="product-listing">
						<li v-for="webTemplate in templates">
							<div class="product">
								<router-link :to="{path:'/web-templates/'+webTemplate.id}">
			                  	<div class="img-wrap">
			                    	<img :src="getImage(webTemplate)" alt="">
			                  	</div>
			                  	<h5>{{webTemplate.productName}}</h5>
			                  </router-link>
			                </div>
						</li>
					</ul>
				</div>
	</div>
</template>
<script>
import { mapGetters } from 'vuex'
	export default {
		data(){
			return {
				webTemplates:[],
				search:''
			}
		},
		computed:{
			...mapGetters({
				templates:'templates'
				})
		},
		mounted() {
			this.getWebTemplates();
			/*this.emitter.on("templateByCategory",($categories)=>{
				axios.get('/api/webtemplates-by-category',{params:{category:$categories}}).then(response=>{
					this.webTemplates=response.data
				}).catch(error=>{
					console.log(error)
				})
			})
			this.emitter.on("getTemplatesByTag", (id)=>{
				console.log(id)
				axios.get('/api/webtemplates-by-tag',{params:{id:id}}).then(response=>{
					this.webTemplates=response.data
				}).catch(err=>{
					console.log(err)
				})
			})*/
		},
		methods:{
			getWebTemplates() {
				this.$store.commit('getWebTemplates')
				/*axios.get('/api/webtemplates').then(response=>{
					this.webTemplates=response.data
				}).catch(error=>{
					console.log(error)
				})*/
			},
			getImage(image) {
				return image.product_files[0].imagePath
			},
			searchTemplates() {
				this.$store.commit('searchTemplates',{
					search:this.search
				})
				/*axios.get('api/search-templates',{params:{search:this.search}}).then(response=>{
					this.webTemplates=response.data
				}).catch(error=>{
					console.log(error)
				})*/
			}
		}
	};
</script>

<style>
	
</style>