<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Incomes</h6>


            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <button class="dropdown-item" @click="getIcomesData">Action</button>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>



        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
import areaChart from '@/js/scripts/chartsdata.js';
import { mapGetters } from 'vuex';

export default {
    name: 'area-chart',
    computed: {
        ...mapGetters(['token', 'user']),
    },
    data(){
        return {
            areaChart,
        }
    },
    methods: {
        createChart(chartId, chartData) {
            chartData.data["datasets"][0]["data"] = [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000];
            chartData.data["labels"] = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            console.log(chartData);
            const ctx = document.getElementById(chartId);
            const myChart = new Chart(ctx, {
                type: chartData.type,
                data: chartData.data,
                options: chartData.options,
            });
        },
        getIcomesData(){
            console.log("get incomes data");
            console.log(this.token);
            this.$store.dispatch("getIncomes", {
                "token" : this.token,
                "year" : 2019,
                "month" : "",
                "day" : "",
            });
        },
        // login(){
        //     this.$store.dispatch("login", {
        //         'identifier' : this.identifier,
        //         'password' : this.password,
        //         'remember_me' : this.remember_me,
        //     }).then(() => {
        //         this.$router.push({ name: 'home' });
        //     });
        // },
    },
    mounted() {
        this.createChart('myAreaChart', this.areaChart);
    }
}
</script>

<style scoped>

#myAreaChart{
    height: 100%;
}
</style>