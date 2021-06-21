<script>
import { Doughnut } from 'vue-chartjs'

export default {
    extends: Doughnut,
    props: {
        chartData: {
            type: Array,
            required: true,
        },
        chartLabels: {
            type: Array,
            required: true,
        },
        backgroundColor: {
            type: Array,
            required: false,
        },
    },
    data() {
        return {
            options: {
                legend: {
                    display: true,
                },
                responsive: true,
                maintainAspectRatio: false,
            },
        }
    },
    mounted() {
        this.renderChart(
            {
                labels: this.chartLabels,
                datasets: [
                    {
                        label: 'Total No. of Role based admins',
                        backgroundColor: this.backgroundColor,
                        data: this.chartData,
                    },
                ],
            },
            this.options
        )
    },
}
</script>
