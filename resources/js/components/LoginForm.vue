<template>
    <div class="card p-5 bg-transparent">
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                placeholder="Email or phone"
                v-model="identifier"
            >
        </div>
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                placeholder="Password"
                v-model="password"
            >
        </div>
        <label>
            <input type="checkbox" v-model="remember_me">Remember-me
        </label>
        <input type="button" class="btn btn-block c-blue" value="Login" @click="login" >
        <input type="button" class="btn btn-block c-green" value="Register" @click="register" >
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
// import { mapActions } from 'vuex';

export default {
    name: 'LoginForm',
    computed: mapGetters(['user']),
    data() {
        return {
            identifier: "omar@email.com",
            password: "123456789",
            remember_me: false,
            data: null,
        }
    },
    methods: {
        login(){
            this.$store.dispatch("login", {
                'identifier' : this.identifier,
                'password' : this.password,
                'remember_me' : this.remember_me,
            }).then(() => {
                this.$router.push({ name: 'home' });
            });
        },
        register(){
            this.$router.push({ name: 'register' });
        }
    },
}
</script>