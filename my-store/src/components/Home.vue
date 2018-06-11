<template>
  <div class="main-container">
  <div class="row">
  <div class="product-grid col-sm-4"  v-for="item in items">
  <div class="center-block"><img class="grid-images" :src="getSrc(item.product_image)"></div>
  <div class="font-weight-bold">{{item.name}}</div>
  <div class="ratings">Rating: {{item.rating}} &nbsp;&nbsp;
    <span @click="addRating(item.id, 1)" class="rate-star" v-bind:class="{ checked: item.rating >= 1}">&starf;</span>
    <span @click="addRating(item.id, 2)" class="rate-star" v-bind:class="{ checked: item.rating >= 2}">&starf;</span>
    <span @click="addRating(item.id, 3)" class="rate-star" v-bind:class="{ checked: item.rating >= 3}">&starf;</span>
    <span @click="addRating(item.id, 4)" class="rate-star" v-bind:class="{ checked: item.rating >=  4}">&starf;</span>
    <span @click="addRating(item.id, 5)" class="rate-star" v-bind:class="{ checked: item.rating >= 5}">&starf;</span>
  </div>
  <div>${{item.unit_price}}</div>
  <button class="btn buy-btn" @click="addCart(item)">Add to Cart</button>
  </div>
</div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapMutations } from 'vuex'

export default {
  name: 'Home',
  data () {
    return {
      items: [],
    }
  },
  mounted(){
    this.$store.state.info = '';
    this.$store.state.warning= '';
    axios.get('http://newtonboy.cba.pl/main.php?dest=products')
    .then(response => {
    //console.log("rating " +response.data);
    this.items = response.data;
    })
    .catch(function (error) {
      console.log("items" + error);
    });

    //generate random number for rating system for now for random product item

    var randomNum = function (num1, num2) {
        var range = num1 - num2 + 1;
        return num2 + Math.floor(Math.random() * range);
    };

    var ratingRandom = randomNum(0, 6);
    var ratingForItem = randomNum(0, 4);

    axios.post('http://newtonboy.cba.pl/main.php?dest=rating&product_id=' + ratingForItem + '&rating=' + ratingRandom)
    .then(response => {
    //console.log("items" +response.data);
    //this.items = response.data;
    })
    .catch(function (error) {
      console.log("items" + error);
    });

    //console.log("this" + randomNum(1, 5))
  },
  methods: {
    addRating(item, rating){
      axios.post('http://newtonboy.cba.pl/main.php?dest=rating&product_id=' + item + '&rating=' + rating)
      .then(response => {
      //console.log("items" +response.data);
      //this.items = response.data;
      })
      .catch(function (error) {
        console.log("items" + error);
      });
    },
    getSrc(name) {
         var images = require.context('../assets/img/', false, /\.jpg$/);
         return images('./' + name)
     },
     ...mapMutations([
      'addCart'
    ]),
    addCartItem(){
      this.$store.commit('addCart');
      this.currentItemCount();
    }
  }
}
</script>
