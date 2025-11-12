<script setup>
import { useForm } from '@inertiajs/vue3'
import Layout from '../Shared/Layout.vue'
import { computed, ref } from 'vue'

const showPreview = ref(false)
const form = useForm({
  invoice_number: null,
  date:null,
  from_name:null,
  to_name:null,
  from_email:null,
  to_email:null,
  items: [
   {
    description:'',
    quantity:0,
    rate:0,
    amount:0
   }
  ],
   tax_rate:0,
   discount_rate:0,
   tax_amount: 0,
   discount_amount : 0,
   sub_total :0,
   total_amount :0
})

const handleAddItem = () => {
    form.items.push(
        {
            description:'',
            quantity:0,
            rate:0,
            amount:0
        }
    )
}
const handleItemDelete = (index) => {
    form.items.splice(index, 1)
}

 //calculate item total
const calculateTotal = (index) => {
    const item = form.items[index]
    if (!item.quantity || item.quantity < 0) item.quantity = 0;
    if (!item.rate || item.rate < 0) item.rate = 0;
    const result = item.quantity * item.rate;
    item.amount = result;
}

//calculate subtotal
const subTotal = computed(() => {
   var sum = form.items.reduce(function(prev, cur) {
    return prev + Number(cur.amount);
    }, 0);
    form.sub_total = sum.toFixed(2)
    return sum.toFixed(2)
})

//calculate tax
const calculateTax = computed(() => {
    let result = 0
    if(form.tax_rate <= 0){
        form.tax_amount = 0
        return 0;
    }
    result = ((Number(form.tax_rate) / 100) * Number(subTotal.value)).toFixed(2)
    form.tax_amount = result
   return result
})

//calculate discount
const calculateDiscount = computed(() => {
    let result = 0
   if(form.discount_rate <= 0){
    form.discount_amount = 0
    return 0;
   }
   result = ((Number(form.discount_rate) / 100) * Number(subTotal.value)).toFixed(2)
   form.discount_amount = result
   return result
})

//calculate sum total
const calculateSumTotal = computed(() => {
    let result = 0
    result = ((Number(subTotal.value) + Number(calculateTax.value)) - Number(calculateDiscount.value)).toFixed(2)
    form.total_amount = result
    return result
})

//preview
const handleShowPreview = () => {
    showPreview.value = !showPreview.value
}

</script>
<script>
 export default{
    layout: Layout
 }
