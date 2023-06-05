<template>
    <div class="content">
        <div class="container-fluid">
            <!-- OLD REPORTS -->
            <!-- <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                <div class="_title0">
                    <div class="row">
                        <div class="col-sm-5">
                            <input type="date" class="form-control form-control-sm" v-model="filterDate1">
                        </div>
                        <div class="col-sm-1 text-center">
                            <Icon type="md-remove" size="20" />
                        </div>
                        <div class="col-sm-5">
                            <input type="date" class="form-control form-control-sm" v-model="filterDate2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <Card>
                        <p slot="title">Total Sales from {{ filterDate1 }} to {{ filterDate2 }}</p>
                        <salesChart :dateFilter1="filterDate1" :dateFilter2="filterDate2" @hasData="salesHasData" style="height: 27em;" :style="[chartHasData.sales == true ? {'display':'block'} : {'display':'none'}]"></salesChart>
                        <div class="text-center align-middle" style="height: 9em; font-size: 3em;" :style="[chartHasData.sales == false ? {'display':'block'} : {'display':'none'}]">
                            No data to display
                        </div>
                    </Card>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">
                        <Card>
                            <p slot="title">10 Top Selling Items from {{ filterDate1 }} to {{ filterDate2 }}</p>
                            <bestsellersChart :orderDateFilter1="filterDate1" :orderDateFilter2="filterDate2" @hasData="bestsellersHasData" style="height: 27em;" :style="[chartHasData.bestsellers == true ? {'display':'block'} : {'display':'none'}]"></bestsellersChart>
                            <div class="text-center align-middle" style="height: 9em; font-size: 3em;" :style="[chartHasData.sales == false ? {'display':'block'} : {'display':'none'}]">
                                No data to display
                            </div>
                        </Card>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">
                        <Card>
                            <p slot="title">10 Least Selling Items from {{ filterDate1 }} to {{ filterDate2 }}</p>
                            <leastsellersChart :orderDateFilter1="filterDate1" :orderDateFilter2="filterDate2" @hasData="leastsellersHasData" style="height: 27em;" :style="[chartHasData.leastsellers == true ? {'display':'block'} : {'display':'none'}]"></leastsellersChart>
                            <div class="text-center align-middle" style="height: 9em; font-size: 3em;" :style="[chartHasData.sales == false ? {'display':'block'} : {'display':'none'}]">
                                No data to display
                            </div>
                        </Card>
                    </div>
                </div><br>
                <hr><br>
                <div class="row">
                    <div class="col-lg-12">
                        <Card>
                            <p slot="title">Expiring Products</p>
                            <Table :columns="expiringTblHead" :data="expiringItemsList" no-data-text="No data"></Table>
                        </Card>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">
                        <Card>
                            <p slot="title">Recently Ordered</p>
                            <Table :columns="recentTblHead" :data="recentItemsOrdered" no-data-text="No data"></Table>
                        </Card>
                    </div>
                </div><br>
            </div> -->

            <!-- <div class="row">
                <div class="col-sm-5">
                    <input type="date" class="form-control form-control-sm" v-model="filterDate1">
                </div>
                <div class="col-sm-5">
                    <input type="date" class="form-control form-control-sm" v-model="filterDate2">
                </div>
                <div class="col-sm-2">
                    <Button type="primary" size="large" ghost>Generate Report</Button>
                </div>
            </div> -->
            <Row>
                <Col span="24">
                    <b>Report Date Filter</b><br>
                    <p>Please select Date From and Date To</p>
                </Col>
            </Row>
            <Row>
                <Col span="10" class="px-2">
                    <input type="date" class="form-control form-control-sm" v-model="filterDate1">
                </Col>
                <Col span="10" class="px-2">
                    <input type="date" class="form-control form-control-sm" v-model="filterDate2">
                </Col>
                <Col span="4" class="px-2">
                    <!-- <Button type="primary" size="large" ghost>Generate Report</Button> -->
                    <button type="button" class="btn btn-outline-primary btn-block" @click="getSales()">Generate Report</button>
                </Col>
            </Row>
            <br>
            <!-- TOTAL SALES -->
            <Row>
                <Col span="24"><h3 style="text-align: center;">Sales Report</h3></Col>
            </Row>
            
            <Row>
                <Col span="24">
                    <div v-if="daily_sales.length > 0">
                        <Row>
                            <Col span="24"><button @click="exportSalesCsv()" type="button" class="btn btn-outline-primary btn-sm float-right">Export Sales</button></Col>
                        </Row>
                        <Table :columns="daily_sales_headers" :data="daily_sales" ref="sales_table"></Table>
                    </div>
                    <span v-else><h4 style="text-align: center;">No results found</h4></span>
                </Col>
            </Row>
            <br>
            <!-- INVENTORY REPORT (ITEMIZED SOLD ITEMS, USED INGREDIENTS) -->
            <Row>
                <Col span="24"><h3 style="text-align: center;">Inventory Report</h3></Col>
            </Row>
            <Row>
                <Col span="24">
                    <div v-if="daily_sales.length > 0">
                        <Row>
                            <Col span="24"><button @click="exportInventoryCsv()" type="button" class="btn btn-outline-primary btn-sm float-right">Export Inventory</button></Col>
                        </Row>
                        <Table :columns="inventory_report_headers" :data="inventory_report" ref="inventory_table"></Table>
                    </div>
                    <span v-else><h4 style="text-align: center;">No results found</h4></span>
                </Col>
            </Row>
        </div>
    </div>
</template>

