

const Checkout = { template: '<div>checkpout</div>' };
const Home = { template: '<div>test</div>' };

const routes = [
	{ path: '/checkout', component: Checkout },
	{ path: '/',  component : Home }
];

const router = new VueRouter({
	mode: 'history',
	routes
});

var app = new Vue({
	//el: '#app',
	//router: router,
	router,
	data:{
		items: [],
		cartItems: [],
		user: []
	},

	mounted: function(){
		this.getAllItems();
		//this.addRating();
		this.checkUser();
	},

	methods:{
		getAllItems: function(){
			axios.get('http://localhost/test_shopping_cart/Main.php?dest=products')
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
		showCartItems: function(){
			alert(this.cartItems);
		},
		addRating: function(id, rating){
			//alert("on load here");

			axios.post('http://localhost/test_shopping_cart/shoppingcart.php', {
				id: id,
				rating: rating
			})
			.then(function (response) {
				console.log(response);
			})
			.catch(function (error) {
				console.log(error);
			});

		},
		checkUser: function(){
			axios.get('http://localhost/test_shopping_cart/Main.php?dest=user&username=newton&password=admin')
			.then(function (response) {
				console.log("users" +response.data);
				app.user = response.data;
			})
			.catch(function (error) {
				console.log("user" + error);
			});
		}
	}
}).$mount('#app');
