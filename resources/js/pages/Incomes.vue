<template>
	<div id="incomes">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
		</div>

		<div class="col-12">
			<area-chart></area-chart>
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
import { mapActions } from 'vuex';
import AreaChart from '@/js/components/charts/AreaChart.vue';

export default {
	name: 'incomes',
	components: {
		'area-chart' : AreaChart,
	},
	computed: {
		...mapGetters(['incomes']),
		...mapGetters(['user']),
	},
	methods: {
		// ...mapActions(['getIncomes']),
		...mapActions('company', ['getIncomes'])
	},
	created() {
		// console.log(this.user, this.user.user['access_token']);
		this.$store.dispatch('getIncomes', {
			token: this.user.user['access_token'],
		});
  	}
}
</script>

<style scoped>
	#incomes{
		height: 1200px;
	}
</style>