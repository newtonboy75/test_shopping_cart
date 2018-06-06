import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";
import * as Cookies from "js-cookie";

Vue.use(Vuex)

export default new Vuex.Store(
  {
    state: {
      cartItems: [],
      loggedUser: []
    },
    mutations: {
      addCart(state, cartItem) {
        state.cartItems.push(cartItem);
        console.log('cartItem added');
      },
      removeCart(state, cartItem) {
        state.cartItems = state.cartItems.filter(item => item !== cartItem);
      },

      addUser(state, user){
        state.loggedUser.push(user);
      }
    },
    getters: {
      itemCounts: state => {
        return store.state.cartItems.length;
      }
    },
    actions: {
      loadItems(){
          alert(store.state.cartItems);
      }
    },
    plugins: [createPersistedState({
      storage: {
        getItem: key => Cookies.get(key),
        setItem: (key, value) => Cookies.set(key, value, { expires: 3, secure: false }),
        removeItem: key => Cookies.remove(key)
      }
    })
    ]
  }
)
