<template>
	<div class="header-wrapper 123464">
		 <div class="container">
		     <div class="header">
		         <div class="logo">
		             <a href="/" class="logo1"><img src="https://www.webriderz.com/images/logo.png" alt="Webriderz Logo"></a>
		             <a href="/" class="logo-original"><img src="https://www.webriderz.com/images/logo-original.png" alt="Webriderz Logo"></a>
		         </div>
		         <div class="wr-navigation">
		         <!-- <a class="cta-transparent" href="#">Android XML Code</a>
		         <a class="cta-transparent" href="#">Ready Products</a> -->
		         <a class="cta-transparent" href="https://www.webriderz.com" target="_blank">Our Services</a>
		         <!-- <a class="cta-transparent active" href="#">Login / Signup</a> -->
		         <router-link class="cta-transparent active" :to="{ path:'/login'}" v-if="!isLoggedIn">Login / Signup</router-link>
		         <router-link class="cta-transparent active" :to="{ path:'/dashboard'}" v-if="isLoggedIn">Dashboard</router-link>
		         <a class="cta-transparent active" href="javascript:;" @click="logout" v-if="isLoggedIn">Logout</a>
		         </div>
		         <div class="navigation">
		             <a href="javascript:void(0)" class="menu-bar">
		                 <span class="bars bar1"></span>
		                 <span class="bars bar2"></span>
		                 <span class="bars bar3"></span>
		                 <span class="bars bar4"></span>
		             </a>
		         </div>

		        <!-- mobile menu -->

		        <div class="menu-modal">
		                <div class="menu-box">
		                    <div class="container">
		                    <div class="modal-outer">
		                        <div class="modal-desc">
		                            <div class="container">
		                                <div class="modal-logo">
		                                    <a href="/"><img src="https://www.webriderz.com/images/modal-logo.png" alt="Modal Logo"></a>
		                                    <p class="desc">
		                                        <span class="sub-p color-white">0161-5028632</span>
		                                        <span class="sub-p color-white">info@webriderz.com</span>
		                                    </p>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="modal-dropdown">
		                            <ul>
		                                
		                                <li><a href="https://www.webriderz.com">Our Services</a></li>
		                                <router-link class="cta-transparent active" :to="{ path:'/login'}" v-if="!isLoggedIn">Login / Signup</router-link>
		         						<li v-if="isLoggedIn"><a class="cta-transparent active" href="javascript:;" @click="logout" >Logout</a></li>
		                            </ul>
		                            <div class="modal-icons">
		                                <ul>
		                                    <li><a href="https://www.facebook.com/webriderzindia/" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a></li>
		                                    <li><a href="https://www.linkedin.com/company/webriderz/" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a></li>
		                                    <li><a href="https://www.behance.net/webriderz" target="_blank" class="social-icon"><i class="fab fa-behance"></i></a></li>
		                                </ul>
		                            </div>
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
				isLoggedIn:localStorage.getItem('userToken')!=null
			}
		},
		mounted(){
			this.emitter.on("loggedIn",()=>{
				this.isLoggedIn = localStorage.getItem('userToken') != null
			});
		},
		methods:{
			logout() {
				localStorage.removeItem('userToken')
	            localStorage.removeItem('user')
	            // this.change()
	            this.isLoggedIn = localStorage.getItem('userToken') != null
	            this.$router.push('/')
			}
		}
	};
</script>
<style>
	
</style>