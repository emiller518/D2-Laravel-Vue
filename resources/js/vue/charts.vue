<template>



    <Line
        v-if="loaded"
        :chart-data="chartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
        :chart-options="chartOptions"
    />

</template>

<script>
import axios from "axios";
import { Line } from 'vue-chartjs'
//import { Chart as ChartJS, Title, Tooltip, LineController, LineElement, PointElement, Legend, CategoryScale, LinearScale } from 'chart.js'
import {Chart as ChartJS, registerables} from 'chart.js'
import 'chartjs-adapter-date-fns';

ChartJS.register(...registerables)

export default {
    name: "charts",
    components: { Line },

    async mounted () {
        this.loaded = true


        try {
            axios.get('/api/playbyplay/getplaybyplayscore/20200301548').then(resp => {
                this.chartData.datasets[0].data = resp.data.map((x) => x['HomeScore']);
                this.chartData.datasets[1].data = resp.data.map((x) => x['AwayScore']);
                this.chartData.labels = resp.data.map((x) => x['Time']);
                //this.chartOptions.scales.xAxes.time.ticks.source = resp.data.map((x) => x['secs']);
            });

            this.loaded = true
        } catch (e) {
            console.error(e)
        }
    },

    props: {
        chartId: {
            type: String,
            default: 'line-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 300
        },
        height: {
            type: Number,
            default: 150
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Object,
            default: () => {},
        },

    },

    data() {
        return {
            loaded: true,
            chartData: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        label: "Home",
                        borderColor: "#3e95cd",
                        fill: false
                    },
                    {
                        data: [],
                        label: "Away",
                        borderColor: "#8e5ea2",
                        fill: false
                    }
                ],
            },
            chartOptions: {
                scales: {
                    // xAxes: {
                    //     type: 'timeseries',
                    //     time: {
                    //         ticks: {
                    //             source: []
                    //         },
                    //         unit: 'minute',
                    //         displayFormats: {
                    //             minute: 'mm:ss'
                    //         },
                    //         // stepSize: 1,
                    //         // round: false,
                    //     }
                    }
                }
            }
    },

    created() {
    },

    methods: {
    }
}


</script>

<style scoped>

</style>
