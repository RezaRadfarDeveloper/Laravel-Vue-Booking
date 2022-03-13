<template>
        <div class="w-50 m-auto">
            <div class="card card-body">
                <form>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text"
                               id="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter your Email"
                               :class="{'is-invalid': errorFor('email')}"
                               v-model="email">
                    </div>
                    <v-errors :errors="errorFor('email')" ></v-errors>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter your password"
                               :class="{'is-invalid': errorFor('password')}"
                               v-model="password">
                    </div>
                    <v-errors :errors="errorFor('password')" ></v-errors>

                    <button type="submit" :disabled="loading" class="btn btn-primary mt-3 w-100 btn-lg" @click.prevent="login">Login</button>
                    <hr/>
                    <div >
                       No Account yet?
                        <router-link :to="{name: 'home'}" class="font-design">Register</router-link>
                    </div>
                    <div>
                        Forgot your password?
                        <router-link :to="{name: 'home'}" class="font-design">Reset</router-link>
                    </div>
                </form>
            </div>
        </div>
</template>

<script>
import ValidationError from "../shared/mixins/ValidationError";
import {logIn} from "../shared/utils/auth";


export default {
    name: "Login",
    mixins:[ValidationError],
    data() {
        return {
            email: null,
            password: null,
            loading:false
        }
    },
    methods: {
       async login() {
           this.loading = true;
           this.errors = null;
           try{
               await this.$store.dispatch('loadStoredState');
               await axios.get('/sanctum/csrf-cookie').then(response => {
                   console.log('response::')
                   console.log(response)

               });
               await axios.post('/login',{
                   email: this.email,
                   password: this.password
               });
               logIn();
              await this.$store.dispatch('loadUser');
              await this.$router.push({name: "home"})

           } catch(err) {
            this.errors = err.response && err.response.data.errors
           }
    this.loading = false;
       }
    }
}
</script>

<style scoped>

.font-design {
    font-weight: bold;
}
</style>
