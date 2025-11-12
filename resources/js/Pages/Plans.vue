<script setup>
import { useForm } from '@inertiajs/vue3'
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
            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center g-4" style="margin-top: 5rem">
                <!-- Free Plan -->
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm h-100">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Free</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title">
                        £0<small class="text-body-secondary fw-light">/mo</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                        <li>2 Polls included</li>
                        <!-- <li>2 GB of storage</li> -->
                        <li>Email support</li>
                        <li>Help center access</li>
                        </ul>
                        <!-- <button type="button" class="w-100 btn btn-lg btn-outline-primary mt-auto">
                        Sign up for free
                        </button> -->
                        <a href="/checkout/free" class="w-100 btn btn-lg btn-outline-primary mt-auto">Start for free</a>
                    </div>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm h-100">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Pro</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title">
                        £10<small class="text-body-secondary fw-light">/mo</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                        <li>5 polls included</li>
                        <!-- <li>10 GB of storage</li> -->
                        <li>Priority email support</li>
                        <li>Help center access</li>
                        </ul>
                        <!-- <button type="button" class="w-100 btn btn-lg btn-primary mt-auto">
                        Get started
                        </button> -->
                         <a href="/checkout/pro" class="w-100 btn btn-lg btn-outline-primary mt-auto">Start for free</a>
                    </div>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-primary h-100">
                    <div class="card-header py-3 text-bg-primary border-primary">
                        <h4 class="my-0 fw-normal text-white">Enterprise</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title">
                        £20<small class="text-body-secondary fw-light">/mo</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                        <li>Unlimited polls included</li>
                        <!-- <li>15 GB of storage</li> -->
                        <li>Phone and email support</li>
                        <li>Help center access</li>
                        </ul>
                        <!-- <button type="button" class="w-100 btn btn-lg btn-primary mt-auto">
                        Contact us
                        </button> -->
                         <a href="/checkout/enterprise" class="w-100 btn btn-lg btn-outline-primary mt-auto">Start for free</a>
                    </div>
                    </div>
                </div>
            </div>
    </div>
</template>