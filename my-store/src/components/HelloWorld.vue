<template>
  <div class="hello">
hello
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
  data () {
    return {
      user:[]
    }
  },
  methods: {
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
}
</script>