<script>
// import salesChart from './charts/sales.vue'
// import bestsellersChart from './charts/bestsellers.vue'
// import leastsellersChart from './charts/leastsellers.vue'
export default {
    // components: {
    //     salesChart,
    //     bestsellersChart,
    //     leastsellersChart,
    // },
    data() {
        return {
            filterDate1: this.formatDate(new Date()),
            filterDate2: this.formatDate(new Date()),
            daily_sales: [],
            daily_sales_headers: [
                {
                    title: 'Date',
                    key: 'date_created_at'
                },
                {
                    title: 'Total Sales',
                    key: 'total_sales'
                },
                {
                    title: 'Total Account Receivable',
                    key: 'total_ar'
                },
                {
                    title: 'Total Items Sold',
                    key: 'total_items_sold'
                }
            ],
            inventory_report_headers: [
                {
                    title: 'Ingredient',
                    key: 'rmaterial'
                },
                {
                    title: 'Total Portions Used',
                    key: 'portions_used'
                },
                {
                    title: 'Total Remaining Portions',
                    key: 'portions_remaining'
                },
            ],
            inventory_report: []
            // expiringItemsList: [],
            // expiringTblHead: [
            //     {
            //         title: 'Item',
            //         key: 'item'
            //     },
            //     {
            //         title: 'Expires In (Days)',
            //         key: 'exp_days'
            //     },
            //     {
            //         title: 'Expiration Date',
            //         key: 'exp_date'
            //     },
            //     {
            //         title: 'Date Encoded',
            //         key: 'date_encode'
            //     }
            // ],
            // recentItemsOrdered: [],
            // recentTblHead: [
            //     {
            //         title: 'Item',
            //         key: 'item'
            //     },
            //     {
            //         title: 'Total Qty Ordered',
            //         key: 'qty_ordered'
            //     },
            // ],
            // chartHasData: {
            //     sales: true,
            //     bestsellers: true,
            //     leastsellers: true,
            // }
        }
    },
    mounted() {
        // this.getExpiringItemsData();
        // this.getRecentOrders();
    },
    methods: {
        formatDate(date) {
            var month = date.getMonth() + 1;
            month = month.toString().length < 2 ? '0' + month : month;
            var day = date.getDate();
            day = day.toString().length < 2 ? '0' + day : day;
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
        }, 

        async getSales() {
            axios.get('./api/get_sales/' + this.filterDate1 + '/' + this.filterDate2)
            .then((response) => {
                this.daily_sales = response.data;
            })
            .catch((error) => {
                console.log(error);
            });

            axios.get('./api/inventory_report/' + this.filterDate1 + '/' + this.filterDate2)
            .then((response) => {
                this.inventory_report = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        exportSalesCsv() {
            this.$refs.sales_table.exportCsv({
                filename: 'Sales Report'
            });
        },

        exportInventoryCsv() {
            this.$refs.inventory_table.exportCsv({
                filename: 'Inventory Report'
            });
        },

        totalSum({ columns, data }) {
            var totals = {};
            columns.forEach((column, index) => {
                const col_key = column.key;
                if(index == 0) { // first column
                    totals[col_key] = {
                        col_key,
                        value: 'Total Sum'
                    };
                    return;
                } else {
                    if(col_key != 'date_created_at') {
                        const values = data.map(item => Number(item[col_key]));
                        if (!values.every(value => isNaN(value))) {
                            const v = values.reduce((prev, curr) => {
                                const curr_value = Number(curr);
                                const prev_value = Number(prev);
                                if(!isNaN(curr_value) && !isNaN(prev_value)) {
                                    return prev + curr;
                                } else if(!isNaN(curr_value) && isNaN(prev_value)) {
                                    return curr_value;
                                } else if(isNaN(curr_value) && !isNaN(prev_value)) {
                                    return prev_value;
                                } else {
                                    return curr_value;
                                }

                                // if (!isNaN(curr_value)) {
                                //     return prev + curr;
                                // } else {
                                //     return prev;
                                // }
                            }, 0);
                            totals[col_key] = {
                                col_key,
                                value: v + ' lalatest'
                            };
                        } else {
                            totals[col_key] = {
                                col_key,
                                value: 'N/A'
                            };
                        }
                    }
                    
                }
            });

            return totals;
        }
        // async getExpiringItemsData() {
        //     var res = await axios.get('./api/get_expiring_items');
            
        //     if(res.status === 200) {
        //         console.log(res.data);
        //         for(var i = 0; i < res.data.length; i++) {
        //             this.$set(this.expiringItemsList, i, {
        //                 item: res.data[i].itemName,
        //                 exp_days: res.data[i].date_diff <= 0 ? 'Expired' : res.data[i].date_diff,
        //                 exp_date: res.data[i].expiryDate,
        //                 date_encode: res.data[i].dateEncoded
        //             });
        //         }
        //     } else {
        //         console.log('error');
        //         console.log(err);
        //     }
        // },
        // async getRecentOrders() {
        //     var res = await axios.get('./api/get_recent_order');

        //     if(res.status === 200) {
        //         for(var i = 0; i < res.data.length; i++) {
        //             this.$set(this.recentItemsOrdered, i, {
        //                 item: res.data[i].itemName,
        //                 qty_ordered: res.data[i].total_qty_ordered
        //             });
        //         }
        //     } else {
        //         console.log('error');
        //         console.log(err);
        //     }
        // },
        // salesHasData: function(value) {
        //     this.chartHasData.sales = value;
        // },
        // bestsellersHasData: function(value) {
        //     this.chartHasData.bestsellers = value;
        // },
        // leastsellersHasData: function(value) {
        //     this.chartHasData.leastsellers = value;
        // }
    },
    watch: {
        filterDate1($event) {
            if($event > this.filterDate2) {
                this.$Notice.warning({
                    title: 'Warning',
                    desc: 'Date From should be lower than Date To'
                });
            }
        }
    },
}
</script>