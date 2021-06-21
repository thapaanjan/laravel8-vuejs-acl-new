<script>
// Can be done by calling api in chart vue component itself like done in this chart component.
// Or can be done using props from home component to child component
import { Pie } from 'vue-chartjs'

export default {
    extends: Pie,
    data() {
        return {
            role_count: [],
            labels: [],
            data: '',
            backgroundColor: [],
        }
    },
    mounted() {
        this.getChart()
    },
    methods: {
        getChart() {
            axios.get('/api/v1/admin/chart').then((response) => {
                this.data = response.data
                if (this.data) {
                    this.data.forEach((item) => {
                        this.role_count.push(item.admins_count)
                        this.labels.push(item.role_name)
                        this.backgroundColor.push(
                            '#' +
                                parseInt(Math.random() * 0xffffff).toString(16)
                        )
                    })
                    this.renderChart(
                        {
                            labels: this.labels,
                            datasets: [
                                {
                                    label: 'Total No. of admin based on Roles',
                                    backgroundColor: this.backgroundColor,
                                    data: this.role_count,
                                },
                            ],
                        },
                        {
                            options: {
                                legend: {
                                    display: true,
                                },
                                pieHole: 0.5,
                                is3D: true,
                                pieStartAngle: 100,
                            },
                        },
                        { responsive: true, maintainAspectRatio: false }
                    )
                } else {
                    console.log('No data found')
                }
            })
        },
    },
}
</script>
