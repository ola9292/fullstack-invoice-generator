<script setup>
import { useForm } from '@inertiajs/vue3'
import Layout from '../Shared/Layout.vue'
const props = defineProps({ poll: Object })

const form = useForm({
  poll_id: props.poll.id,
  option_id:null
})
</script>
<script>
 export default{
    layout: Layout
 }
</script>


<template>
    <div class="container" style="margin-top: 5rem">
        <div class="mx-auto border rounded p-4" style="width: 30rem; max-width:95%">
             <h1>Select your choice</h1>
            <h3>{{ poll.question }}</h3>
            <form @submit.prevent="form.post('/vote')">
                <div v-for="option in poll.options" :key="option.id">
                    <!-- <label for="">{{ option.text }}</label>
                    <input type="radio" :value="option.id" v-model="form.option_id"> -->
                    <div class="form-check">
                        <input class="form-check-input" type="radio" :value="option.id" v-model="form.option_id">
                        <label class="form-check-label" for="">
                            {{ option.text }}
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-success" type="submit">Cast Vote</button>
                </div>
            </form>
        </div>
    </div>

</template>