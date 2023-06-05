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
                    <BreadcrumbItem>Outsourced Dashboard</BreadcrumbItem>
                </Breadcrumb>
                                        
                <!-- <RadioGroup v-model="outsourced_filter">
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
                                            <div style="background:#eee;padding: 20px"  :bordered="false"  v-for="(table,i) in tables"  :key="i" v-bind:key="table.tableId"  >
                                                <Card  >
                                                    <p slot="title">{{table.tableName}}</p>
                                                    <CheckboxGroup v-model="checkedStatus"  :key="table.tableId" >
                                                            <Checkbox label="Pending" checkedStatus></Checkbox>
                                                            <Checkbox label="Processing" checkedStatus></Checkbox>
                                                            <Checkbox label="Served"  checkedStatus></Checkbox>
                                                            <Button type="info"  @click="printThis(tables,table.transactionId)">Print</Button>
                                                            <Button type="info" @click="confirmServeOutModal = true; confirmServeOutData.table = outsourced_tables; confirmServeOutData.transac = table.transactionId;">Served</Button>
                                                    </CheckboxGroup>
                                                    <template  v-for="(thisOrder,i) in outsourced_orders"   v-if="thisOrder.tableId == table.tableId">
                                                     
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
                                                        <CheckboxGroup v-model="checkedStatus"  :key="table.tableId" >
                                                                <Checkbox label="Pending" checkedStatus></Checkbox>
                                                                <Checkbox label="Processing" checkedStatus></Checkbox>
                                                                <Checkbox label="Served"  checkedStatus></Checkbox>
                                                                <Button type="info"  @click="printThis(tables,table.transactionId)">Print</Button>
                                                                <Button type="info" @click="confirmServeKitchenModal = true; confirmServeKitchenData.table = kitchen_tables; confirmServeKitchenData.transac = table.transactionId;">Done</Button>
                                                        </CheckboxGroup>
                                                    </div>
                                                    <hr>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <h5 class="card-title text-center">Order Item</h5>
                                                                <ul class="list-group list-group-flush" v-for="(thisOrder,i) in outsourced_orders" v-if="thisOrder.tableId == table.tableId">
                                                                    <li v-if="thisOrder.orderServed == 0" class="list-group-item"><h6><a @click="servedKitchenStatus(thisOrder.orderId)" href="#" >{{thisOrder.itemName}} <span v-if="thisOrder.itemNote">({{thisOrder.itemNote}})</span> <span class="badge badge-info">processing</span></a></h6></li>
                                                                    <li class="list-group-item h6" v-else>Finished Prepared </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <h5 class="card-title text-center">Served</h5> 
                                                                    <ul class="list-group list-group-flush" v-for="(thisOrder,i) in outsourced_orders" v-if="thisOrder.tableId == table.tableId">
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
                    v-model="confirmServeOutModal"
                    width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Serve confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Mark as served?</p>
                    </div>
                    <div slot="footer">
                        <Button @click="confirmServeOutModal = false" size="large">Close</Button>
                        <Button type="success" size="large" @click="confirmServeOut">Confirm</Button>
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
        data() {
            return{
                split3: 0.5,
                split4: 0.5,
                timer: 3,
                checkedStatus: [],
                outsourced_filter: 'All',
                order_status:[],
                outsourced_orders:[],
                k_or: [{
                    tno:'',
                    orders:[{
                        itemName:'',
                    }],
                }],
                tables:[],
                data_outsourced : {
                   
                },
                isPrinting : false,
                 
                printData : {
                    tagName : ''
                },
                confirmServeOutModal: false,
                confirmServeOutData: {
                    table: '',
                    transac: ''
                }
            }
        
        },

        methods : {
            
            async printThis (transaction,transactionId) {

                this.printOutsourced= [];
                var resPrintOutsourced = await axios.get('api/print_outsourced_click/'+transactionId);
                console.log(resPrintOutsourced);
                if(resPrintOutsourced.status === 200) {
                    //update status
                    let resUpdateStatus = await axios.post('api/print_update_outsourced_processing/'+transactionId);
                        if(resUpdateStatus.status === 200) {

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
            },
            
            countDownTimer() {
                if(this.timer > 0) {
                    setTimeout(() => {
                        this.timer -= 1
                        this.countDownTimer()
                    }, 1000)
                }else if (this.timer == 0){
                    // location.reload();
                    this.timer = 3;
                    this.createdMethods();
                }
            },

            async createdMethods() {
                this.countDownTimer();
                let outsourced_filter;
                if(this.outsourced_filter =="All"){
                    outsourced_filter =   'api/dashboard_outsourced_all';
                    }else if (this.outsourced_filter == "Pending"){
                    outsourced_filter =   'api/dashboard_outsourced_pending';
                    }else if (this.outsourced_filter == "Processing"){
                    outsourced_filter =   'api/dashboard_outsourced_processing';
                    }else if (this.outsourced_filter == "Success"){
                    outsourced_filter =   'api/dashboard_outsourced_success';
                }
            
                const [resOutsourced,resTable] = await Promise.all([
                this.callApi('get', outsourced_filter),
                this.callApi('get', 'api/dashboard_outsourced_tables'),
                
                ])
            
                if(resOutsourced.status==200){
                    console.log(resOutsourced.data);
                    this.outsourced_orders = resOutsourced.data
                }else{
                    this.swr()
                }
                if(resTable.status==200){
                    console.log(resTable.data);
                    this.tables = resTable.data

                    //auto print
                    for(var i = 0; i < this.tables.length; i++) {
                            let obj = this.tables[i];
                    
                        if (obj.transactionOutsourcedStatus == 'Pending'){

                            
                            // var audio = new Audio('./mp3/ADA TI ORDER.wav'); 
                            // audio.play();
                        
                            let resPrintOutsourced = await axios.get('api/print_outsourced/'+obj.transactionId);
                        
                            if(resPrintOutsourced.status === 200) {
                                //update status
                                let resUpdateStatus = await axios.post('api/print_update_outsourced_processing/'+obj.transactionId);
                                    if(resUpdateStatus.status === 200) {

                                    } else {
                                        this.$Notice.error({
                                            title: 'ErrorA',
                                            desc: '' 
                                        });
                                    }
                                //end update status
                                } else {
                                    this.$Notice.error({
                                        title: 'ErrorB',
                                        desc: '' 
                                    });
                                }
                        }else{
                            // console.log("queue limit 5");
                        }

                        //transaction status
                        if (obj.transactionOutsourcedStatus == "Pending"){
                            this.checkedStatus.push('Pending');
                        }else if (obj.transactionOutsourcedStatus == "Processing"){
                            this.checkedStatus.push('Pending','Processing');
                        }else if (obj.transactionOutsourcedStatus == "Served"){
                            this.checkedStatus.push('Pending','Processing','Served');
                        }
                        //end transaction status
                    }
                    //end auto print
                    this.timer = 3;
                }else{
                    this.swr()
                }
            },
            confirmServeOut() {
                this.servedOursourced(this.confirmServeOutData.table, this.confirmServeOutData.transac);
            },
            async servedOursourced(transaction,transactionId) {
                let resServedOursourced = await axios.post('api/outsorced_order_served/'+transactionId);
                if(resServedOursourced.status === 200) {
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
                this.confirmServeOutModal = false;
            },
        },
          
        created(){
            this.createdMethods();
        },

        props: [ 'permission' ],
    }
</script>









