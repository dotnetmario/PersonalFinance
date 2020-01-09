<template>
    <div id="wrapper">
        <sidebar 
            v-if="this.loggedIn"
        ></sidebar>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <navbar 
                    v-if="this.loggedIn"
                ></navbar>
                <div class="container-fluid">
                    <router-view class="content"></router-view>
                </div>
            </div>
        </div>
        <a class="scroll-to-top rounded" @click="scrollToTop">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
</template>

<script>
// import chart.js
import Chart from 'chart.js';
import Sidebar from '@/js/components/Sidebar';
import Navbar from '@/js/components/Navbar';

export default {
    name: 'app',
    computed: {
        loggedIn(){
            return this.$store.getters.loggedIn;
        }
    },
    components: {
        'sidebar' : Sidebar,
        'navbar' : Navbar,
    },
    created(){
        if(!this.loggedIn){
            this.$router.push({ name: 'login' });
        }
    },
    methods: {
        scrollToTop(){
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        }
    }
}
</script>

<style lang="css">
    :root {
        --input-padding-x: 1.5rem;
        --input-padding-y: .75rem;
        --c-purple: #9C27B0;
        --c-red: #F44336;
        --c-blue: #3F51B5;
        --c-green: #009688;
        --c-yellow : #FFC107;
        --c-gray : #E0E0E0;
    }
    /**
     * main style
     */
    
    /**
     * Colors
     * from Vuetify color palette
     * red
     * purple
     * blue
     */
    .c-purple{
        background-color: #9C27B0;
    }
    .c-red{
        background-color: #F44336;
    }
    .c-blue{
        background-color: #3F51B5;
    }
    .c-green{
        background-color: #009688;
    }
    .c-yellow{
        background-color: #FFC107;
    }
    .c-gray{
        background-color: #E0E0E0;
    }
    
    .btn {
        color: #FFF;
    }
</style>