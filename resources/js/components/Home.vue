<template>
	<div>
		<div class="banner">
		<div class="container">
			<div class="banner-inner">
				<div class="wr-banner-content text-center">
					<h1>Great Android App UI/UX Design start from here.</h1>
          <p class="info">Get 1000+ Screens of native android, ready to import in your android project. Create your android apps with WR-Design & launch professional looking andorid apps.
          </p>
          <p>
            <a href="" class="cta-yellow our-services">Just 5.99$ per month</a>
          </p>
				</div>
			</div>
		</div>
	</div>

	<div class="wr-about-info">
		<div class="container">
			<div class="row">
        <div class="col-md-12">
          <h3>10,000+ companies & 30,000+ android<br /> developers are designing their android apps <br />with WRDesign</h3>
        </div>
      </div>
		</div>
	</div>
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
	</div>
</template>
<script>
	import CategoryComponent from './CategoryComponent';
	import WebTemplate from './WebTemplate';
	export default {
		components:{
			CategoryComponent,
			WebTemplate
		}
	};
</script>
<style>
</style>