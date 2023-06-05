<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

<script src="https://github.com/niklasvh/html2canvas/releases/download/v1.0.0-rc.5/html2canvas.min.js"></script>

<style>
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab{
        border-radius: 0;
        background: #fff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active{
        border-top: 1px solid #3399ff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active:before{
        content: '';
        display: block;
        width: 100%;
        height: 1px;
        background: #3399ff;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>

<style scoped>
    .layout{
        border: 1px solid #d7dde4;
        background: #f5f7f9;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
        height: 100vh;
        width: 100vw;
    }
    .layout-logo{
        width: 100px;
        height: 30px;
        background: #5b6270;
        border-radius: 3px;
        float: left;
        position: relative;
        top: 15px;
        left: 20px;
        color: #fff;
        padding: .35em;
        text-align: center;
    }
    .layout-nav{
        width: 420px;
        margin: 0 auto;
        margin-right: 20px;
    }
    .layout-footer-center{
        text-align: center;
    }
</style>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        padding: 10px;
        grid-column-gap: 10px;
        grid-row-gap: 5px;
    }
    .grid-item {
        background-color: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(0, 0, 0, 0.8);
        padding: 20px;
        font-size: 30px;
        text-align: center;
    }
</style>
<template>
    <div class="layout">
        <Layout>
            <!-- <Header> -->
                <Menu mode="horizontal" theme="dark" active-name="1">
                    <div class="layout-logo"><p><b>POS</b></p></div>
                    <MenuItem name="1" class="float-right" to="/reports" v-if="permission.find(src => src.name === 'reports').read === true">
                        <Icon type="ios-filing" />Go To Reports
                    </MenuItem>
                    <MenuItem name="2" class="float-right" v-else>
                        <a href="/logout"><Icon type="ios-log-out" /> Logout</a>
                    </MenuItem>
                </Menu>
            <!-- </Header> -->

            <Content :style="{padding: '0 50px'}">
                <Breadcrumb :style="{margin: '20px 0'}">
                    <BreadcrumbItem>Kitchen Dashboard</BreadcrumbItem>
                </Breadcrumb>
                <Card>
                    <div style="min-height: 200px;" >
                        <template >
                            <div class="container-fluid" >
                                <Scroll height="750">
                                        <div class="row">
                                            <div class="col-lg-4 mb-5"  :bordered="false"  v-for="(table,i) in tables"  :key="i" v-bind:key="table.tableId"  >
                                                <!-- <Card  >
                                                    <p slot="title">{{table.tableNumber}}</p>
                                                    <CheckboxGroup v-model="checkedStatus"  :key="table.tableId" >
                                                            <Checkbox label="Pending" checkedStatus></Checkbox>
                                                            <Checkbox label="Processing" checkedStatus></Checkbox>
                                                            <Checkbox label="Served"  checkedStatus></Checkbox>
                                                            <Button type="info"  @click="printThis(tables,table.transactionId)">Print</Button>
                                                            <Button type="info" @click="confirmServeKitchenModal = true; confirmServeKitchenData.table = kitchen_tables; confirmServeKitchenData.transac = table.transactionId;">Serving Done</Button>
                                                    </CheckboxGroup>
                                                    <template  v-for="(thisOrder,i) in kitchen_orders" v-if="thisOrder.tableId == table.tableId">
                                                        <List border size="small" :key="'ki_' + i">
                                                            <ListItem v-if="thisOrder.orderServed == 0">{{thisOrder.itemName}}</ListItem>
                                                        </List>
                                                    </template>
                                                </Card> -->
                                                <div class="card shadow p-3 mb-5 bg-white rounded">
                                                    <h5 class="card-title">{{table.tableName}}</h5>
                                                    <hr class="mb-3">
                                                    <div class="text-center mb-3">
                                                        <CheckboxGroup v-model="checkedStatus[i]"  :key="table.tableId" >
                                                                <Checkbox label="Pending"></Checkbox>
                                                                <Checkbox label="Processing"></Checkbox>
                                                                <Checkbox label="Served" ></Checkbox>
                                                                <Button type="info"  @click="printThis(tables,table.transactionId)">Print</Button>
                                                                <Button type="info" @click="confirmServeKitchenModal = true; confirmServeKitchenData.table = kitchen_tables; confirmServeKitchenData.transac = table.transactionId;">Done</Button>
                                                        </CheckboxGroup>
                                                    </div>
                                                    <hr>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <h5 class="card-title text-center">Order Item</h5>
                                                                <ul class="list-group list-group-flush" v-for="(thisOrder,i) in kitchen_orders" v-if="thisOrder.tableId == table.tableId">
                                                                    <li v-if="thisOrder.orderServed == 0" class="list-group-item"><h6><a @click="servedKitchenStatus(thisOrder.orderId)" href="#" >{{thisOrder.itemName}} <span v-if="thisOrder.itemNote">({{thisOrder.itemNote}})</span> <span class="badge badge-info">processing</span></a></h6></li>
                                                                    <li class="list-group-item h6" v-else>Finished Prepared </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <h5 class="card-title text-center">Served</h5>
                                                                    <ul class="list-group list-group-flush" v-for="(thisOrder,i) in kitchen_orders" v-if="thisOrder.tableId == table.tableId">
                                                                    <del v-if="thisOrder.orderServed == 1"><li class="list-group-item h6 text-success">{{thisOrder.itemName}} <span v-if="thisOrder.itemNote">({{thisOrder.itemNote}})</span> </li></del>
                                                                    <li class="list-group-item h6" v-else>waiting...</li>
                                                                </ul>
                                                                <!-- <div class="text-right">
                                                                    </br>
                                                                    <Button  type="success" @click="confirmServeKitchenModal = true; confirmServeKitchenData.table = kitchen_tables; confirmServeKitchenData.transac = table.transactionId;">Done</Button>
                                                                </div> -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                <!-- </Row> -->
                            </div>
                                </Scroll>
                            </div>
                        </template>
                    </div>
                </Card>

                <Modal
                    v-model="confirmServeKitchenModal"
                    width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Serve confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Mark as served?</p>
                    </div>
                    <div slot="footer">
                        <Button @click="confirmServeKitchenModal = false" size="large">Close</Button>
                        <Button type="success" size="large" @click="confirmServeKitchen">Confirm</Button>
                    </div>
                </Modal>
            </Content>
            <Footer class="layout-footer-center">2021-2099 &copy; POS</Footer>
        </Layout>
    </div>


