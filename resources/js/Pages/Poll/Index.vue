<script setup>
import Layout from '../Shared/Layout.vue'
import { reactive, computed } from 'vue'
const props = defineProps({ polls: Array })

const baseUrl = window.location.origin

const isActive = computed(() => {
  return (expiresAt) => {
    if (!expiresAt) return false;
    return new Date(expiresAt) > new Date();
  }
})


</script>
<script>
 export default{
    layout: Layout
 }
</script>

<template>
    <div class="container" style="margin-top: 3rem">
        <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
        </div>
        <div class="mb-3">
            <h1>Your polls</h1>
        </div>

            <div v-if="polls.length > 0">
                <ul class="list-group">
                    <li class="list-group-item mb-2 d-flex justify-content-between"  v-for="poll in polls" :key="poll.id">
                         <div>
                            <h4 style="text-transform: uppercase">{{ poll.question }}</h4>
                            <div class="mb-3 mt-3 share-link">Share Url:
                                <a :href="`${baseUrl}/poll/${poll.slug}`">{{ baseUrl }}/poll/{{ poll.slug }}</a>
                            </div>
                            <!-- <div class="alert alert-primary" role="alert" style="max-width:90%">
                                <a :href="`${baseUrl}/poll/${poll.slug}`">{{ baseUrl }}/poll/{{ poll.slug }}</a>
                            </div> -->
                            <div>
                            <ul v-for="option in poll.options" :key="option.id">
                                <li><span><strong>{{ option.text }}</strong></span> - <span>{{ option.voters.length }} vote(s)</span> </li>
                            </ul>
                            <div class="mt-3 text-primary">
                              <strong>Total votes:</strong>{{ poll.total_votes }}
                            </div>
                         </div>
                         </div>
                         <div>
                            <span class="badge" :class="[isActive(poll.expires_at) ? 'text-bg-success' : 'text-bg-danger']">{{ isActive(poll.expires_at) ? 'live' : 'expired' }}</span>
                         </div>
                    </li>
                </ul>
            </div>

            <div v-else>
                <p>You have no polls yet</p>
                <a href="/poll/create">create one and share</a>
            </div>
    </div>
</template>

<style>
    .poll-wrapper-card{
        position: relative;
    }
    .badge{
        position: absolute;
        bottom:5px;
        right:5px
    }
    /* .share-link{
        background-color: #393E46;
        padding: 10px;
        border-radius: 5px;
    } */
</style>