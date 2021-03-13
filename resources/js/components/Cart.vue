<template>
	<div>
		<div class="container">
  	<div class="row">
  		<div class="col-md-12">
			 <div class="shopping-cart-wrapper">
				 <h1>Shopping Cart</h1>
				<div class="shopping-cart">
				  <div class="column-labels">
				    <label class="product-image">Image</label>
				    <label class="product-details">Product</label>
				    <label class="product-price">Price</label>
				    <label class="product-removal">Remove</label>
				  </div>

				  <div class="product" v-for="cartItem in getCartData">
				    <div class="product-image">
				      <img :src="cartItem.imagePath.imagePath">
				    </div>
				    <div class="product-details">
				      <div class="product-title">{{cartItem.cart_item_product.productName}}</div>
				      <p class="product-description" v-html="cartItem.cart_item_product.description"></p>
				    </div>
				    <div class="product-price">{{cartItem.price}}</div>
				    <div class="product-removal">
				      <button class="remove-product" @click="removeFromCart(cartItem.id)">
				        Remove
				      </button>
				    </div>
				  </div>

				  <div class="totals">
				    <div class="totals-item totals-item-total">
				      <label>Grand Total</label>
				      <div class="totals-value" id="cart-total">{{totalSum}}</div>
				    </div>
				  </div>
				  	<router-link class="checkout" :to="{path:'/checkout'}">Checkout</router-link>
				      <!-- <button class="checkout">Checkout</button> -->
				</div>
			  </div>
  		</div>
  	</div>
  </div>
	</div>
</template>
<script>
import { mapGetters } from 'vuex'
	export default {
		data() {
			return {
				// cartData:[]
			}
		},
		mounted() {
			this.getUserCart();
		},
		beforeMount(){
			if(localStorage.getItem('userToken') != null){
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('userToken')
            }
		},
		computed:{
			...mapGetters({
				getCartData:'getCartData',
				totalSum:'totalSum'
				})
		},
		methods:{
			getUserCart() {
				this.$store.commit('getUserCart')
				/*axios.get('api/user-cart').then(response=>{
					this.cartData=response.data
					console.log(response.data)
				}).catch(error=>{
					console.log(error)
				})*/
			},
			/*totalSum() {
				let sum=0;
				this.$store.state.cartData.forEach( function(element, index) {
					sum=sum+element.price
				});
				return sum
			},*/
			removeFromCart(id) {
				this.$store.commit('removeFromCart',{
					id:id
				})
				/*axios.delete('api/remove-from-cart/'+id).then(response=>{
					let index=this.cartData.findIndex(cart=>cart.id==id);
					this.cartData.splice(index,1);
				})*/
			}
		}
	};
</script>
<style>
	
</style>