<script setup>
import Layout from './Shared/Layout.vue'

</script>

<script>
 export default{
    layout: Layout
 }
</script>


<template>
    <div class="container">
        <div v-if="$page.props.flash.message" class="alert alert-success mt-3" role="alert">
            {{ $page.props.flash.message }}
        </div>

        <div class="px-4 py-5 my-5 text-center">
            <img
                class="d-block mb-4 mx-auto"
                src="../images/invoice.png"
                alt="Voting box"
                width="100"
                height="100"
                />

            <h1 class="display-5 fw-bold text-black">
                Welcome!
            </h1>

            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">
                Easily create polls, share unique links, and collect votes in real time.
                Sign up in seconds, design your poll with custom options, and send it to
                friends, colleagues, or your audience. Voters register, vote and see results instantly.
                </p>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="/invoice/create" v-if="$page.props.isLoggedIn" type="button" class="btn btn-primary btn-lg px-4 gap-3">
                    Create Invoice
                </a>
                <a href="/login" v-if="!$page.props.isLoggedIn" type="button" class="btn btn-outline-secondary btn-lg px-4">
                    Login
                </a>
                </div>
            </div>
        </div>
    </div>



</template>