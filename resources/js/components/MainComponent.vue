<template>
	<div>
		<Header></Header>
		<transition name="page" mode="out-in">
		<router-view @loggedIn="change"></router-view>
		</transition>
		<Footer></Footer>
	</div>
</template>
<script>
	import CategoryComponent from './CategoryComponent';
	import WebTemplate from './WebTemplate';
	import Home from './Home';
	import Header from './Header';
	import Footer from './Footer';
	export default {
		components:{
			CategoryComponent,
			WebTemplate,
			Header,
			Footer
		},
		data() {
			return {
				isLoggedIn:localStorage.getItem('userToken')!=null
			}
		},
		mounted() {
	        this.setDefaults()
	        console.log(this.isLoggedIn)
	      },
	      
	      methods : {
	        setDefaults(){
	          if(this.isLoggedIn){
	            let user= JSON.parse(localStorage.getItem('user'))
	          }
	        },
	        change(){
	            this.isLoggedIn = localStorage.getItem('userToken') != null
	            this.setDefaults()

	        },
	        logout(){
	            localStorage.removeItem('userToken')
	            localStorage.removeItem('user')
	            this.change()
	            this.$router.push('/')
	        }
	      }
	};
</script>
<style>
.page-enter,
.page-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.page-enter-active,
.page-leave-active {
  transition: all 0.5s ease-in-out;
}
</style>