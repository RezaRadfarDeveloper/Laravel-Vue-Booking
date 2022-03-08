<template>
    <div class="row">
        <fatal-error v-if="error"></fatal-error>
        <success v-if="successful">
            You have left a review! Thank you.
        </success>
        <div v-if="!successful && !error" class="row">
            <div :class="[{'col-md-4': twoColumns},{'d-none': oneColumn}]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading ...</div>
                        <div v-if="hasBooking">
                            <p> You stayed at
                                <router-link :to="{name: 'bookable',params:{id: booking.bookable.bookable_id}}">{{booking.bookable.title}}</router-link>
                            </p>
                            <p> From {{booking.from}} to {{booking.to}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'col-md-8': twoColumns},{'col-md-12': oneColumn}]">
                <div v-if="loading">Loading ...</div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        You have already left review
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted"> Select your Rating(1 the worth and 5 the best)</label>
                            <star-rating :rating="review.rating" @rating:changed="onRatingChanged" class="fa-3x"></star-rating>
                        </div>
                        <div class="form-group">
                            <label id="content" class="text-muted"> Put your review here:</label>
                            <textarea name="content"
                                      cols="30" rows="10"
                                      class="form-control"
                                      v-model="review.content"
                                      :class="{'is-invalid': this.errorFor('content')}"
                            >
                            </textarea>
                            <v-errors :errors="errorFor('content')"></v-errors>
                        </div>
                        <button class="btn-lg btn-primary w-100 mt-3" @click.prevent="submit" :disabled="sending">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {is404, is422} from './../shared/utils/response';
import ValidationError from "../shared/mixins/ValidationError";
export default {
    mixins: [ValidationError],
    name: "Review",
    data() {
        return {
            review: {
                id: null,
                rating: 5,
                content: null
            },
            loading: false,
            existingReview: null,
            booking: null,
            error: false,
            sending: false,
            successful: false
        }
    },
    created() {
        this.loading= true;
        this.review.id = this.$route.params.id
        axios.get(`/api/reviews/${this.review.id}`).
        then(response => {
                this.existingReview = response.data.data;
        }).catch( error => {
                if(is404(error))
                {
                  return axios.get(`/api/booking-by-review/${this.review.id}`)
                      .then(response => {
                          this.booking = response.data.data;
                      }).catch(error => {
                              this.error = !is404(error);
                      });
                }
                this.error = true;
        }).then(() => this.loading = false)
    },
    computed: {
        alreadyReviewed()
        {
            return this.hasReview || !this.booking;
        },
        hasReview() {
            return this.existingReview !== null;
        },
        hasBooking() {
            return this.booking !== null;
        },
        oneColumn() {
           return  !this.loading && this.alreadyReviewed
        },

        twoColumns() {
            return this.loading || !this.alreadyReviewed
        }
    },
    methods: {
        onRatingChanged(rating) {
            this.review.rating = rating;
        },
        submit() {
            this.sending = true;
            this.errors = null;
            this.successful = false;
            axios.post('/api/reviews',this.review)
            .then(response => this.successful = 201 === response.status)
            .catch(err => {
                if(is422(err)) {
                    const errors = err.response.data.errors;
                    if(errors['content'] && 1 === _.size(errors)) {
                        this.errors = errors;
                        return;
                    }

                }
                this.error = true;

            })
            .then(() => this.sending = false)
        }
    }
}
</script>

<style scoped>

</style>
