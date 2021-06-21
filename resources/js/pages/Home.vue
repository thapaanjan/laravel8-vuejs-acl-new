<template>
    <div>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Dashboard</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div
                            class="
                                d-flex
                                justify-content-end
                                align-items-center
                            "
                        >
                            <button
                                type="button"
                                class="btn btn-info d-none d-lg-block m-l-15"
                            >
                                Create New
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row d-flex">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div
                                        class="
                                            round
                                            align-self-center
                                            round-success
                                        "
                                    >
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">3564</h3>
                                        <h5 class="text-muted m-b-0">
                                            New Customers
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div
                                        class="
                                            round
                                            align-self-center
                                            round-info
                                        "
                                    >
                                        <i class="fa fa-server"></i>
                                    </div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">342</h3>
                                        <h5 class="text-muted m-b-0">
                                            New Products
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div
                                        class="
                                            round
                                            align-self-center
                                            round-danger
                                        "
                                    >
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">56%</h3>
                                        <h5 class="text-muted m-b-0">
                                            Today's Profit
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div
                                        class="
                                            round
                                            align-self-center
                                            round-success
                                        "
                                    >
                                        <i class="fa fa-server"></i>
                                    </div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">56%</h3>
                                        <h5 class="text-muted m-b-0">
                                            New Leads
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <bar-chart></bar-chart>
                                </div>
                            </div>
                            <div id="sparkline8" class="minus-mar"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <pie-chart></pie-chart>
                                </div>
                            </div>
                            <div id="sparkline8" class="minus-mar"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <doughnut-chart
                                    v-if="loaded"
                                    :chart-labels="chartLabels"
                                    :chartData="chartData"
                                    :backgroundColor="backgroundColor"
                                ></doughnut-chart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PieChart from '../components/charts/PieChart'
import DoughnutChart from '../components/charts/DoughnutChart'
import BarChart from '../components/charts/BarChart'

export default {
    components: {
        DoughnutChart,
        BarChart,
        PieChart,
    },
    data() {
        return {
            chartData: [],
            chartLabels: [],
            data: '',
            backgroundColor: [],
            loaded: false,
        }
    },
    mounted() {
        this.getAdminCount()
    },
    methods: {
        async getAdminCount() {
            const res = await this.callApi('get', 'admin/chart')
            if (res.status === 200) {
                if (res.data) {
                    this.data = res.data
                    this.data.forEach((item) => {
                        this.chartData.push(item.admins_count)
                        this.chartLabels.push(item.role_name)
                        this.backgroundColor.push(
                            '#' +
                                parseInt(Math.random() * 0xffffff).toString(16)
                        )
                    })
                    this.loaded = true
                }
            } else return this.error('Oops! SOmething went wrong.')
        },
    },
}
</script>
