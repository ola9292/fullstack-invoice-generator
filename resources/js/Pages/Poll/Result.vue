<script setup>
import { computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({ poll: Object })

const calculateVotePercentage = (value) => {
    return ((value / props.poll.total_votes) * 100).toFixed(2)
}

</script>


<template>
    <div class="container mt-3">
        <h1>How People Have Voted</h1>
        <h3>{{ poll.question }}</h3>
        <!-- {{ totalVotes }} -->
        <div v-for="option in poll.options" :key="option.id">
            {{ option.text }}
            <div class="progress mb-2" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" :style="{'width': calculateVotePercentage(option.voters.length)+ '%'}">{{ calculateVotePercentage(option.voters.length) }}%</div>
            </div>
        </div>
        <div class="mb-2 mt-3">
            <a class="btn btn-primary me-2" href="/poll/create">Create a Poll</a>
            <Link class="btn btn-danger" href="/" method="POST">Logout</Link>
        </div>

    </div>

</template>