</template>

<script>
import table from './pages/table.vue'

  export default {
        props: [ 'permission' ],
        data() {
            return{
                split3: 0.5,
                split4: 0.5,
                timer: 3,
                checkedStatus: [],
                kitchen_filter: 'All',
                order_status:[],
                kitchen_orders:[],
                k_or: [{
                    tno:'',
                    orders:[{
                        itemName:'',
                    }],
                }],
                tables:[],
                data_kitchen : {

                },
                isPrinting : false,

                printData : {
                    tagName : ''
                },
                confirmServeKitchenModal: false,
                confirmServeKitchenData: {
                    table: '',
                    transac: ''
                },
                loading: false
            }

        },

        methods : {
            async printThis (transaction,transactionId) {
                // this.loading = true;
                    this.printKitchen = [];
                    var resPrintKitchen = await axios.get('api/print_kitchen_click/'+transactionId);

                    if(resPrintKitchen.status === 200) {
                        //update status
                        let resUpdateStatus = await axios.post('api/print_update_kitchen_processing/'+transactionId);
                            if(resUpdateStatus.status === 200) {
                                // this.loading = false;
                            } else {
                                this.$Notice.error({
                                    title: 'ErrorA',
                                    desc: ''
                                });
                            }
                        //end update status
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }
                    // this.loading = false;
            },

            countDownTimer() {
                if(this.timer > 0) {
                    setTimeout(() => {
                        this.timer -= 1
                        this.countDownTimer()
                    }, 3000)
                    console.log('timer ' + this.timer);
                }else if (this.timer == 0){
                    // location.reload();
                    this.timer = 3;
                    // if(this.loading == false)
                        this.createdMethods();
                    // console.log('timer ' + this.timer);
                }
            },

            async createdMethods() {
                // this.loading = true;
                this.countDownTimer();
                    let kitchen_filter;
                    if(this.kitchen_filter =="All"){
                        kitchen_filter =   'api/dashboard_kitchen_all';
                        }else if (this.kitchen_filter == "Pending"){
                        kitchen_filter =   'api/dashboard_kitchen_pending';
                        }else if (this.kitchen_filter == "Processing"){
                        kitchen_filter =   'api/dashboard_kitchen_processing';
                        }else if (this.kitchen_filter == "Success"){
                        kitchen_filter =   'api/dashboard_kitchen_success';
                    }

                    const [resKitchen,resTable] = await Promise.all([
                    this.callApi('get', kitchen_filter),
                    this.callApi('get', 'api/dashboard_kitchen_tables'),

                    ])

                    if(resKitchen.status==200){
                        console.log(resKitchen.data);
                        this.kitchen_orders = resKitchen.data
                    }else{
                        this.swr()
                    }
                    if(resTable.status==200){
                        this.tables = resTable.data;
                        this.checkedStatus = [];

                        //auto print
                        for(var i = 0; i < this.tables.length; i++) {
                                let obj = this.tables[i];
                            if (obj.transactionKitchenStatus == 'Pending'){

                                // var audio = new Audio('./mp3/ADA TI ORDER.wav');
                                // audio.play();

                                let resPrintKitchen = await axios.get('api/print_kitchen/'+obj.transactionId);
                                if(resPrintKitchen.status === 200) {
                                    //update status
                                    let resUpdateStatus = await axios.post('api/print_update_kitchen_processing/'+obj.transactionId);
                                        if(resUpdateStatus.status === 200) {
                                            // this.loading = false;
                                        } else {
                                            this.$Notice.error({
                                                title: 'ErrorA',
                                                desc: ''
                                            });
                                            // this.loading = false;
                                        }
                                        // this.loading = false;
                                    //end update status
                                } else {
                                    this.$Notice.error({
                                        title: 'ErrorB',
                                        desc: ''
                                    });
                                    // this.loading = false;
                                }
                            }else{
                                // console.log("queue limit 5");
                            }

                            //transaction status
                            if (obj.transactionKitchenStatus == "Pending"){
                                this.checkedStatus.push(['Pending']);
                            }else if (obj.transactionKitchenStatus == "Processing"){
                                this.checkedStatus.push(['Pending','Processing']);
                            }else if (obj.transactionKitchenStatus == "Served"){
                                this.checkedStatus.push(['Pending','Processing','Served']);
                            }
                            //end transaction status
                        }
                        //end auto print
                        // this.loading = false;
                        this.timer = 3;
                    }else{
                        this.swr()
                    }
                    // this.loading = false;
            },

            confirmServeKitchen() {
                // this.loading = true;
                this.servedKitchen(this.confirmServeKitchenData.table, this.confirmServeKitchenData.transac);
            },

            async servedKitchen(transaction,transactionId){
                let resServedKitchen = await axios.post('api/kitchen_order_served/'+transactionId);
                if(resServedKitchen.status === 200) {
                    this.createdMethods();
                    this.$Notice.success({
                        title: 'Success',
                        desc: ''
                    });
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: ''
                    });
                }
                this.confirmServeKitchenModal = false;
                // this.loading = false;
            },

            async servedKitchenStatus(orderId){
                // this.loading = true;
                    //update status served
                    let resServedKitchenStatus = await axios.post('api/kitchen_order_served_status/'+orderId);
                    if(resServedKitchenStatus.status === 200) {
                        // this.$Notice.success({
                        //     title: 'Success',
                        //     desc: ''
                        // });
                        // this.loading = false;
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }
                    //end update status served
                // this.loading = false;
            }
        },

        computed: {

        },

        created(){
            // this.loading = false;
            this.createdMethods();
        },


    }
</script>









