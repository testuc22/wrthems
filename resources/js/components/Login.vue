<template>
	<div>
	  	<div class="container">
		  	<div class="row">
		  		<div class="col-md-12">
		  			<div id="login" class="login-page">
		  				<form action="">
								<h3>Login</h3>
		  					<fieldset>
									<label for="username">Email:</label>
									<input type="email" name="username" id="username" v-model="email">
								</fieldset>
								<fieldset>
									<label for="password">Password:</label>
									<input type="Password" name="password" id="password" v-model="password">
								</fieldset>
								<fieldset>
									<input type="submit" value="Login" name="login" id="login" @click="tryLogin">
								</fieldset>
								<fieldset>
									<p class="mt-4">Don't have an account? <router-link :to="{path:'/register'}">Register here</router-link></p>
								</fieldset>
		  				</form>
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
				email:'',
				password:''
			}
		},
		methods:{
			tryLogin(e) {
				e.preventDefault();
				if (this.password.length > 0) {
					axios.post('api/login',{
						email:this.email,
						password:this.password
					}).then(response=>{
						localStorage.setItem('user',JSON.stringify(response.data.user))
                        localStorage.setItem('userToken',response.data.token)
                        
                        if (localStorage.getItem('userToken') != null){
                            this.emitter.emit('loggedIn')
                            if(this.$route.params.nextUrl != null){
                                this.$router.push(this.$route.params.nextUrl)
                            }
                            else{
                                this.$router.push('/')
                            }
                        }
					}).catch(error=>{
						console.log(error)
					})
				}
			}
		}
	};
</script>
<style>
	
</style>