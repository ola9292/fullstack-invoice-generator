<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name:null,
    email: null,
    password: null,
})
</script>

<template>
    <div class="container mt-4">
         <h1 class="text-center">Register</h1>
     <div class="border p-4 mx-auto" style="width: 28rem; max-width:95%">
        <form class="form-input" @submit.prevent="form.post('/register')">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="john doe" v-model="form.name">
                    <div class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="johndoe@example.com" v-model="form.email">
                    <div class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" v-model="form.password">
                    <div class="text-danger" v-if="form.errors.password">{{ form.errors.password }}</div>
                </div>
                <div class="mt-3 mb-3">
                    <button class="btn btn-outline-success" type="submit" :disabled="form.processing">Register</button>
                </div>
            </form>
    </div>
    </div>


</template>
