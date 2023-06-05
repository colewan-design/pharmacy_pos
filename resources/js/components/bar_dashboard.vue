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
                    <BreadcrumbItem>Bar Dashboard</BreadcrumbItem>
                </Breadcrumb>
                <!-- <RadioGroup v-model="bar_filter">
                    <Radio label="All">
                        <Icon type="logo"></Icon>
                        <span>All</span>
                    </Radio>
                    <Radio label="Pending">
                        <Icon type="logo"></Icon>
                        <span>Pending</span>
                    </Radio>
                    <Radio label="Processing">
                        <Icon type="logo"></Icon>
                        <span>Processing</span>
                    </Radio>
                    <Radio label="Served">
                        <Icon type="logo"></Icon>
                        <span>Served</span>
                    </Radio>
                </RadioGroup> -->
                <Card>
<div style="min-height: 200px;" >
                        <template >
                            <div class="container-fluid" >
                                <Scroll height="750">
                                        <div class="row">
                                            <div class="col-lg-4 mb-5"  :bordered="false"  v-for="(table,i) in tables"  :key="i" v-bind:key="table.tableId"  >
                                <!-- <Row style="background:#eee;padding:20px"> -->
                                <!-- <template >
                                        <template >
                                            <div style="background:#eee;padding: 20px"  :bordered="false"  v-for="(table,i) in tables"  :key="i"  v-bind:key="table.tableId"  >
                                                <Card  >
                                                    <p slot="title">{{table.tableName}}</p>
                                                    <CheckboxGroup v-model="checkedStatus"  :key="table.tableId">
                                                            <Checkbox label="Pending" checkedStatus></Checkbox>
                                                            <Checkbox label="Processing" checkedStatus></Checkbox>
                                                            <Checkbox label="Served" checkedStatus></Checkbox>
                                                            <Button type="info"  @click="printThis(tables,table.transactionId)">Print</Button>
                                                            <Button type="info" @click="confirmServeBarModal = true; confirmServeBarData.table = bar_tables; confirmServeBarData.transac = table.transactionId;">Served</Button>
                                                    </CheckboxGroup>
                                                    <template  v-for="(thisOrder,i) in bar_orders" v-if="thisOrder.tableId == table.tableId">
                                                    <List border size="small" >
                                                        <ListItem>{{thisOrder.itemName}}</ListItem>
                                                    </List>
                                                    </template>
                                                </Card>

                                            </div>
                                         </template>
                                </template> -->
                                                <div class="card shadow p-3 mb-5 bg-white rounded">
                                                    <h5 class="card-title">{{table.tableName}}</h5>
                                                    <hr class="mb-3">
                                                    <div class="text-center mb-3">
                                                        <CheckboxGroup v-model="checkedStatus[i]"  :key="table.tableId" >
                                                                <Checkbox label="Pending"></Checkbox>
                                                                <Checkbox label="Processing"></Checkbox>
                                                                <Checkbox label="Served"></Checkbox>
                                                                <Button type="info"  @click="printThis(tables,table.transactionId)">Print</Button>
                                                                <!-- Here to remove unwanted Records -->
                                                                <!-- {{table.transactionId}} -->

                                                                <!-- here -->
                                                                <Button type="info" @click="confirmServeBarModal = true; confirmServeBarData.table = kitchen_tables; confirmServeBarData.transac = table.transactionId;">Done</Button>
                                                        </CheckboxGroup>
                                                    </div>
                                                    <hr>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <h5 class="card-title text-center">Order Item</h5>
                                                                <ul class="list-group list-group-flush" v-for="(thisOrder,i) in bar_orders" v-if="thisOrder.tableId == table.tableId">
                                                                    <li v-if="thisOrder.orderServed == 0" class="list-group-item"><h6><a @click="servedKitchenStatus(thisOrder.orderId)" href="#" >{{thisOrder.itemName}} <span v-if="thisOrder.itemNote">({{thisOrder.itemNote}})</span> <span class="badge badge-info">processing</span></a></h6></li>
                                                                    <li class="list-group-item h6" v-else>Finished Prepared </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <h5 class="card-title text-center">Served</h5>
                                                                    <ul class="list-group list-group-flush" v-for="(thisOrder,i) in bar_orders" v-if="thisOrder.tableId == table.tableId">
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
                    v-model="confirmServeBarModal"
                    width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Serve confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Mark as served?</p>
                    </div>
                    <div slot="footer">
                        <Button @click="confirmServeBarModal = false" size="large">Close</Button>
                        <Button type="success" size="large" @click="confirmServeBar">Confirm</Button>
                    </div>
                </Modal>
            </Content>
            <Footer class="layout-footer-center">2021-2099 &copy; POS</Footer>
        </Layout>
    </div>

