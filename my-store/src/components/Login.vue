<template>
  <div class="main-container">
    <form @submit="validateSubmit"  method="POST" class="form-holder align-content-center">
      <div class="form-row">
        <div class="float-left"><h5>Login</h5></div>
      </div>
      <div class="form-row"><label class="col-form-label" for="username">Username:</label><input v-model="username" @change="clearError" type="text" class="input form-control username" value="">&nbsp;
        <div class="text-danger" v-if="errors.username">{{errors.username}}</div>
      </div>
      <div class="form-row"><label class="col-form-label" for="password">Password:</label><input v-model="password" @change="clearError" type="password" class="input form-control password" value="">&nbsp;
        <div class="text-danger" v-if="errors.password">{{errors.password}}</div>
        <div ref="error" class="text-danger float-right clearfix"></div>
      </div>
      <div class="form-row align-content-center"><input type="submit" class="btn  submit-button" value="Login"></div>
    </form>
    <div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'
import { mapMutations } from 'vuex'
import * as Cookies from "js-cookie";

export default {
  name: 'App',
  data () {
    return {
    user: [],
    cartItems: [],
    errors: [],
    login_error: '',
    username:null,
    password:null,
    }
  },
    methods: {
      responseError(){
      //this.errors["login_error"] = "User not found";
      //if(this.errors.login_error.length > 0) "Login Error"
      this.$refs.error.innerText = "Login error";
    },
    clearError(){
      this.errors = [];
      this.$refs.error.innerText = "";
    },
    ...mapMutations([
     'addUser'
    ]),
    //implementing basic authentication. a middleware should be a good idea
    validateSubmit:function(e) {
        if(this.username && this.password) this.getUser(this.username, this.password);
        this.errors = [];
        if(!this.username) this.errors["username"] = "Username is required.";
        if(!this.password) this.errors["password"] = "Password is required.";
        e.preventDefault();
      },
    getUser(username, password){
      let app = this;
        axios.get('http://newtonboy.cba.pl/main.php?dest=user&username='+username+'&password='+password)
        .then( response => {
        console.log(response.data);
          if(response.data == "0"){
            app.responseError();
          }else{
            this.addUser(this.user = response.data);
            this.$store.commit('addUser');
            //app.$router.push('/');
            this.$router.go(-1);
          }
        }).catch((error) => {
            app.responseError();
        });
    }
  }
}

</script>

<style scoped>
.form-holder{
  max-width:400px;
  margin:auto;
}
.submit-button{
  max-width: 400px;
  text-align:center;
  margin-top:20px;
  margin-left:auto;
  margin-right:auto;
  background: #3ca88b;
  color: #ffffff;
}
</style>
