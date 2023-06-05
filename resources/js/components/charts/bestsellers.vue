<script>
    import { Doughnut } from "vue-chartjs";
    export default {
        extends: Doughnut,
        props: [
            'orderDateFilter1',
            'orderDateFilter2',
        ],
        data() {
            return {
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                },
                ordersChartData: {
                    labels: [],
                    datasets: []
                },
            }
        },
        mounted: async function() {
            await this.getOrderItemsData();
        },
        watch: {
            async orderDateFilter1() {
                await this.getOrderItemsData();
            },
            async orderDateFilter2() {
                await this.getOrderItemsData();
            }
        },
        methods: {
            async getOrderItemsData() {
                this.ordersChartData.labels = [];
                this.ordersChartData.datasets = [];
                var res = await axios.get('./api/get_bestseller_items/' + this.orderDateFilter1 + '/' + this.orderDateFilter2);
                
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
                        data_labels.push(res.data[i].itemName + ' Total Qty Ordered');
                        data.push(res.data[i].total_order_qty);
                        data_bgcolor.push('#' + randomColor);
                    }
                    
                    var data_set = [
                        {
                            label: "Total Qty Ordered",
                            backgroundColor: data_bgcolor,
                            data: data
                        }
                    ];
                    this.ordersChartData.labels = data_labels;
                    this.ordersChartData.datasets = data_set;
                } else {
                    console.log('error');
                    console.log(err);
                }
                this.renderChart(this.ordersChartData, this.options);
            },
        }
    }
</script>