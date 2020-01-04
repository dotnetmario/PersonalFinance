import axios from 'axios';

const state = {
    incomes: {},
    income: {}
};

const getters = {
    income: (state) => state.income,
    incomes: (state) => state.incomes,
};

const actions = {
    // incomes
    async getIncomes({ commit }, data){
        const response = await axios.get(`/api/incomes/`, {
            headers: { 
                Authorization: `Bearer ${data.token}`,
                "Content-Type" : "application/json",
            }
        })
        .catch(e => {
            console.log(e)
        });

        console.log(response.data);
        commit('incomes', response.data);
    },
};

const mutations = {
    incomes: (state, incomes) => state.incomes = incomes,
};

export default {
    state, getters, actions, mutations
}