<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text"
                           id="name"
                           name="email"
                           class="form-control"
                           placeholder="Enter your Name"
                           :class="{'is-invalid': errorFor('name')}"
                           v-model="user.name">
                </div>
                <v-errors :errors="errorFor('name')" ></v-errors>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text"
                           id="email"
                           name="email"
                           class="form-control"
                           placeholder="Enter your Email"
                           :class="{'is-invalid': errorFor('email')}"
                           v-model="user.email">
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
                           v-model="user.password">
                </div>
                <v-errors :errors="errorFor('password')" ></v-errors>
                <div class="form-group">
                    <label for="password_confirmation">Re-type Password</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Confirm your password"
                           :class="{'is-invalid': errorFor('password_confirmation')}"
                           v-model="user.password_confirmation">
                </div>
                <v-errors :errors="errorFor('password_confirmation')" ></v-errors>

                <button type="submit" :disabled="loading" class="btn btn-primary mt-3 w-100 btn-lg" @click.prevent="register">Register</button>
                <hr/>
                <div >
                    Already have account?
                    <router-link :to="{name: 'login'}" class="font-design">Login</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import ValidationError from "../shared/mixins/ValidationError";
import {logIn} from "../shared/utils/auth";


export default {
    name: "Register",
    mixins:[ValidationError],
    data() {
        return {
            user:{
                email: null,
                password: null,
                password_confirmation: null,
                name: null
            },
            loading:false
        }
    },
    methods: {
        async register() {
            this.loading = true;
            this.errors = null;
            try{
                const response = await axios.post('/register', this.user);

                if(response.status === 201) {
                    logIn();
                    await this.$store.dispatch('loadUser');
                    await this.$router.push({name: "home"})
                    await this.$store.dispatch('loadStoredState');
                }

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
