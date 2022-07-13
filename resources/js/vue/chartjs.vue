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
import {Chart, registerables} from 'chart.js'
import 'chartjs-adapter-date-fns';


Chart.register(...registerables)

export default {
    name: "charts",
    components: { Line },

    async mounted () {

        this.loaded = true

        try {
            axios.get('/api/playbyplay/getplaybyplayscore/20200301548').then(resp => {
                this.chartData.datasets[0].data = resp.data.map((x) => x['HomeScore']);
                this.chartData.datasets[1].data = resp.data.map((x) => x['AwayScore']);
                this.chartData.labels = resp.data.map((x) => x['Minutes']);
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
        // plugins: {
        //     type: Object,
        //     default: () => {},
        // },

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
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        data: [],
                        label: "Away",
                        borderColor: "#8e5ea2",
                        fill: false,
                        pointRadius: 0
                    }
                ],
            },
            chartOptions: {
                scales: {
                    xAxes: {
                        type: 'time',
                        time: {
                            ticks: {
                                source: [],
                                callback: function(value, index, values) {
                                    return this.chartData.labels[index];
                                }
                            },
                            parser: 'm:ss',
                            unit: 'minute',
                            displayFormats: {
                                minute: 'm:ss'
                            },
                            stepSize: 5,
                            // round: false,
                        },
                    }
                },
                plugins: {
                    tooltip: {
                        intersect: false
                    },
                },
                annotation: {
                    annotations: [
                        {
                            drawTime: "afterDatasetsDraw",
                            type: "line",
                            mode: "vertical",
                            scaleID: "x-axis-0",
                            value: 20,
                            borderWidth: 5,
                            borderColor: "red",
                            label: {
                                content: "TODAY",
                                enabled: true,
                                position: "top"
                            }
                        }
                    ]
                }

            },

        }
    },

    created() {
    },

}


</script>

<style scoped>

</style>
