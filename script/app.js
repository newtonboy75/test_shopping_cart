var app = new Vue({
	el: '#app',
	data:{
		items: [],
		cartItems: [],
	},

	mounted: function(){
		this.getAllItems();
	},

	methods:{
		getAllItems: function(){
			axios.get("http://localhost/test_shopping_cart/products.php")
				.then(function(response){
					console.log(response.data);
					app.items = response.data;
				});
		},
    addToCart: function(item){
      this.cartItems.push(item);
			console.log(item.name);
    },
    removeFromCart: function(item){
      alert("test");
    },
		showCartItems(){
			alert(this.cartItems);
		}
	}
});
