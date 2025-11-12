<script setup>
import { useForm } from '@inertiajs/vue3'
import Layout from '../Shared/Layout.vue'
import { ref, computed } from 'vue'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

const props = defineProps({ invoice: Object })

const invoiceContent = ref(null)

//calculate subtotal
const subTotal = computed(() => {
   var sum = props.invoice.items.reduce(function(prev, cur) {
    return prev + Number(cur.amount);
    }, 0);
    return sum.toFixed(2)
})


const downloadPdf = async () => {
  const element = invoiceContent.value
  if (!element) return

  // Store original styles
  const originalWidth = element.style.width
  const originalMaxWidth = element.style.maxWidth
  const originalPosition = element.style.position

  // Force desktop width for capture
  element.style.position = 'absolute'
  element.style.width = '210mm' // A4 width
  element.style.maxWidth = '210mm'
  element.style.left = '-9999px' // Move off-screen

  // Wait for reflow
  await new Promise(resolve => setTimeout(resolve, 100))

  const canvas = await html2canvas(element, {
    scale: 2,
    useCORS: true,
    backgroundColor: '#ffffff',
    width: 794, // A4 width in pixels at 96 DPI (210mm)
  })

  // Restore original styles
  element.style.width = originalWidth
  element.style.maxWidth = originalMaxWidth
  element.style.position = originalPosition
  element.style.left = ''

  const imgData = canvas.toDataURL('image/png')
  const pdf = new jsPDF('p', 'mm', 'a4')

  const pdfWidth = pdf.internal.pageSize.getWidth()
  const pdfHeight = pdf.internal.pageSize.getHeight()
  const imgWidth = pdfWidth
  const imgHeight = (canvas.height * imgWidth) / canvas.width

  let heightLeft = imgHeight
  let position = 0

  pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight)
  heightLeft -= pdfHeight

  while (heightLeft > 0) {
    position = heightLeft - imgHeight
    pdf.addPage()
    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight)
    heightLeft -= pdfHeight
  }

  pdf.save(`invoice-${Date.now()}.pdf`)
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-GB')
}
</script>
<script>
 export default{
    layout: Layout
 }
</script>


<template>
    <div class="container" style="margin-top: 5rem; margin-bottom: 5rem">
        <div>
            <div class="d-flex mb-4 justify-content-between">
                <div>
                    <h1>Invoice Preview</h1>
                    <p>{{ invoice.invoice_number }}</p>
                    <a href="/invoices" class="btn text-white bg-dark"><i class="fa-solid fa-arrow-left"></i> Go back</a>
                </div>
                <div>
                    <button @click="downloadPdf" type="button" class="btn text-white bg-dark"><i class="fa-solid fa-download"></i> Download Pdf</button>
                </div>
            </div>
            <div class="p-4 border rounded shadow" ref="invoiceContent">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2>INVOICE</h2>
                        <p>{{ invoice.invoice_number }}</p>
                    </div>
                    <div>
                        <p>Date: {{ formatDate(invoice.date) }}</p>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <strong>From:</strong>
                        <p><strong>{{ invoice.from_name }}</strong></p>
                        <p>{{ invoice.from_email }}</p>
                    </div>
                    <div class="col">
                        <strong>To:</strong>
                        <p><strong>{{ invoice.to_name }}</strong></p>
                        <p>{{ invoice.to_email }}</p>
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
                        <tr v-for="(item, index) in invoice.items" :key="index">
                            <th scope="row">{{ item.description }}</th>
                            <td>{{ item.quantity }}</td>
                            <td>${{ item.rate }}</td>
                            <td>${{ item.amount }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col col-sm-6">

                    </div>
                    <div class="col col-sm-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>${{ subTotal }}</td>
                                </tr>
                                <tr>
                                    <td>Tax ({{ invoice.tax_rate }}%)</td>
                                    <td>${{ invoice.tax_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Discount ({{ invoice.discount_rate }}%)</td>
                                    <td>${{ invoice.discount_amount }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>${{ invoice.total_amount }}</strong></td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>