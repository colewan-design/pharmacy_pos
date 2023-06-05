<script>
    import { Bar } from "vue-chartjs";
    import { mapState } from 'vuex';
    export default {
        extends: Bar,
        props: [
            'dateFilter1',
            'dateFilter2',
        ],
        data() {
            return {
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales:  {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: 15000,
                                stepSize: 750,
                                reverse: false,
                                beginAtZero: true
                            }
                        }]
                    }
                },
                salesChartData: {
                    labels: [],
                    datasets: []
                }
            }
        },
        mounted: async function() {
            await this.getSalesData();
        },
        watch: {
            async dateFilter1() {
                await this.getSalesData();
            },
            async dateFilter2() {
                await this.getSalesData();
            }
        },
        methods: {
            async getSalesData() {
                this.salesChartData.labels = [];
                this.salesChartData.datasets = [];
                var res = await axios.get('./api/get_sales/' + this.dateFilter1 + '/' + this.dateFilter2);
                if(res.status === 200) {
                    var data = [];
                    var data_labels = [];
                    var data_bgcolor = [];
                    
                    if(res.data.length <= 0)
                        this.$emit('hasData', false);
                    else
                        this.$emit('hasData', true);

                    for(var i = 0; i < res.data.length; i++) {
                        var randomColor = Math.floor(Math.random()*16777215).toString(16);
                        data_labels.push(res.data[i].date_created_at);
                        data.push(res.data[i].total_order_sum);
                        data_bgcolor.push('#' + randomColor);
                    }
                    
                    var data_set = [
                        {
                            label: "Total Sales (₱)",
                            backgroundColor: data_bgcolor,
                            data: data
                        }
                    ];
                    this.salesChartData.labels = data_labels;
                    this.salesChartData.datasets = data_set;
                } else {
                    console.log('error');
                    console.log(err);
                }
                this.renderChart(this.salesChartData, this.options);
            },
        }
    }
</script>