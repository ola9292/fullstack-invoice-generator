<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  email: null,
  first_name: null,
  last_name: null,
  age_range:'',
  consent:false,
  agree_terms: false
})
</script>

<template>
    <div class="container">
        <h2>Sign Up Form</h2>
        <form  class="max-w-sm mx-auto" @submit.prevent="form.post('/signup')">
            <div class="mb-5">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                <input v-model="form.first_name" type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required />
                 <div v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
            </div>
            <div class="mb-5">
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                <input v-model="form.last_name" type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Doe" required />
                 <div v-if="form.errors.last_name">{{ form.errors.last_name }}</div>
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input v-model="form.email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required />
                 <div v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>
            <div class="mb-5">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age Range</label>
                <select v-model="form.age_range" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>-- select age --</option>
                    <option value="over-18">over 18</option>
                    <option value="under-18">under 18</option>
                </select>
                <div v-if="form.errors.age_range">{{ form.errors.age_range }}</div>
            </div>
            <div class="mb-5" v-if="form.age_range == 'over-18'">
                <div class="flex items-center mb-4">
                    <input v-model="form.consent" checked id="checkbox-1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                    <label for="checkbox-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I consent.</label>
                     <div v-if="form.errors.consent">{{ form.errors.consent }}</div>
                </div>
            </div>
            <div class="mb-5">
                <div class="flex items-center mb-4">
                    <input v-model="form.agree_terms" checked id="checkbox-1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                    <label for="checkbox-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I agree to <a href="/terms" class="text-blue-600 hover:underline dark:text-blue-500">terms and conditions</a>.</label>
                     <div v-if="form.errors.agree_terms">{{ form.errors.agree_terms }}</div>
                </div>
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>

    </div>

</template>