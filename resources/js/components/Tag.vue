<template>
	<div class="wr-products">
    <div class="container-fluid">
      	<div class="row">
      		<div class="col-md-2">
      			<CategoryComponent></CategoryComponent>
      		</div>
      		<div class="col-md-10">
		         	<WebTemplate></WebTemplate>	
		        
      		</div>			
      	</div>
  	</div>
</div>
</template>
<script>
import WebTemplate from './WebTemplate';
import CategoryComponent from './CategoryComponent';
	export default {
		data() {
			return {

			}
		},
		components:{
			WebTemplate,
			CategoryComponent
		},
		mounted() {
			this.$store.commit('getTemplatesByTag',{
				id:this.$route.params.id
			})
			// this.emitter.emit('getTemplatesByTag');
		}
	};
</script>
<style>
	
</style>