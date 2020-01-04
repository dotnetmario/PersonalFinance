<template>
    <div id="register" class="row">
        <h1 class="text-center col-12">Crete an Account!</h1>
        <div class="col-12">
            <register-form class="mx-auto register-form"></register-form>
        </div>
    </div>
</template>

<script>
import RegisterForm from '@/js/components/RegisterForm';
export default {
    name: 'register',
    components: {
        'register-form' : RegisterForm,
    },
}
</script>

<style scoped>
    .register-form{
        max-width: 500px;
    }
</style>