</script>
<template>
    <div class="container mt-4">
        <Transition mode="out-in">
            <div class="main" v-if="!showPreview">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1>Invoice Generator</h1>
                        <p>Create professional invoices quickly</p>
                    </div>
                    <div>
                        <button @click="handleShowPreview" type="button" class="btn text-white bg-dark"><i class="fa-solid fa-eye"></i> Preview</button>
                    </div>
                </div>
                <form @submit.prevent="form.post('/invoice/create')">
                    <!-- invoice details -->
                    <div class="border rounded p-4 shadow mb-4">
                        <h4>Invoice Details</h4>
                        <div class="row mt-4">
                            <div class="col">
                                <label for="email" class="form-label">Invoice Number</label>
                                <input name="form.invoice_number" type="text" class="form-control" placeholder="INV-XXXXXXXX" v-model="form.invoice_number">
                                 <div class="text-danger" v-if="form.errors.invoice_number">{{ form.errors.invoice_number }}</div>
                            </div>
                            <div class="col">
                                <label for="email" class="form-label">Date</label>
                                <input name="form.date" type="date" class="form-control" aria-label="Last name" v-model="form.date">
                                 <div class="text-danger" v-if="form.errors.date">{{ form.errors.date }}</div>
                            </div>
                        </div>
                    </div>

                    <!--  from & to -->
                    <div class="border rounded p-4 shadow mb-4">
                        <h4>From & To</h4>
                        <div class="row mt-4">
                            <div class="col">
                                <p>From(Your details)</p>
                                <label for="email" class="form-label">Name</label>
                                <input name="form.from_name" type="text" class="form-control" placeholder="John Doe" v-model="form.from_name">
                                 <div class="text-danger" v-if="form.errors.from_name">{{ form.errors.from_name }}</div>
                            </div>
                            <div class="col">
                                <p>To(Client details)</p>
                                <label for="email" class="form-label">Name</label>
                                <input name="form.to_name" type="text" class="form-control" placeholder="Jason Polanco" aria-label="Las" v-model="form.to_name">
                                 <div class="text-danger" v-if="form.errors.to_name">{{ form.errors.to_name }}</div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <input name="form.from_email" type="email" class="form-control" placeholder="johndoe@gmail.com" v-model="form.from_email">
                                 <div class="text-danger" v-if="form.errors.from_email">{{ form.errors.from_email }}</div>
                            </div>
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <input name="form.to_email" type="email" class="form-control" placeholder="mariahcarey@gmail.com" v-model="form.to_email">
                                 <div class="text-danger" v-if="form.errors.to_email">{{ form.errors.to_email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- invoice items -->
                    <div class="border rounded p-4 shadow mb-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Invoice Items</h4>
                            </div>
                            <div>
                                <button type="button" @click="handleAddItem" class="btn text-white bg-dark"><i class="fa-solid fa-plus"></i> Add Item</button>
                            </div>
                        </div>
                        <div style="overflow-x: auto;">
                            <div class="row mt-4" style="min-width: 800px; flex-wrap: nowrap;" v-for="(item, index) in form.items" :key="index">
                                <div class="col col-sm-4">
                                    <label for="email" class="form-label">Description</label>
                                    <input name="item.description" type="text" class="form-control" placeholder="printing" aria-label="First name" v-model="item.description">
                                    <div class="text-danger" v-if="form.errors[`items.${index}.description`]">
                                        {{ form.errors[`items.${index}.description`] }}
                                    </div>
                                </div>
                                <div class="col col-sm-2">
                                    <label for="email" class="form-label">Quantity</label>
                                    <input name="item.quantity" @input="calculateTotal(index)" type="number" class="form-control" aria-label="Last name" v-model="item.quantity">
                                     <div class="text-danger" v-if="form.errors[`items.${index}.quantity`]">
                                        {{ form.errors[`items.${index}.quantity`] }}
                                    </div>
                                </div>
                                <div class="col col-sm-2">
                                    <label for="email" class="form-label">Rate</label>
                                    <input name="item.rate" @input="calculateTotal(index)" type="number" step="any" class="form-control" aria-label="Last name" v-model="item.rate">
                                    <div class="text-danger" v-if="form.errors[`items.${index}.rate`]">
                                        {{ form.errors[`items.${index}.rate`] }}
                                    </div>
                                </div>
                                <div class="col col-sm-2">
                                    <label for="email" class="form-label">Amount</label>
                                    <input name="item.amount" type="number" class="form-control" aria-label="Last name" v-model="item.amount">
                                </div>
                                <div class="col col-sm-2 align-content-end">
                                    <button type="button" class="btn btn-danger" @click="handleItemDelete(index)"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax, discounts & total -->
                    <div class="border rounded p-4 shadow mb-4">
                        <h4>Tax, Discounts & Total</h4>
                        <div class="row mt-4">
                            <div class="col col-sm-6">
                                <div class="mb-2">
                                    <label for="email" class="form-label">Tax Rate (%)</label>
                                    <input type="text" class="form-control" placeholder="" v-model="form.tax_rate">
                                     <div v-if="form.errors.tax_rate">{{ form.errors.tax_rate }}</div>
                                </div>

                                <div>
                                    <label for="email" class="form-label">Discount (%)</label>
                                    <input type="text" class="form-control" placeholder="" v-model="form.discount_rate">
                                     <div v-if="form.errors.discount_rate">{{ form.errors.discount_rate }}</div>
                                </div>
                            </div>
                            <div class="col col-sm-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>${{ subTotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax ({{ form.tax_rate }}%)</td>
                                            <td>${{ calculateTax }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount ({{ form.discount_rate }}%)</td>
                                            <td>${{ calculateDiscount }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td><strong>${{ calculateSumTotal }}</strong></td>
                                        </tr>
                                        </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="my-4">
                        <button class="btn btn-outline-success" type="submit">Save Invoice</button>
                    </div>
                </form>


            </div>
            <!-- preview section -->
            <div class="preview" v-else>
                <div class="d-flex mb-4 justify-content-between">
                    <div>
                        <h1>Invoice Preview</h1>

                    </div>
                    <div>
                        <button @click="handleShowPreview" type="button" class="btn text-white bg-dark"><i class="fa-solid fa-arrow-left"></i> Back to edit</button>
                    </div>
                </div>
                <div class="p-4 border rounded shadow">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2>INVOICE</h2>
                            <p>{{ form.invoice_number }}</p>
                        </div>
                        <div>
                            <p>Date {{ form.date }}</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col">
                            <strong>From:</strong>
                            <p><strong>{{ form.from_name }}</strong></p>
                            <p>{{ form.from_email }}</p>
                        </div>
                        <div class="col">
                            <strong>To:</strong>
                            <p><strong>{{ form.to_name }}</strong></p>
                            <p>{{ form.to_email }}</p>
                        </div>
                    </div>

                    <table class="table mt-4">
                        <thead>
                            <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.items" :key="index">
                                <th scope="row">{{ item.description }}</th>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.rate }}</td>
                                <td>{{ item.amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mt-4">
                        <div class="col col-sm-6">
                            <!-- <div class="mb-2">
                                <label for="email" class="form-label">Tax Rate (%)</label>
                                <input type="text" class="form-control" placeholder="" v-model="form.tax_rate">
                            </div>

                            <div>
                                <label for="email" class="form-label">Discount (%)</label>
                                <input type="text" class="form-control" placeholder="" v-model="form.discount_rate">
                            </div> -->
                        </div>
                        <div class="col col-sm-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>${{ subTotal }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tax ({{ form.tax_rate }}%)</td>
                                        <td>${{ calculateTax }}</td>
                                    </tr>
                                    <tr>
                                        <td>Discount ({{ form.discount_rate }}%)</td>
                                        <td>${{ calculateDiscount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>${{ calculateSumTotal }}</td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style>
    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.5s ease;
        }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
        }
</style>