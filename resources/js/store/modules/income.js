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
    async getIncomes({ commit }, data){
        const response = await axios.post(`/api/incomes/`, {
            "year": data['year'].toString(),
            "month": data['month'].toString(),
            "day": data['day'].toString(),
        }, {
            headers: { 
                Authorization: `Bearer ${data.token}`,
                "Content-Type" : "application/json",
            },
        })
        .catch(e => {
            console.log(e)
        });
        commit('incomes', response.data);
    },
};

const mutations = {
    incomes: (state, incomes) => state.incomes = incomes,
};

export default {
    state, getters, actions, mutations
}