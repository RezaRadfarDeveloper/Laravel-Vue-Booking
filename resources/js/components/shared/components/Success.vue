<template>
    <div class="text-center error">
        <i class="fa-solid fa-thumbs-up"></i>
        <h1 class="mt-4">SuccessFul operation!</h1>
        <h2><slot></slot></h2>
    </div>
</template>

<script>
export default {
    name: "Success"
}
</script>
<style scoped>

.error {
    color: #999;
    font-size: 10rem;
}
</style>
