<template>
    <div class="card p-5 bg-transparent">
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                :class="{ 'input-error' : firstname_err }"
                placeholder="Firstname (required)"
                v-model="firstname"
            >
        </div>
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                placeholder="Lastname"
                v-model="lastname"
            >
        </div>
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                :class="{ 'input-error' : email_err }"
                placeholder="Email (required)"
                v-model="email"
            >
        </div>
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                :class="{ 'input-error' : password_err }"
                placeholder="Password (required)"
                v-model="password"
            >
        </div>
        <div class="form-group">
            <input 
                type="text"
                class="form-control"
                :class="{ 'input-error' : re_password_err }"
                placeholder="Re-Password (required)"
                v-model="re_password"
            >
        </div>
        <input type="button" class="btn btn-block c-blue" value="Register" @click="register" >
        <input type="button" class="btn btn-block c-green" value="Already have an account!?" @click="login" >
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'RegisterForm',
    data() {
        return {
            firstname: null,
            lastname: null,
            email: null,
            password: null,
            re_password: null,

            firstname_err: false,
            email_err: false,
            password_err: false,
            re_password_err: false,
            valid_inputs: false,

            posts: null,
        }
    },
    methods: {
        register(){
            this.validate();
            if(this.valid_inputs){
                axios.post(`/api/auth/register`, {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.re_password,
                }).then(response => {
                    // JSON responses are automatically parsed.
                    this.posts = response.data
                    console.log(response);
                    console.log(this.posts);
                }).catch(e => {
                    console.log(e);
                });
            }
        },
        login(){
            this.$router.push({ name: 'login' });
        },
        validate(){
            if(this.firstname == "" || this.firstname == null){
                this.firstname_err = true;
                this.valid_inputs = false;
            }else{
                this.firstname_err = false;
                this.valid_inputs = true;
            }

            if(this.email == "" || this.email == null){
                this.email_err = true;
                this.valid_inputs = false;
            }else{
                this.email_err = false;
                this.valid_inputs = true;
            }

            if(this.password == "" || this.password == null || this.re_password == "" || this.re_password == null){
                this.password_err = true;
                this.re_password_err = true;
                this.valid_inputs = false;
            }else if(this.password != this.re_password){
                this.password_err = true;
                this.re_password_err = true;
                this.valid_inputs = false;
            }else{
                this.password_err = false;
                this.re_password_err = false;
                this.valid_inputs = true;
            }
        }
    },
}
</script>

<style scoped>
    .input-error{
        border-color: var(--c-red);
    }
</style>