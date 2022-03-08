<template>
    <div>
        <div class="invalid-feedback" :class="errors ? 'd-block': ''"
             v-for="(error,index) in errors"
             :key="'content'+ index"
        >
            {{error}}
        </div>
    </div>
</template>

<script>
export default {
    name: "ValidationError",
    props: ['errors'],
    data() {
        return {
            displayErrorBlock: false
        }
    }
}
</script>

<style scoped>

</style>
