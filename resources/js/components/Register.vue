<template>
	<div>
		<div class="container">
		  	<div class="row">
		  		<div class="col-md-12">
		  			<div id="register" class="login-page">
		  				<form>
							<h3>Register</h3>
		  					<fieldset>
									<label for="">First Name:</label>
									<input type="text" name="first-name" id="first-name" v-model="firstName" required>
								</fieldset>
								<fieldset>
									<label for="">Last Name:</label>
									<input type="text" name="last-name" id="last-name" v-model="lastName" required>
								</fieldset>
								<fieldset>
									<label for="">Emal Address:</label>
									<input type="email" name="email-address" id="email-address" v-model="email" required>
								</fieldset>
								<fieldset>
									<label for="">Password:</label>
									<input type="Password" name="password" id="password" v-model="password" required>
								</fieldset>
								<fieldset>
									<input type="submit" value="Register" name="register" id="register" @click="registerUser">
								</fieldset>
								<fieldset>
									<p class="mt-4">Have already an account? <router-link :to="{path:'/login'}">Login here</router-link></p>
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
		props:['nextUrl'],
		data() {
			return {
				firstName:'',
				lastName:'',
				email:'',
				password:''
			}
		},
		methods:{
			registerUser(e){
				e.preventDefault()
				if (this.password.length > 0) {
					axios.post('api/register',{
						firstName:this.firstName,
						lastName:this.lastName,
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
				else {
					
				}
			}
		}
	};
</script>
<style type="text/css">
	
</style>