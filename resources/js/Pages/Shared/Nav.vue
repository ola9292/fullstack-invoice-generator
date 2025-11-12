<script setup>
import { Link } from '@inertiajs/vue3'

import { ref } from 'vue';

</script>

<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Fast Invoice</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/invoice/create">Create Invoice</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/invoices">Invoices</a>
                </li>
                <li class="nav-item">
                <Link method="POST" class="nav-link" href="/payment">Payment</Link>
                </li>
            </ul>
            <span class="navbar-text">
                <li class="nav-link" v-if="$page.props.isLoggedIn">
                    <Link href="/logout" class="btn btn-danger" method="POST">Logout</Link>
                </li>
                <li class="nav-link" v-if="!$page.props.isLoggedIn">
                    <a href="/login" class="btn btn-success">Login</a>
                </li>
            </span>
            </div>
        </div>
    </nav>
</template>
<style scoped>

/* .main-menu{
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #737373;
    padding: 10px 20px;

    position: relative;
    color:#ffffff;
}
.main-menu > ul{
    display: flex;
    gap:6px;
    align-items: center;
}
.main-menu > ul > li{
    list-style-type: none;
}
.hambuger{
    display: none;
    color:red;
    z-index: 1000;
}
.mobile-menu{
    position: absolute;
    background-color: #737373;
    top:0;
    left:0;
    width: 100%;
    height: 100svh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.mobile-menu > ul {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap:20px;
}
a{
    text-decoration: none;
    text-transform: capitalize;
    color:#ffffff
}
header{
    display: flex;
    align-items: center;
    gap:8px;
}
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
@media only screen and (max-width: 740px) {
    .hambuger{
        display: block;
    }
    .main-menu > ul{
        display: none;

    }
  } */
</style>
