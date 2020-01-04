import Vuex from 'vuex';
import Vue from 'vue';
import User from '@/js/store/modules/user';
import Income from '@/js/store/modules/income';

// load Vuex
Vue.use(Vuex);

// Create store
export default new Vuex.Store({
    modules: {
        User,
        Income,
    }
});