</template>

<script>
  export default {
        data() {
            return{
                split3: 0.5,
                split4: 0.5,
                timer: 3,
                checkedStatus: [],
                bar_filter: 'All',
                order_status:[],
                bar_orders:[],
                k_or: [{
                    tno:'',
                    orders:[{
                        itemName:'',
                    }],
                }],
                tables:[],
                data_bar : {

                },
                confirmServeBarModal: false,
                confirmServeBarData: {
                    table: '',
                    transac: ''
                },
                loading: false,
            }

        },

        methods : {
             async printThis (transaction,transactionId) {
                // this.loading = true;
                // if(!this.loading) {
                    this.printBar = [];
                    var resPrintBar = await axios.get('api/print_bar_click/'+transactionId);
                    if(resPrintBar.status === 200) {
                        //update status
                            let resUpdateStatus = await axios.post('api/print_update_bar_processing/'+transactionId);
                                if(resUpdateStatus.status === 200) {

                                } else {
                                    this.$Notice.error({
                                        title: 'Error',
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
                // }
             },


            countDownTimer() {
                if(this.timer > 0) {
                    setTimeout(() => {
                        this.timer -= 1
                        this.countDownTimer()
                    }, 3000)
                }else if (this.timer == 0){
                    // location.reload();
                    this.timer = 3;
                    this.createdMethods();
                }
            },

            async createdMethods() {
                // this.loading = true;
                this.countDownTimer();
                // if(!this.loading) {
                    let bar_filter;
                    if(this.bar_filter =="All"){
                        bar_filter =   'api/dashboard_bar_all';
                        }else if (this.bar_filter == "Pending"){
                        bar_filter =   'api/dashboard_bar_pending';
                        }else if (this.bar_filter == "Processing"){
                        bar_filter =   'api/dashboard_bar_processing';
                        }else if (this.bar_filter == "Success"){
                        bar_filter =   'api/dashboard_bar_success';
                    }

                    const [resBar,resTable] = await Promise.all([
                    this.callApi('get', bar_filter),
                    this.callApi('get', 'api/dashboard_bar_tables'),

                    ])

                    if(resBar.status==200){
                        this.bar_orders = resBar.data
                    }else{
                        this.swr()
                    }
                    if(resTable.status==200){
                        this.tables = resTable.data
                        this.checkedStatus = [];

                        //auto print
                        for(var i = 0; i < this.tables.length; i++) {
                                let obj = this.tables[i];

                            if (obj.transactionBarStatus == 'Pending'){

                                // var audio = new Audio('./mp3/ADA TI ORDER.wav');
                                // audio.play();

                                let resPrintBar = await axios.get('api/print_bar/'+obj.transactionId);

                                if(resPrintBar.status === 200) {
                                    //update status
                                    let resUpdateStatus = await axios.post('api/print_update_bar_processing/'+obj.transactionId);
                                        if(resUpdateStatus.status === 200) {

                                        } else {
                                            this.$Notice.error({
                                                title: 'Error',
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
                            }else{
                                // console.log("queue limit 5");
                            }
                            //transaction status
                            if (obj.transactionBarStatus == "Pending"){
                                this.checkedStatus.push(['Pending']);
                            }else if (obj.transactionBarStatus == "Processing"){
                                this.checkedStatus.push(['Pending','Processing']);
                            }else if (obj.transactionBarStatus == "Served"){
                                this.checkedStatus.push(['Pending','Processing','Served']);
                            }
                            //end transaction status
                        }
                        //end auto print
                        this.timer = 3;
                    }else{
                        this.swr()
                    }
                    this.loading = false;
                // }
            },
            confirmServeBar() {
                // this.loading = true;
                this.servedBar(this.confirmServeBarData.table, this.confirmServeBarData.transac);
            },
            async servedBar(transaction,transactionId){
                let resServedBar = await axios.post('api/bar_order_served/'+transactionId);
                if(resServedBar.status === 200) {
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
                this.confirmServeBarModal = false;
                // this.loading = false;
            },
            async servedKitchenStatus(orderId){
                // this.loading = true;
                // if(!this.loading) {
                    //update status served
                    let resServedKitchenStatus = await axios.post('api/kitchen_order_served_status/'+orderId);
                    if(resServedKitchenStatus.status === 200) {
                        // this.$Notice.success({
                        //     title: 'Success',
                        //     desc: ''
                        // });
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }
                    //end update status served
                // }
            }
        },

        created(){
            this.createdMethods();
        },

        props: [ 'permission' ],
    }
</script>






