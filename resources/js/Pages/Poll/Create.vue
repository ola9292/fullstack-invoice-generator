<script setup>
import { useForm } from '@inertiajs/vue3'
import Layout from '../Shared/Layout.vue'

const form = useForm({
  question: null,
  options: [
   {text:''}
  ],

})

const createOption = () => {
    form.options.push({text:''})
}
</script>
<script>
 export default{
    layout: Layout
 }
</script>

<template>
    <div class="container" style="margin-top: 5rem;">
        <div class="mx-auto border rounded p-4" style="width: 38rem; max-width:95%">
            <h1>Create A Poll</h1>
            <form @submit.prevent="form.post('/poll/create')">
                <!-- <input type="text" v-model="form.question">
                <div v-if="form.errors.email">{{ form.errors.email }}</div> -->

                <div class="mb-3">
                    <label for="" class="form-label">Question</label>
                    <input type="text" class="form-control" placeholder="Who is the best actor?" v-model="form.question">
                    <div class="text-danger" v-if="form.errors.question">{{ form.errors.question }}</div>
                </div>


                <div class="mb-3" v-for="(option, index) in form.options" :key="index">
                    <!-- <input type="text" v-model="option.text"> -->
                    <label for="" class="form-label">Option {{ index+1 }}</label>
                    <input type="text" class="form-control" placeholder="Eddie Morphy" v-model="option.text">
                    <div class="text-danger" v-if="form.errors.options">{{ form.errors.options }}</div>
                </div>
                <div class="mt-3 mb-3">
                    <button class="btn btn-outline-primary" @click="createOption" type="button">Add another option</button>
                </div>

                <button class="btn btn-outline-success" type="submit" :disabled="form.processing">Create Poll</button>
            </form>
        </div>
    </div>



</template>