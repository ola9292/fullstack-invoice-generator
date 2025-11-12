<script setup>
import Layout from '../Shared/Layout.vue'
import { useForm, Link } from '@inertiajs/vue3'
const props = defineProps({ invoices: Array })

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
        <div class="mt-4">
            <div v-if="invoices.length > 0">
                <div class="card mb-2" v-for="invoice in invoices" :key="invoice.id">
                    <h5 class="card-header">{{ invoice.invoice_number }}</h5>
                    <div class="card-body">
                        <h5 class="card-title">From: {{ invoice.from_name }} - To: {{ invoice.to_name }}</h5>
                        <p class="card-text">{{ invoice.from_email }}</p>
                        <div>
                            <a :href="`invoice/${invoice.invoice_number}`" class="btn btn-primary me-2 mb-2"><i class="fa-solid fa-eye"></i> Preview</a>
                            <Link :href="`invoice/${invoice.id}/delete`" class="btn btn-danger me-2 mb-2" method="POST"><i class="fa-solid fa-trash-can"></i> Delete</Link>
                            <Link :href="`send-invoice/${invoice.invoice_number}`" class="btn btn-success mb-2"><i class="fa-solid fa-inbox"></i> Send Invoice</Link>
                        </div>

                    </div>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-dark" role="alert">
                    You have no invoices!
                </div>
            </div>
        </div>

    </div>



</template>