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
        width: 100vw;
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
                                <div class="mb-4">
                    <Breadcrumb :style="{margin: '20px 0'}">
                        <BreadcrumbItem>Dashboard</BreadcrumbItem>
                    </Breadcrumb>
                    
                        <Button @click="paymentModal = true" type="primary">Payment</Button>
                        <Button @click="cashinModal = true" type="primary">CashIn</Button>
                        <Button @click="cashoutModal = true" type="primary">CashOut</Button>
                        <Button @click="shiftReportModal = true;" type="primary">Shift Report</Button>
                        <Button @click="allshiftReportModal = true" type="primary">All Shifts Report</Button>
                </div>

                <Card class="card shadow p-3 mb-5 bg-white rounded">
                    <div style="min-height: 600px;">
                        <template>
                            <div class="demo-split">
                                <Split v-model="split3">
                                    <div slot="left" class="demo-split-pane no-padding">
                                        <Split v-model="split4" mode="vertical">
                                            <div slot="top" class="demo-split-pane">
                                                <template>
                                                    <div class="_overflow _table_div">
                                                    <Scroll height="360">
                                                        <table class="_table">
                                                            <!-- TABLE TITLE -->
                                                            <tr>
                                                                <th>Qty</th>
                                                                <th>Item</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                           
                                                                <th>Action</th>
                                                            </tr>
                                                            <!-- TABLE TITLE -->
                                                            <!-- ITEMS -->
                                                            <tr v-for="(order,i) in orders" :key="i" v-if="orders.length">
                                                                <td><InputNumber :max="100" :min="1" v-model="order.orderQty" v-bind:key="order.itemId"  @on-change="changeQty(order.itemId,order.orderQty)" ></InputNumber></td>
                                                                <td><h6>{{order.itemName}}</h6></td>
                                                                <td>₱{{formatPrice(order.orderPrice)}}</td>
                                                                <td>₱{{formatPrice(order.totalPrice)}}</td>
                                                            
                                                                <td>
                                                                <Button type="error" v-on:click="removeOrder(i, order.itemId)">Remove</Button>
                                                                </td>
                                                            </tr>
                                                            <!-- ITEMS -->
                                                        </table>
                                                    </Scroll>
                                                    </div>
                                                </template>
                                            </div>

                                            <div slot="bottom" class="demo-split-pane">
                                                <template>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addOrderModalLabel">Add Order</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                    <div class="row px-md-5">
                                                                        <div class="col-lg-12 mb-3">
                                                                        <Input type="text" v-model="data_transaction.transactionSlipNo" placeholder="Slip Number" />
                                                                        </div>
                                                                        <div class="col-lg-12 mb-3">
                                                                       
                                                                        </div>
                                                                        <div class="col-lg-12 mb-3">
                                                                        <Select v-model="data_transaction.transactionServedBy" placeholder="Served By" >
                                                                            <Option value="">Select One</Option>
                                                                            <Option :value="user.fullname" v-for="(user, i) in users" :key="i">
                                                                                {{user.fullname}}
                                                                            </Option>
                                                                        
                                                                        </Select>
                                                                        </div>
                                                                
                                                                    </div>
                                                                </div>
                                                            <div class="modal-footer">
                                                                <Button type="success" @click="placeOrder" >Add Order</Button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <Button type="success" @click="placeOrder" >Add Order</Button> -->
                                                    <Button type="success" data-toggle="modal" data-target="#addOrderModal">Add Order</Button>
                                                    <Button type="error" @click="removeAllOrders">Remove All</Button>
                                                    <template>
                                                    <div style="float:right">
                                                    <h3>TOTAL:<span class="float-right">₱{{formatPrice(orderTotalTemp)}}</span></h3>
                                                    </div>
                                                    </template>



                                                </template>
                                            </div>
                                        </Split>
                                    </div>

                                    <div slot="right" class="demo-split-pane">
                                        <template>
                                            <Row :gutter="32">
                                                <Col span="150" class="demo-tabs-style2">
                                             
                                                    <Input class="mb-3" v-model="search" placeholder="Search Here!" clearable style="width: 100%" ref="searchbar" />
                                                    <Tabs type="card">
                                                        <TabPane label="Main" width="1000px">
                                                            <Scroll height="360">
                                                               
                                                                <div class="grid-container">
                                                                    
                                                                    <table class="table" style="cursor: pointer;">
                                                                    <tbody>
                                                                        <tr v-for="(item, i) in filteredList" :key="'cart1-'+i+'-'+item.itemName" @click="showQtyModal(item, i, item.categoryId)">
                                                                            <td>{{ item.itemName }}</td>
                                                                            <td>PRICE ₱{{ formatPrice(item.itemPrice) }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>

                                                                </div>
                                                                <!--</Card>-->
                                                            </Scroll>
                                                        </TabPane>
                                                        <TabPane v-for="(department, i) in departments" :key="'department-'+i" :label="department.departmentName" v-if="departments.length" width="1000px">
                                                        <Scroll height="360">
                                                            <table class="table" style="cursor: pointer;">
                                                                <tbody>
                                                                    
                                                                    <template v-for="(category, index) in categories">
                                                                    <template v-if="department.departmentId === category.departmentId">
                                                                        
                                                                        <template v-for="(item, index) in items">
                                                                           
                                                                        <tr v-if="category.categoryId === item.categoryId" @click="showQtyModal(item, index, item.categoryId)">
                                                                            <td>{{ item.itemName }}</td>
                                                                            <td>PRICE ₱{{ formatPrice(item.itemPrice) }}</td>
                                                                        </tr>
                                                                        </template>
                                                                    </template>
                                                                    </template>
                                                                </tbody>
                                                                </table>

                                                        </Scroll>
                                                        </TabPane>



                                                    </Tabs>
                                                </Col>
                                            </Row>
                                        </template>
                                    </div>
                                </Split>
                            </div>
                        </template>
                    </div>
                </Card>

                
              
                <Modal v-model="paymentModal" fullscreen title="Payment">
                    <Scroll height="900">
                        <!-- <Row style="background:#eee;padding:10px"> -->
                            <!-- <template >
                                <template >
                                    <div style="background:#eee;padding: 20px"  :bordered="false" v-for="(table,i) in all_tables"  :key="i" v-bind:key="'table1-'+table.tableId"  >
                                        <Card style="width:350px" >
                                            <Button type="success" @click="showTenderedModal(table,i)"  long >CHECKOUT BILL</Button>
                                            <p slot="title">{{table.tableName}}</p>
                                            <p>Transaction Slip No. {{ table.transactionSlipNo }}</p>
                                            <div v-for="(thisOrder,i) in all_orders"  v-if="thisOrder.tableId == table.tableId">
                                                <List border size="small">
                                                    <ListItem>
                                                        <p class="col-sm-9">{{thisOrder.itemName}}</p>
                                                        <p class="col-sm-3 text-right">P{{ thisOrder.orderTotal }} ({{ thisOrder.orderQty }})</p>
                                                    </ListItem>
                                                </List>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <p class="col-sm-9">Total Amount</p>
                                                <p class="col-sm-3">P{{ ordersTotal[i] }}</p>
                                            </div>
                                        </Card>
                                    </div>
                                    </template>
                        </template> -->
                        <!-- </Row> -->
                            <!-- Tab panes -->
                            <!-- <div class="container-fluid">
                                <ul class="nav nav-pills nav-fill" role="tablist">
                                    <li class="nav-item h3">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">All</a>
                                    </li>
                                    <li class="nav-item h3">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"> Dining Area</a>
                                    </li>
                                    <li class="nav-item h3">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Small Hall</a>
                                    </li>
                                    <li class="nav-item h3">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">Mini Hall</a>
                                    </li>
                                    <li class="nav-item h3">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">Big Hall</a>
                                    </li>
                                    <li class="nav-item h3">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Alfresco Table</a>
                                    </li>
                                    <li class="nav-item h3">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Take-out</a>
                                    </li>
                                </ul>
                            </div> -->

                                <!-- <div class="tab-content"> -->

                                    <!-- <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-4" :bordered="false" v-for="(table,i) in all_tables_this_day"  :key="i" v-bind:key="'table1-'+table.tableId" >
                                                    <div class="card shadow p-3 mb-5 bg-white rounded">
                                                        <div class="card-body">
                                                                <h6 class="card-title mb-5">{{table.tableName}}
                                                                    <span class="float-right">Transaction Slip No. {{ table.transactionSlipNo }}</span>
                                                                </h6>
                                                            <ul class="list-group" v-for="(thisOrder,i) in all_orders_this_day"  v-if="thisOrder.tableId == table.tableId && table.transactionId == thisOrder.transactionId">
                                                                <li class="list-group-item">
                                                                    <h6>
                                                                        {{thisOrder.itemName}} ({{ thisOrder.orderQty }})
                                                                        <span class="float-right"> P{{ thisOrder.orderTotal }}</span>
                                                                    </h6>
                                                                </li>
                                                            </ul>
                                                            <br>
                                                            <h6 class ="list-group-item mb-3">Total Amount <span class="float-right">P{{ ordersTotalPerDay[i] }}</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="tab-pane" id="tabs-2" role="tabpanel">
                                        <div class="container-fluid">
                                            <div class="row">
                                           
                                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-4" :bordered="false" v-for="(table,i) in all_tables"  :key="i" v-bind:key="'table3-'+table.tableId" v-if="table.tableNumber.substring(0, 2) == 'SH'" >
                                                        <div class="card shadow p-3 mb-5 bg-white rounded">
                                                            <div class="card-body">
                                                                <a @click="showChangeTableModal(table)">
                                                                    <h6 class="card-title mb-5">{{table.tableName}}
                                                                        <span class="float-right">Transaction Slip No. {{ table.transactionSlipNo }}</span>
                                                                    </h6>
                                                                </a>
                                                                <ul class="list-group" v-for="(thisOrder,i) in all_orders"  v-if="thisOrder.tableId == table.tableId && table.transactionId == thisOrder.transactionId">
                                                                      <li class="list-group-item">
                                                                        <h6>
                                                                            <a @click="removePlacedOrder(i,thisOrder.orderId)"><Icon type="md-trash" size ="25"/></a>
                                                                            {{thisOrder.itemName}} ({{ thisOrder.orderQty }})
                                                                            <span class="float-right"> P{{ thisOrder.orderTotal }}</span>
                                                                        </h6>
                                                                    </li>
                                                                </ul>
                                                                </br>
                                                                <h6 class ="list-group-item mb-3">Total Amount <span class="float-right">P{{ ordersTotal[i] }}</span></h6>
                                                                <Button type="success" @click="showTenderedModal(table,i,ordersTotal[i])"  long >CHECKOUT BILL</Button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> -->
                                    <!-- <div class="tab-pane" id="tabs-4" role="tabpanel">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-4" :bordered="false" v-for="(table,i) in all_tables"  :key="i" v-bind:key="'table4-'+table.tableId" v-if="table.tableNumber.substring(0, 2) == 'MH'" >
                                                        <div class="card shadow p-3 mb-5 bg-white rounded">
                                                            <div class="card-body">
                                                                <a @click="showChangeTableModal(table)">
                                                                    <h6 class="card-title mb-5">{{table.tableName}}
                                                                        <span class="float-right">Transaction Slip No. {{ table.transactionSlipNo }}</span>
                                                                    </h6>
                                                                </a>
                                                                <ul class="list-group" v-for="(thisOrder,i) in all_orders"  v-if="thisOrder.tableId == table.tableId && table.transactionId == thisOrder.transactionId">
                                                                     <li class="list-group-item">
                                                                        <h6>
                                                                            <a @click="removePlacedOrder(i,thisOrder.orderId)"><Icon type="md-trash" size ="25"/></a>
                                                                            {{thisOrder.itemName}} ({{ thisOrder.orderQty }})
                                                                            <span class="float-right"> P{{ thisOrder.orderTotal }}</span>
                                                                        </h6>
                                                                    </li>
                                                                </ul>
                                                                </br>
                                                                <h6 class ="list-group-item mb-3">Total Amount <span class="float-right">P{{ ordersTotal[i] }}</span></h6>
                                                                <Button type="success" @click="showTenderedModal(table,i,ordersTotal[i])"  long >CHECKOUT BILL</Button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> -->
                                    <!-- <div class="tab-pane" id="tabs-5" role="tabpanel">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-4" :bordered="false" v-for="(table,i) in all_tables"  :key="i" v-bind:key="'table5-'+table.tableId" v-if="table.tableNumber.substring(0, 2) == 'BH'" >
                                                        <div class="card shadow p-3 mb-5 bg-white rounded">
                                                            <div class="card-body">
                                                                <a @click="showChangeTableModal(table)">
                                                                    <h6 class="card-title mb-5">{{table.tableName}}
                                                                        <span class="float-right">Transaction Slip No. {{ table.transactionSlipNo }}</span>
                                                                    </h6>
                                                                </a>
                                                                <ul class="list-group" v-for="(thisOrder,i) in all_orders"  v-if="thisOrder.tableId == table.tableId && table.transactionId == thisOrder.transactionId">
                                                                    <li class="list-group-item">
                                                                        <h6>
                                                                            <a @click="removePlacedOrder(i,thisOrder.orderId)"><Icon type="md-trash" size ="25"/></a>
                                                                            {{thisOrder.itemName}} ({{ thisOrder.orderQty }})
                                                                            <span class="float-right"> P{{ thisOrder.orderTotal }}</span>
                                                                        </h6>
                                                                    </li>
                                                                </ul>
                                                                </br>
                                                                <h6 class ="list-group-item mb-3">Total Amount <span class="float-right">P{{ ordersTotal[i] }}</span></h6>
                                                                <Button type="success" @click="showTenderedModal(table,i,ordersTotal[i])"  long >CHECKOUT BILL</Button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> -->
                                    <!-- <div class="tab-pane" id="tabs-6" role="tabpanel">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-4" :bordered="false" v-for="(table,i) in all_tables"  :key="i" v-bind:key="'table6-'+table.tableId" v-if="table.tableNumber.substring(0, 2) == 'AT'" >
                                                        <div class="card shadow p-3 mb-5 bg-white rounded">
                                                            <div class="card-body">
                                                                <a @click="showChangeTableModal(table)">
                                                                    <h6 class="card-title mb-5">{{table.tableName}}
                                                                        <span class="float-right">Transaction Slip No. {{ table.transactionSlipNo }}</span>
                                                                    </h6>
                                                                </a>
                                                                <ul class="list-group" v-for="(thisOrder,i) in all_orders"  v-if="thisOrder.tableId == table.tableId && table.transactionId == thisOrder.transactionId">
                                                                     <li class="list-group-item">
                                                                        <h6>
                                                                            <a @click="removePlacedOrder(i,thisOrder.orderId)"><Icon type="md-trash" size ="25"/></a>
                                                                            {{thisOrder.itemName}} ({{ thisOrder.orderQty }})
                                                                            <span class="float-right"> P{{ thisOrder.orderTotal }}</span>
                                                                        </h6>
                                                                    </li>
                                                                </ul>
                                                                </br>
                                                                <h6 class ="list-group-item mb-3">Total Amount <span class="float-right">P{{ ordersTotal[i] }}</span></h6>
                                                                <Button type="success" @click="showTenderedModal(table,i,ordersTotal[i])"  long >CHECKOUT BILL</Button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> -->

                                    <!-- <div class="tab-pane" id="tabs-7" role="tabpanel">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-4" :bordered="false" v-for="(table,i) in all_tables"  :key="i" v-bind:key="'table7-'+table.tableId" v-if="table.tableNumber.substring(0, 2) == 'TO'" >
                                                    <div class="card shadow p-3 mb-5 bg-white rounded">
                                                        <div class="card-body">
                                                            <a @click="showChangeTableModal(table)">
                                                                <h6 class="card-title mb-5">{{table.tableName}}
                                                                    <span class="float-right">Transaction Slip No. {{ table.transactionSlipNo }}</span>
                                                                </h6>
                                                            </a>
                                                            <ul class="list-group" v-for="(thisOrder,i) in all_orders"  v-if="thisOrder.tableId == table.tableId && table.transactionId == thisOrder.transactionId">
                                                                    <li class="list-group-item">
                                                                    <h6>
                                                                        <a @click="removePlacedOrder(i,thisOrder.orderId)"><Icon type="md-trash" size ="25"/></a>
                                                                        {{thisOrder.itemName}} ({{ thisOrder.orderQty }})
                                                                        <span class="float-right"> P{{ thisOrder.orderTotal }}</span>
                                                                    </h6>
                                                                </li>
                                                            </ul>
                                                            </br>
                                                            <h6 class ="list-group-item mb-3">Total Amount <span class="float-right">P{{ ordersTotal[i] }}</span></h6>
                                                            <Button type="success" @click="showTenderedModal(table,i,ordersTotal[i])"  long >CHECKOUT BILL</Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                <!-- </div> -->
                        </Scroll>
                    <!-- <div>This is a Payment modal</div> -->
                    <div slot="footer">

                    </div>
                </Modal>

                <Modal v-model ="tenderedModal"  :width="500">
                    <br>
                     <div class="space">
                        <h3>Customer Name</h3>
                        <Input type="text" v-model="data_payment.customerName" />
                     </div>
                     <div class="space">
                        <h3>Tendered Amount</h3>
                        <InputNumber
                         :max="1000000000"
                         :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                         :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                         v-model="data_payment.tenderedAmount"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                        <h3>Discount Amount</h3>
                        <InputNumber
                         :max="1000000000"
                         :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                         :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                         v-model="data_payment.discount"
                        style="width: 100%;"/>
                    </div>
                     <h5 style="float:left;">To Pay: ₱{{ formatPrice(this.discountedPay = this.toBePaid  - data_payment.discount) }}</h5>
                     <!-- <h5 style="float:right;">Change: ₱{{ data_payment.tenderedAmount ? formatPrice( data_payment.tenderedAmount   - this.toBePaid ) : formatPrice(0) }}</h5> -->
                     <h5 style="float:right;">Change: ₱{{ data_payment.tenderedAmount ? formatPrice( data_payment.tenderedAmount - (this.toBePaid - data_payment.discount) ) : formatPrice(0) }}</h5>

                    <div slot="footer">
                        <Button @click="tenderedModal = false" >Close</Button>
                        <Button type="success" @click="checkoutARPrint()">Account Receivable & Print!</Button>
                        <Button type="success" @click="checkoutPrint()">Print!</Button>
                    </div>
                </Modal>
                <Modal v-model ="cashinModal"  :width="800">
                <br>
                <div class="space">
                    <h3>Given By</h3>
                    <Input type="text" v-model="data_cashin.giveBy" />
                    </div>
                    <div class="space">
                    <h3>Amount</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="data_cashin.amount"
                    style="width: 100%;"/>
                   
                </div>
                <div slot="footer">
                    <Button @click="cashinModal = false" >Close</Button>
                    <Button type="success" @click="saveCashIn()">Save</Button>
                </div>
                </Modal>
                <Modal v-model ="cashoutModal"  :width="800">
                    <br>
                <div class="space">
                    <h3>Receive By</h3>
                    <Input type="text" v-model="data_cashout.receiveBy" />
                    </div>
                    <div class="space">
                    <h3>Amount</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="data_cashout.amount"
                    style="width: 100%;"/>
                </div>
                <div slot="footer">
                    <Button @click="cashoutModal = false" >Close</Button>
                    <Button type="success" @click="saveCashout()">Save</Button>
                </div>
                </Modal>

                <!-- Shift Report Cash and Voucher count -->
                <Modal v-model ="shiftReportModal"  :width="800">
                    <br>
                    <Row>
                        <Col span="12"><h3>CASH COUNT</h3></Col>
                        <Col span="12"><h3>VOUCHER COUNT</h3></Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>One Thousand</h4>
                                <InputNumber
                                    :max="1000000000"
                                    v-model="data_shift_report.cash.onethousand"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>One Thousand</h4>
                            <InputNumber
                                :max="1000000000"
                                v-model="data_shift_report.voucher.onethousand"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Five Hundred</h4>
                                <InputNumber
                                    :max="1000000000"
                                    v-model="data_shift_report.cash.fivehundred"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>Five Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                v-model="data_shift_report.voucher.fivehundred"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Two Hundred</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.twohundred"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>Two Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.twohundred"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>One Hundred</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.onehundred"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>One Hundred</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.voucher.onehundred"
                                    style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Fifty</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.fifty"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>Fifty</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.fifty"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Twenty</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.twenty"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>Twenty</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.twenty"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Ten</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.ten"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12">
                            <h4>Ten</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.ten"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Five</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.five"
                                    style="width: 80%;" @change ="totalCashCount()"/>
                            <!-- </div> -->
                        </Col>
                        <!-- <Col span="12">
                            <h4>Five</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.five"
                                style="width: 80%;"/>
                        </Col> -->
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>One</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.one"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <!-- <Col span="12">
                            <h4>One</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.one"
                                style="width: 80%;"/>
                        </Col> -->
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>25 Cents</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.cents"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <!-- <Col span="12">
                            <h4>25 Cents</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="data_shift_report.voucher.cents"
                                style="width: 80%;"/>
                        </Col> -->
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4>Sum Cheques</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="data_shift_report.cash.sumcheques"
                                    style="width: 80%;"/>
                            <!-- </div> -->
                        </Col>
                        <Col span="12"></Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <!-- <div class="space"> -->
                                <h4 style = "text-align: center;">Total {{formatPrice(data_shift_report.cash.totalcashcount =(1000*this.data_shift_report.cash.onethousand)+(500*this.data_shift_report.cash.fivehundred)+(200*this.data_shift_report.cash.twohundred)+(100*this.data_shift_report.cash.onehundred)+(50*this.data_shift_report.cash.fifty)+(20*this.data_shift_report.cash.twenty)+(10*this.data_shift_report.cash.ten)+(5*this.data_shift_report.cash.five)+(1*this.data_shift_report.cash.one)+(0.25*this.data_shift_report.cash.cents)+(this.data_shift_report.cash.sumcheques))}}</h4>
                            <!-- </div> -->
                        </Col>
                        <Col span="12"> <!-- here -->
                            <h4 style = "text-align: center;">Total {{formatPrice(data_shift_report.voucher.totalcashcount =(1000*this.data_shift_report.voucher.onethousand)+(500*this.data_shift_report.voucher.fivehundred)+(200*this.data_shift_report.voucher.twohundred)+(100*this.data_shift_report.voucher.onehundred)+(50*this.data_shift_report.voucher.fifty)+(20*this.data_shift_report.voucher.twenty)+(10*this.data_shift_report.voucher.ten))}}</h4>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="24">
                            <!-- <div class="space"> -->
                                <input type="date" class="form-control" v-model="data_shift_report.date" />
                            <!-- </div> -->
                        </Col>
                    </Row>
                    <div slot="footer">
                        <Row>
                            <Col span="24">
                                <Button @click="shiftReportModal = false" >Close</Button>
                                <Button type="success" @click="shiftReportPrint()">Print</Button>
                            </Col>
                        </Row>
                    </div>
                </Modal>
                <Modal v-model ="beginingFundModal" :mask-closable = "false"
                    :closable = "false">
                    <br>
                    <div class="space">
                        <h3>Begining Amount</h3>
                        <InputNumber
                            :max="1000000000"
                            :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                            :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                            v-model="data_beginingfund.beginingAmount"
                        style="width: 100%;"/>
                    </div>
                    <div slot="footer">
                        <Button type="success" @click="saveBeginingFund()">Save</Button>
                    </div>
                </Modal>

               <!-- all shift modal -->
               <Modal v-model ="allshiftReportModal"  :width="800">
                    <br>
                    <!-- <div class="space">
                    <h3>One Thousand</h3>
                    <InputNumber
                        :max="1000000000"
                        v-model="all_data_shift_report.onethousand"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>Five Hundred</h3>
                    <InputNumber
                        :max="1000000000"
                        v-model="all_data_shift_report.fivehundred"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>Two Hundred</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.twohundred"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>One Hundred</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.onehundred"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>Fifty</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.fifty"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>Twenty</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.twenty"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>Ten</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.ten"
                        style="width: 100%;"/>
                    </div>
                       <div class="space">
                    <h3>Five</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.five"
                        style="width: 100%;" @change ="totalCashCount()"/>
                    </div>
                    <div class="space">
                    <h3>One</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.one"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>25 Cents</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.cents"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3>Sum Cheques</h3>
                    <InputNumber
                        :max="1000000000"
                        :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="all_data_shift_report.sumcheques"
                        style="width: 100%;"/>
                    </div>
                    <div class="space">
                    <h3 style = "float:right;">Total {{formatPrice(all_data_shift_report.totalcashcount =(1000*this.all_data_shift_report.onethousand)+(500*this.all_data_shift_report.fivehundred)+(200*this.all_data_shift_report.twohundred)+(100*this.all_data_shift_report.onehundred)+(50*this.all_data_shift_report.fifty)+(20*this.all_data_shift_report.twenty)+(10*this.all_data_shift_report.ten)+(5*this.all_data_shift_report.five)+(1*this.all_data_shift_report.one)+(0.25*this.all_data_shift_report.cents)+(this.all_data_shift_report.sumcheques))}}</h3>

                    </div>

                    <div class="space">
                        <input type="date" class="form-control" v-model="all_data_shift_report.date" />
                    </div> -->

                    <Row>
                        <Col span="12"><h3>CASH COUNT</h3></Col>
                        <Col span="12"><h3>VOUCHER COUNT</h3></Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>One Thousand</h4>
                            <InputNumber
                                :max="1000000000"
                                v-model="all_data_shift_report.cash.onethousand"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>One Thousand</h4>
                            <InputNumber
                                :max="1000000000"
                                v-model="all_data_shift_report.voucher.onethousand"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Five Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                v-model="all_data_shift_report.cash.fivehundred"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>Five Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                v-model="all_data_shift_report.voucher.fivehundred"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Two Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.twohundred"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>Two Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.voucher.twohundred"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>One Hundred</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.onehundred"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>One Hundred</h4>
                                <InputNumber
                                    :max="1000000000"
                                    :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                    :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                    v-model="all_data_shift_report.voucher.onehundred"
                                    style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Fifty</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.fifty"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>Fifty</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.voucher.fifty"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Twenty</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.twenty"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>Twenty</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.voucher.twenty"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Ten</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.ten"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12">
                            <h4>Ten</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.voucher.ten"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Five</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.five"
                                style="width: 80%;" @change ="totalCashCount()"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>One</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.one"
                                style="width: 80%;"/>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>25 Cents</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.cents"
                                style="width: 80%;"/>
                        </Col>
                       
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4>Sum Cheques</h4>
                            <InputNumber
                                :max="1000000000"
                                :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                v-model="all_data_shift_report.cash.sumcheques"
                                style="width: 80%;"/>
                        </Col>
                        <Col span="12"></Col>
                    </Row>
                    <Row>
                        <Col span="12">
                            <h4 style = "text-align: center;">Total {{formatPrice(all_data_shift_report.cash.totalcashcount =(1000*this.all_data_shift_report.cash.onethousand)+(500*this.all_data_shift_report.cash.fivehundred)+(200*this.all_data_shift_report.cash.twohundred)+(100*this.all_data_shift_report.cash.onehundred)+(50*this.all_data_shift_report.cash.fifty)+(20*this.all_data_shift_report.cash.twenty)+(10*this.all_data_shift_report.cash.ten)+(5*this.all_data_shift_report.cash.five)+(1*this.all_data_shift_report.cash.one)+(0.25*this.all_data_shift_report.cash.cents)+(this.all_data_shift_report.cash.sumcheques))}}</h4>
                        </Col>
                        <Col span="12"> <!-- here -->
                            <h4 style = "text-align: center;">Total {{formatPrice(all_data_shift_report.voucher.totalcashcount =(1000*this.all_data_shift_report.voucher.onethousand)+(500*this.all_data_shift_report.voucher.fivehundred)+(200*this.all_data_shift_report.voucher.twohundred)+(100*this.all_data_shift_report.voucher.onehundred)+(50*this.all_data_shift_report.voucher.fifty)+(20*this.all_data_shift_report.voucher.twenty)+(10*this.all_data_shift_report.voucher.ten))}}</h4>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="24">
                            <input type="date" class="form-control" v-model="all_data_shift_report.date" />
                        </Col>
                    </Row>
                    <div slot="footer">
                        <!-- <Button @click="allshiftReportModal = false" >Close</Button>
                        <Button type="success" @click="allshiftReportPrint()">Print</Button> -->
                        <div slot="footer">
                            <Row>
                                <Col span="24">
                                    <Button @click="allshiftReportModal = false" >Close</Button>
                                    <Button type="success" @click="allshiftReportPrint()">Print</Button>
                                </Col><!-- here -->
                            </Row>
                        </div>
                    </div>
                </Modal>

                <Modal
                    v-model="modalQty"
                    width="360">
                    <h3>QTY</h3>
                    <div class="row">
                        <div class="col-lg-12 mb-2">
                            <!-- <Input v-model="qty" type="number" placeholder="Quantity" clearable style="width: 100%" ref="inputqty" autofocus/> -->
                            <InputNumber v-model="qty" style="width: 100%" ref="inputqty" autofocus/>
                        </div>
                        
                    </div>


                    <div slot="footer">
                        <Button @click="modalQty = false" size="large">Close</Button>
                        <!-- decrease raw material -->
                        <Button type="success" size="large" @click="addOrder(itemData.itemId,itemData.itemDescription,qty,itemData.itemPrice,itemData.itemQty,itemData.categoryId,itemData.itemRawMaterial)">Add</Button>
                        <!-- <Button type="success" size="large" @click="addOrder(itemData.itemId,itemData.itemDescription,qty,itemData.itemPrice,itemData.itemQty,itemData.categoryId)">Add</Button> -->
                    </div>
                </Modal>

                
            </Content>
            <Footer class="layout-footer-center">2021-2099 &copy; POS</Footer>
             <br>

        </Layout>
    </div>

</template>

<script>
 import { mapGetters } from 'vuex'
    export default {
        data() {
            return{
                split3: 0.5,
                split4: 0.5,
                data_department : {
                    departmentId:'',
                    departmentName: '',
                    departmentDescription: '',
                    departmentUse: ''
                },
                data_category : {
                    departmentId:'',
                    categoryName: '',
                    categoryDescription: '',
                    categoryUse: ''
                },
                 data_item : {
                    categoryId:'',
                    itemName: '',
                    itemDescription: '',
                    itemQty: '',
                    itemPrice: '',
                    itemUse: ''
                },
                data_transaction : {
                    transactionId:'',
                    transactionSlipNo: '',
                    transactionTableId: '',
                    transactionServedBy: '',
                    transactionStatus: 'Paid',
                    transactionOutsourcedStatus: 'Pending',
                    orderVal:[]
                },
                data_payment:{
                    transactionId:'',
                    customerName:'',
                    tenderedAmount:0.00,
                    discount:0,

                },
                data_cashin:{
                    cashInId:'',
                    giveBy:'',
                    amount:0.00,
                  
                },
                data_cashout:{
                    cashOutId:'',
                    receiveBy:'',
                    amount:0.00,
                 
                },
                data_shift_report:{
                    cash: {
                        onethousand:0,
                        fivehundred:0,
                        twohundred:0,
                        onehundred:0,
                        fifty:0,
                        twenty:0,
                        ten:0,
                        five:0,
                        one:0,
                        cents:0,
                        sumcheques:0,
                        totalcashcount:0,
                    },
                    voucher: {
                        onethousand:0,
                        fivehundred:0,
                        twohundred:0,
                        onehundred:0,
                        fifty:0,
                        twenty:0,
                        ten:0,
                        five:0,
                        one:0,
                        cents:0,
                        totalcashcount:0,
                    },
                    date: '',
                },
                data_beginingfund:{
                    beginingAmount: 0,
                },
                itemData : {
                    tagName : ''
                },
                categories: [],
                departments: [],
                items: [],
                orders:[],
                tables:[],
                beginingfund:[],
                users:[],
                // buttonClickedId: '',
                buttonClickedId: [],
               
              
                paymentModal:false,
                tenderedModal:false,
                cashinModal:false,
                cashoutModal:false,
                shiftReportModal:false,
                beginingFundModal:false,
                modalQty:false,
                bar_orders:[],
             
              
                search:'',
                totals:[],
                ordersTotal: [],
                ordersTotalPerDay: [],
                orderTotalTemp:0,
                allshiftReportModal: false,
                all_data_shift_report:{
                    cash: {
                        onethousand:0,
                        fivehundred:0,
                        twohundred:0,
                        onehundred:0,
                        fifty:0,
                        twenty:0,
                        ten:0,
                        five:0,
                        one:0,
                        cents:0,
                        sumcheques:0,
                        totalcashcount:0,
                    },
                    voucher: {
                        onethousand:0,
                        fivehundred:0,
                        twohundred:0,
                        onehundred:0,
                        fifty:0,
                        twenty:0,
                        ten:0,
                        totalcashcount:0,
                    },
                    date: '',
                },
                qty: 1,
              
                toBePaid:0,
                dicountedPay:0
            }
        },

       computed: {
            filteredList() {
                return this.items.filter(item => {
                    return item.itemName.toLowerCase().includes(this.search.toLowerCase())
                })
            },
            totalCashCount(){
                return (1000*parseInt(this.onethousand))+(500*parseInt(this.fivehundred))+(200*parseInt(this.twohundred))+(100*parseInt(this.onehundred))+(50*parseInt(this.fifty))+(20*parseInt(this.twenty))+(10*parseInt(this.ten))+(5*parseInt(this.five))+(1*parseInt(this.one))+(0.25*parseInt(this.cents))+(parseInt(this.sumcheques))
            }

        },
        mounted() {
            this.$refs.searchbar.focus();
        },

        methods : {

            async  removePlacedOrder(index,orderId){
                if(confirm("Do you really want to Remove This Order?")){
                    this.all_orders.splice(index, 1);
                    var getOrderId = this.buttonClickedId.findIndex(id => id == orderId);
                    if(getOrderId >= 0)
                        this.buttonClickedId.splice(orderId, 1);

                    let resRemoveOrder= await axios.post('api/remove_order/'+orderId);
                        if(resRemoveOrder.status === 200) {
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
                }
            },

             showQtyModal(item, index,categoryId){
                // this.$refs.searchbar.focus();
                let obj ={
                    itemId: item.itemId,
                    itemDescription: item.itemName,
                    itemPrice : item.itemPrice,
                    itemQty : item.itemQty,
                    categoryId :categoryId ? categoryId : item.categoryId,
                    itemRawMaterial: item.item_raw_material
                }

                let self = this
                Vue.nextTick()
                    .then(function () {
                        console.log(self.$refs.inputqty.focus())
                })
                this.itemData = obj
                this.modalQty = true
                this.$refs.inputqty.focus();
                this.index = index
                this.search = '';


            },

            async saveBeginingFund(){
                    let resBeginingFund = await axios.post('api/create_beginingfund',this.data_beginingfund);
                    if(resBeginingFund.status === 200) {
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }
            },
            async saveCashIn(){
                    let resCashIn = await axios.post('api/add_cashin',this.data_cashin);
                    if(resCashIn.status === 200) {

                    var resPrintCashin =   await axios.post('api/print_cashin',this.data_cashin);
                    if(resPrintCashin.status === 200) {
                          location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }

                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }


            },

            async saveCashout(){
                    let resCashOut = await axios.post('api/add_cashout',this.data_cashout);
                    if(resCashOut.status === 200) {
                        var resPrintCashout =   await axios.post('api/print_cashout',this.data_cashout);
                        if(resPrintCashout.status === 200) {
                             location.reload();
                        } else {
                            this.$Notice.error({
                                title: 'Error',
                                desc: ''
                            });
                        }


                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: ''
                        });
                    }


            },

            showTenderedModal(payment, index,toBePaid){
                this.toBePaid = toBePaid;
                this.data_payment.transactionId =  payment.transactionId
                this.tenderedModal = true
                this.index = index
            },

             async checkoutPrint () {

                this.printAll = [];
                // var resPrintAll = await axios.get('api/print_all/'+transactionId);
                var resPrintAll = await axios.post('api/print_all', this.data_payment);
                if(resPrintAll.status === 200) {
                    console.log('1');
                    location.reload();
                } else {
                    console.log('2');
                    this.$Notice.error({
                        title: 'Error',
                        desc: ''
                    });
                    location.reload();
                }
            },

            async checkoutARPrint () {

                this.printAll = [];
                // var resPrintAll = await axios.get('api/print_all/'+transactionId);
                var resPrintAll = await axios.post('api/print_ar_all', this.data_payment);
                if(resPrintAll.status === 200) {
                    location.reload();
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: ''
                    });
                    location.reload();
                }
            },


            async shiftReportPrint () {
                // var resPrintAll = await axios.get('api/print_all/'+transactionId);
                // var resShiftReport = await axios.post('api/print_shift_report', this.data_shift_report);
                var resShiftReport = await axios.post('api/print_shift_report_test2', this.data_shift_report);
                if(resShiftReport.status === 200) {
                    // location.reload();
                    location.href = '/logout';
                    this.destroySession();
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: ''
                    });
                }
            },

            async allshiftReportPrint() {
                var resShiftReport = await axios.post('api/print_shift_report_all', this.all_data_shift_report);
                // if(resShiftReport.status === 200) {
                //     location.reload();
                // } else {
                //     this.$Notice.error({
                //         title: 'Error',
                //         desc: ''
                //     });
                // }
            },

            formatPrice(value) {

                return value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

            },
            changeQty: function(itemId,newQty) {




                //this loop is for controller
                for(var i = 0; i < this.data_transaction.orderVal.length; i++) {
                    let obj = this.data_transaction.orderVal[i];

                        if (obj.itemId == itemId){
                            obj["orderQty"] = newQty;
                            obj["totalPrice"] = obj["orderPrice"] * newQty;
                        }

                }

                  //this loop is for vue
                for(var i = 0; i < this.orders.length; i++) {
                    let obj = this.orders[i];

                        if (obj.itemId == itemId){
                            obj["orderQty"] = newQty;
                            obj["totalPrice"] = obj["orderPrice"] * newQty;
                        }

                }


                let tempTotal = 0;
                for(var i = 0; i < this.orders.length; i++) {
                    tempTotal += parseFloat(this.orders[i].totalPrice);
                }
                this.orderTotalTemp=tempTotal;


            },
            
            addOrder: function(itemId,itemName,orderQty,orderPrice,itemQty,categoryId,itemRawMaterial) {
              
                    let totalPrice = orderPrice * orderQty;
                    let tempTotal = 0;
                    for(var i = 0; i < this.orders.length; i++) {
                        tempTotal += parseFloat(this.orders[i].totalPrice);

                    }
                    this.orderTotalTemp=tempTotal + totalPrice;

                    if (!totalPrice) {return;}
                    this.orders.push(
                        {
                        itemId: itemId,
                        itemName: itemName,
                        orderQty: orderQty,
                        orderPrice: orderPrice,
                        itemQty: itemQty,
                      
                        totalPrice: totalPrice,
                        categoryId:categoryId
                        }


                    );
              
                    //this array object is basis for controller
                    this.data_transaction.orderVal.push(
                        {
                        itemId: itemId,
                        itemName: itemName,
                        orderQty: orderQty,
                        orderPrice: orderPrice,
                        itemQty: itemQty,
                    
                        totalPrice: totalPrice,
                        categoryId:categoryId
                        }

                    );

                    this.addToClickedId(itemId);
                    this.$refs.searchbar.focus();
                    this.qty = 1;
                    this.modalQty = false;
                // } // END check raw material (else statement)



            } ,

       
           

            async servedOursourced(transaction,transactionId){
                //update status served
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
                //end update status served
                this.confirmServeOutModal = false;

            },

            async placeOrder(){
                const res = await this.callApi('post', 'api/create_order', this.data_transaction)
                if(res.status===201){
                    this.success('Order Submitted!')
                    setInterval(() => {
                        this.removeAllOrders();
                        location.reload();
                    }, 1500);
                }else{
                    if(res.status==422){
                        for(let i in res.data_transaction.errors){
                            this.error(res.data_transaction.errors[i][0])
                        }
                    }else{
                        this.swr()

                    }

                }
            },

            removeOrder: function(index, itemId) {
                this.$refs.searchbar.focus();
                this.orders.splice(index, 1);
                this.data_transaction.orderVal.splice(index,1);

                var getItemId = this.buttonClickedId.findIndex(id => id == itemId);
                if(getItemId >= 0)
                    this.buttonClickedId.splice(getItemId, 1);
                     let tempTotal = 0;
                //recompute temp total
                for(var i = 0; i < this.orders.length; i++) {
                    tempTotal += parseFloat(this.orders[i].totalPrice);
                }
                this.orderTotalTemp=tempTotal;
            },

            addToClickedId: function(itemId) {
                if(itemId !== null && itemId !== undefined) {
                    if(this.buttonClickedId.find(id => itemId === id) === undefined)
                        this.buttonClickedId.push(itemId);
                }
            },

            removeAllOrders() {
                this.orders = [];
                this.data_transaction.orderVal = [];
                this.buttonClickedId = [];

                let tempTotal = 0;
                for(var i = 0; i < this.orders.length; i++) {
                    tempTotal += parseFloat(this.orders[i].totalPrice);
                }
                this.orderTotalTemp=tempTotal;

            },

        

            async reloadItems() {
                var resItem = await this.callApi('get', 'api/dashboard_items');
                if(resItem.status==200){
                    this.items = resItem.data
                }else{
                    this.swr()
                }
            },

            reload: function() {
                // setInterval(() => {
                    this.reloadItems();
                // }, 3000);
            },

    


            destroySession() {
                this.$session.set('loadedRedirect', 'false');
            },

            async printBillOut(table_data) {
                axios.post('api/payments/billout', table_data)
                .then((response) => {
                    this.$Notice.success({
                        title: 'Billout printed',
                        desc: ''
                    });
                })
                .catch((error) => {

                });
            }
        },

        async created(){
            this.removeAllOrders();
            this.reload();
            const [resCategory,resItem,resOutsourced,resAllOrders,resAllOrdersThisDay,resBeginingFund,resUsers] = await Promise.all([
                this.callApi('get', 'api/dashboard_categories'),
                this.callApi('get', 'api/dashboard_items'), // reload every 3 sec

                //begining funds
                this.callApi('get', 'api/check_beginingfund'),
                //users
                this.callApi('get', 'api/dashboard_all_users'),


            ])

            if(resCategory.status==200){
		    	this.categories = resCategory.data
            }else{
                this.swr()
            }
            if(resItem.status==200){
		    	this.items = resItem.data
            }else{
                this.swr()
            }

            if(resBeginingFund.status==200){
		    	this.beginingfund = resBeginingFund.data
                console.log(this.beginingfund.length);
                if (this.beginingfund.length <= 0){
                    this.beginingFundModal = true;
                }
            }else{
                this.swr()
            }

             if(resUsers.status==200){
		    	this.users = resUsers.data
            }else{
                this.swr()
            }
        },

        props: [ 'permission' ],
    }
</script>



<style>
    .demo-split{
        height: 500px;
        border: 1px solid #dcdee2;
    }
    .demo-split-pane{
        padding: 10px;
    }
    .demo-split-pane.no-padding{
        height: 750px;
        padding: 0;
    }
</style>


