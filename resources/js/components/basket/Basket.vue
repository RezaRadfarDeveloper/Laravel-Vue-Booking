<template><success v-if="success"> Congratulations! you have successfully booked with Us.</success>
<div class="row" v-else>
    <div class="col-md-8" v-if="itemsInBasket">
        <div class="row">
            <div class="col-md-6 form-group">
                <label id="first_name">First name</label>
                <input type="text"
                       name="first_name"
                       class="form-control"
                       v-model="customer.first_name"
                       :class="{'is-invalid': this.errorFor('customer.first_name')}"
                >
                <v-errors :errors="errorFor('customer.first_name')"></v-errors>
            </div>
            <div class="col-md-6 form-group">
                <label id="last_name">Last name</label>
                <input type="text" name="last_name" class="form-control" v-model="customer.last_name"
                :class="{'is-invalid': this.errorFor('customer.last_name')}">
                <v-errors :errors="errorFor('customer.last_name')"></v-errors>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label id="email">Email</label>
                <input type="text" name="email" class="form-control" v-model="customer.email"
                :class="{'is-invalid': this.errorFor('customer.email')}">
                <v-errors :errors="errorFor('customer.email')"></v-errors>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label id="street">Street</label>
                <input type="text" name="street" class="form-control" v-model="customer.street"
                :class="{'is-invalid': this.errorFor('customer.street')}">
                <v-errors :errors="errorFor('customer.street')"></v-errors>
            </div>
            <div class="col-md-6 form-group">
                <label id="city">City</label>
                <input type="text" name="city" class="form-control" v-model="customer.city"
                :class="{'is-invalid': this.errorFor('customer.city')}">
                <v-errors :errors="errorFor('customer.city')"></v-errors>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label id="country">Country</label>
                <input type="text" name="country" class="form-control" v-model="customer.country"
                :class="{'is-invalid': this.errorFor('customer.country')}">
                <v-errors :errors="errorFor('customer.country')"></v-errors>
            </div>
            <div class="col-md-4">
                <label id="state">state</label>
                <input type="text" name="state" class="form-control" v-model="customer.state"
                :class="{'is-invalid': this.errorFor('customer.state')}">
                <v-errors :errors="errorFor('customer.state')"></v-errors>
            </div>
            <div class="col-md-2">
                <label id="zip">zip</label>
                <input type="text" name="zip" class="form-control" v-model="customer.zip"
                :class="{'is-invalid': this.errorFor('customer.zip')}">
                <v-errors :errors="errorFor('customer.zip')"></v-errors>
            </div>
        </div>
        <hr>
        <div class="row">
            <button type="submit" class="btn btn-lg w-100 btn-primary" @click.prevent="book">Submit</button>
        </div>
    </div>
    <div class="col-md-8" v-else>
        <div class="p-5 h-100 bg-info w-100 text-center border rounded-3">
            <h2>Empty</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex justify-content-between">
            <h6 class="text-uppercase text-secondary">your cart</h6>
            <h6 class="badge bg-secondary text-uppercase">
                <span v-if="itemsInBasket">{{itemsInBasket}}</span>
                <span v-else>Empty</span>
            </h6>
        </div>
        <transition-group name="fade" >
            <div v-for="item in basket" :key="item.bookable.id">
                <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                    <router-link :to="{name:'bookable', params:{id:item.bookable.id}}">{{item.bookable.title}}</router-link>
                    <span>${{item.price.total}}</span>
                </div>
                <div class="pt-2 pb-2 d-flex justify-content-between">
                    <span>From:  {{item.dates.from}}</span>
                    <span>To:  {{item.dates.to}}</span>
                </div>
                <div class="pt-2 pb-2 d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-secondary"
                            @click="$store.dispatch('removeFromBasket',item.bookable.id)"
                    :disabled="loading">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </transition-group>
    </div>
</div>
</template>

<script>
import {mapGetters, mapState} from 'vuex';
import ValidationError from "../shared/mixins/ValidationError";

export default {
    name: "Basket",
    mixins : [ValidationError],
    data() {
        return {
            loading: false,
            bookingAttempted: false,
            customer: {
                first_name: null,
                last_name: null,
                email: null,
                street: null,
                state: null,
                zip: null,
                country: null,
                city: null
            }
        }
    },
    computed: {
        ...mapGetters(['itemsInBasket']),
        ...mapState({
           basket:  state => state.basket.items
        }),
        success() {
          return   !this.loading && this.itemsInBasket === 0 && this.bookingAttempted;
        }

    },
    methods: {
        async book() {
            this.loading = true;
            this.errors = null;
            try{
              await axios.post(`/api/checkout`, {
                    'customer': this.customer,
                    'bookings': this.basket.map(function (basketItem) {
                        return {
                            'bookable_id': basketItem.bookable.id,
                            'from': basketItem.dates.from,
                            'to': basketItem.dates.to
                        }
                    })
                });
              this.$store.dispatch('emptyBasket')
                this.bookingAttempted =true;
            } catch(err) {
                this.errors = err.response && err.response.data.errors;
            }
            this.loading = false;
        }
    }
}
</script>

<style scoped>
h6.badge {
    font-size: 100%;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}

</style>
