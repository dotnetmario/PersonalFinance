<template>
    <div id="login" class="row">
        <h1 class="text-center col-12">Welcome!</h1>
        <div class="col-12">
            <login-form class="mx-auto login-form"></login-form>
        </div>
    </div>
</template>

<script>
import LoginForm from '@/js/components/LoginForm';

export default {
    name : 'Login',
    components: {
        'login-form': LoginForm,
    },
    data() {
        return {
            username: '',
            password: '',
        }
    },
    methods: {
        prependClicked() {
            console.log('prepend clicked');
        },
        appendClicked() {
            console.log('append clicked', this.username);
        }
    },
}
</script>

<style scoped>
    .login-form{
        max-width: 500px;
    }
    .submit{
        background-color: "red" !important;
    }
</style>
