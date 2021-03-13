<template>
	<div>
		<div class="sidebar">
            <h4>Categories</h4>
            <div class="custom-control custom-checkbox" v-for="category in categories">
              <input type="checkbox" class="custom-control-input" :id="category.id" :value="category.id" v-model="categoryBox" @change="getWebtemplatesByCategory($event)" true-value="yes" false-value="no">
              <label class="custom-control-label" :for="category.id">{{category.categoryName}}<span>{{category.category_products_count}}</span></label>
            </div>
          </div>
	</div>
</template>
<script>
import { mapGetters } from 'vuex'
	export default {
		// props:['categories'],
		data(){
			return {
				// categories:[],
				item:{
					categoryBox:[]
				},
				categoryId:[]
			}
		},
		mounted(){
			this.getCategories();
		},
		computed:{
			...mapGetters({
				categories:'categories'
				})
			/*categories() {
				return this.$store.getters.categories
			}*/
		},
		methods:{
			getCategories() {
				this.$store.commit('getCategories')
				/*axios.get('/api/categories').then(response=>{
					this.categories=response.data
				}).catch(error=>{
					console.log(error)
				})*/
			},
			getWebtemplatesByCategory(event) {
				if (this.categoryBox == 'yes') {
					this.categoryId.push(event.target.value)
				}
				else {
					let index=this.categoryId.findIndex(cat=>cat==event.target.value)
					this.categoryId.splice(index, 1);
				}
				this.$store.commit('templateByCategory',{
					category:this.categoryId
				})
				// this.emitter.emit("templateByCategory",this.categoryId);
			}
		}
	};
</script>
<style>
	
</style>