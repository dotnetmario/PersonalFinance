import axios from 'axios';

const state = {
    user: localStorage.getItem("user") || null,
    token: localStorage.getItem("token") || null,
};

const getters = {
    loggedIn: (state) => {
        // return state.user !== null && state.token !== null
        return state.token !== null
    },
    user: (state) => state.user,
    token: (state) => state.token,
};

const actions = {
    async login({ commit }, data) {
        const response = await axios.post(`/api/auth/login`, {
            "identifier": data['identifier'].toString(),
            "password": data['password'].toString(),
            "remember_me": data['remember_me'],
        }).catch(e => {
            console.log(e)
        });

        localStorage.setItem("user", JSON.stringify(response.data.user));
        localStorage.setItem("token", JSON.stringify(response.data.access_token));
        commit('user', response.data);
    }
};

const mutations = {
    user: (state, user) => {
        state.user = user.user;
        state.token = user.access_token;
    },
};

export default {
    state, getters, actions, mutations
}