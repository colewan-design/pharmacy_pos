<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'purchase_order').write === true"><Icon type="md-add" /> Add Purchase Order</Button>
                        <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Sold To</th>
                                <th>Customer Code</th>
                                <th>Sales Man</th>
                                <th>Customer Type</th>
                                <th>Date</th>
                                <th>Address</th>
                                <th>PO Number</th>
                                <th>Salesman Code</th>
                                <th>Terms</th>
                                <th>Page</th>
                                <th>Product Code</th>
                                <th>Description</th>
                                <th>Lot Number</th>
                                <th>Expiry Date</th>
                                <th>Split</th>
                                <th>Quantity</th>
                                <th>Delivered</th>
                                <th>UOM</th>
                                <th>Unit Price</th>
                                <th>Unit Price W/O Vat</th>
                                <th>Unit Price With Vat</th>
                                <th>Product Discount</th>
                                <th>Product Discount Rate</th>
                                <th>Product Discount W/O Vat</th>
                                <th>Product Discount With Vat</th>
                                <th>Amount</th>
                                <th>Amount With Vat</th>
                                <th>Tax Code</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(purchase_order,i) in collection" :key="i" v-if="purchase_orders.length" >
                                <td>{{purchase_order.soldTo}}</td>
                                <td>{{purchase_order.customerCode}}</td>
                                <td>{{purchase_order.salesman}}</td>
                                <td>{{purchase_order.customerType}}</td>
                                <td>{{purchase_order.date}}</td>
                                <td>{{purchase_order.address}}</td>
                                <td>{{purchase_order.poNumber}}</td>
                                <td>{{purchase_order.salesmanCode}}</td>
                                <td>{{purchase_order.terms}}</td>
                                <td>{{purchase_order.page}}</td>
                                <td>{{purchase_order.productCode}}</td>
                                <td>{{purchase_order.description}}</td>
                                <td>{{purchase_order.lotNumber}}</td>
                                <td>{{purchase_order.expiryDate}}</td>
                                <td>{{purchase_order.split}}</td>
                                <td>{{purchase_order.quantity}}</td>
                                <td>{{purchase_order.delivered}}</td>
                                <td>{{purchase_order.uom}}</td>
                                <td>{{purchase_order.unitPrice}}</td>
                                <td>{{purchase_order.unitPriceWOVat}}</td>
                                <td>{{purchase_order.unitPriceWithVat}}</td>
                                <td>{{purchase_order.productDiscount}}</td>
                                <td>{{purchase_order.rate}}</td>
                                <td>{{purchase_order.productDiscountWOVat}}</td>
                                <td>{{purchase_order.productDiscountWithVat}}</td>
                                <td>{{purchase_order.amount}}</td>
                                <td>{{purchase_order.amountWithVat}}</td>
                                <td>{{purchase_order.taxCode}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'purchase_order').update === true" @click="showEditModal(purchase_order,i)">Edit</Button>
                                    <Button type="error" size="small" v-if="permission.find(item => item.name === 'purchase_order').delete === true" @click="showDeletingModal(purchase_order,i)" icon="md-add"><Icon type=""  />Delete</Button>
                                    <!-- <Button type="primary" size="small" v-if="permission.find(item => item.name === 'purchase_order').update === true" @click="markAsDelivered(purchase_order, i)">Mark as Delivered</Button> -->
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'purchase_order').update === true" @click="showMarkAsDeliveredModal(purchase_order,i)">Mark as delivered</Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->

                        </table>
                    </div>
                </div>
                <div class="btn-toolbar">
                    <div class="btn-group">
                     <button class="btn btn-primary" v-for="p in pagination.pages" @click.prevent="setPage(p)">{{p}}</button>
                    </div>
                </div>
                
                <!-- tag adding modal -->
                <Modal
                v-model="addModal"
                title="Add Purchase Order"
                :mask-closable="false"
                :closable="false"
                width="80"
                >
                <table class="table-bordered">
                    <!-- ...table headers... -->
                    <tr>
                <td colspan="4">
                    <div class="space">
                    <Input type="text" v-model="data.soldTo" placeholder="Sold To"/>
                    </div>
                </td>
                <td colspan="3">
                    <div class="space">
                    <Input type="text" v-model="data.customerCode" placeholder="Customer Code" />
                    </div>
                </td>
                <td colspan="3">
                    <div class="space">
                    <Input type="text" v-model="data.salesman" placeholder="Salesman" />
                    </div>
                </td>
                <td colspan="2">
                    <div class="space">
                    <Input type="text" v-model="data.customerType" placeholder="Customer Type" />
                    </div>
                </td>
                <td colspan="2">
                    <div class="space">
                    <Input type="text" v-model="data.date" placeholder="Date" />
                    </div>
                </td>
                </tr>
                <tr>
                <td colspan="4">
                    <div class="space">
                    <Input type="text" v-model="data.address" placeholder="Address" />
                    </div>
                </td>
                <td colspan="3">
                    <div class="space">
                    <Input type="text" v-model="data.poNumber" placeholder="PO Number" />
                    </div>
                </td>
                <td colspan="3">
                    <div class="space">
                    <Input type="text" v-model="data.salesmanCode" placeholder="Salesman Code" />
                    </div>
                </td>
                <td colspan="2">
                    <div class="space">
                    <Input type="text" v-model="data.terms" placeholder="Terms" />
                    </div>
                </td>
                <td colspan="2">
                    <div class="space">
                    <Input type="text" v-model="data.page" placeholder="Page" disabled/>
                    </div>
                </td>
                </tr>

                    <!-- ...table rows... -->
                    <tr>
                    <td colspan="14">
                    <div class="space">
                        Delivery Instruction
                    </div>
                    </td>
                    </tr>
                    <tr><!--start-->
                    <td rowspan="2">
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.productCode"
                            placeholder="Product Code"
                        />
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.description"
                            placeholder="Description"
                            disabled
                        />
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.quantity"
                            placeholder="Quantity"
                            disabled
                        />
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.unitPrice"
                            placeholder="Unit Price"
                            disabled
                        />
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.productDiscount"
                            placeholder="Product Discount"
                            disabled
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.amount"
                            placeholder="Amount"
                            disabled
                        />
                        </div>
                    </td>
                    <td rowspan="2">
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.taxCode"
                            placeholder="Tax Code"
                        />
                        </div>
                    </td>
                  
                    </tr>
                    <tr>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.lotNumber"
                            placeholder="Lot Number"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.expiryDate"
                            placeholder="Expiry Date"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.split"
                            placeholder="Split"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.order"
                            placeholder="Order"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.delivered"
                            placeholder="Delivered"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.uom"
                            placeholder="UOM"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.unitPriceWOVat"
                            placeholder="W/O Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.unitPriceWithVat"
                            placeholder="With Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.rate"
                            placeholder="Rate"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.productDiscountWOVat"
                            placeholder="W/O Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.productDiscountWithVat"
                            placeholder="With Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="data.amountWithVat"
                            placeholder="With Vat"
                        />
                        </div>

                    </td>
                    </tr><!--End-->
                    
             
                    <tr v-for="(d, index) in data.items" :key="index">
                   

                        <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.productCode"
                            placeholder="PR Code"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.lotNumber"
                            placeholder="Lot Number"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.expiryDate"
                            placeholder="Expiry Date"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.split"
                            placeholder="Split"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.order"
                            placeholder="Order"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.delivered"
                            placeholder="Delivered"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.uom"
                            placeholder="UOM"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.unitPriceWOVat"
                            placeholder="W/O Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.unitPriceWithVat"
                            placeholder="With Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.rate"
                            placeholder="Rate"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.productDiscountWOVat"
                            placeholder="W/O Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.productDiscountWithVat"
                            placeholder="With Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.amountWithVat"
                            placeholder="With Vat"
                        />
                        </div>
                    </td>
                    <td>
                        <div class="space">
                        <Input
                            type="text"
                            v-model="d.taxCode"
                            placeholder="Tax Code"
                        />
                        </div>
                    </td>
                    <td>
                    <button
                    type="button"
                    class="ml-2 rounded-md border px-3 py-2 bg-red-600 text-white"
                    @click="remove(index)"
                    v-show="index !== 0"
                    >
                    Remove
                    </button>
                </td>
                    
  
                    </tr>

                    <tr>
                    <td colspan="14">
                        <Button @click="addDeliveryInstruction" type="info" long>Add</Button>
                    </td>
                    </tr>
         
                </table>

                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button
                    type="primary"
                    @click="addPurchaseOrder"
                    :disabled="isAdding"
                    :loading="isAdding"
                    >
                    {{ isAdding ? 'Adding...' : 'Add Purchase Order' }}
                    </Button>
                </div>
                </Modal>


                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Purchase Order"
                    :mask-closable = "false"
                    :closable = "false">
            
                    <div class="space">
                        <Input type="text" v-model="editData.supplierName" placeholder="Supplier Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.brandName" placeholder="Brand Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.itemName" placeholder="Item Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.itemDescription" placeholder="Item Description" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.itemQty" placeholder="Item Quantity" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.fromLocation" placeholder="From Location" />
                    </div>
            
            
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editPurchaseOrder" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Purchase Order'}}</Button>
                    
                    </div>
                </Modal>
                <deleteModal></deleteModal>

               <!-- tag Mark as delivered modal -->
               <Modal
                v-model="markAsDeliveredModal"
                title="Mark As Delivered"
                :mask-closable="false"
                :closable="false"
                >
                <div class="space">
                    <Input type="text" v-model="editData.itemName" placeholder="Item Name" disabled />
                </div>
                <div class="space">
                    <Input type="text" v-model="editData.itemQty" placeholder="Item Quantity" />
                </div>

                <Card>
                    <p slot="title">Bad order</p>
                    <Card>
                    <div>
                        <div class="space">
                        <Input type="text" v-model="editData.badOrderQty" placeholder="Bad Order Quantity" />
                        </div>
                    </div>
                    </Card><br>
                    <div class="space">
                    <Input type="text" v-model="editData.reason" placeholder="Reason" />
                    </div>
                </Card>
                <Card class="space">
                    <p slot="title">Freebie</p>
                    <Card>
                    <div>
                        <div class="space">
                        <Input type="text" v-model="editData.badOrderQty" placeholder="Freebie Quantity" />
                        </div>
                    </div>
                    </Card><br>
                </Card>

                <div slot="footer">
                    <Button type="default" @click="markAsDeliveredModal = false">Close</Button>
                    <Button type="primary" @click="markPurchaseOrderDelivered" :disabled="isAdding" :loading="isAdding">
                    {{ isAdding ? 'Inserting...' : 'Mark Order as Delivered' }}
                    </Button>
                </div>
                </Modal>

            </div>
        </div>
    </div>
</template>

<script>
    import deleteModal from '../deleteModal.vue'
    import { mapGetters } from 'vuex'
    export default {
        data() {
            return{
                data :{
                items:[{
                    soldTo: '',
                    customerCode: '',
                    salesman: '',
                    customerType: '',
                    address: '',
                    poNumber: '',
                    salesmanCode: '',
                    terms: '',
                    page: '',
                    productCode: '',
                    description: '',
                    quantity: '',
                    unitPrice: '',
                    productDiscount: '',
                    amount: '',
                    taxCode: '',
                    lotNumber: '',
                    expiryDate: '',
                    split: '',
                    order: '',
                    delivered: '',
                    uom: '',
                    unitPriceWOVat: '',
                    unitPriceWithVat: '',
                    rate: '',
                    productDiscountWOVat: '',
                    productDiscountWithVat: '',
                    amountWithVat: '',
                     }],
                    },
                deliveryInstructions: [],
                tempDeliveryInstruction: '',
                addModal : false,
                editModal : false,
                markAsDeliveredModal : false,
                isAdding : false,
                purchase_orders: [],
                suppliers: [],
                editData : {
                    tagName : ''
                },
                markAsDeliveredModalData : {
                    tagName : ''
                },
                index : -1,
                showDeleteModal: false,
                isdeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                perPage: 10,
                pagination: {},
                search:'',
            }
        },

        methods : {
            addDeliveryInstruction() {
                this.data.items.push({
                customerCode: '',
                soldTo: '',
                salesman: '',
                customerType: '',
                address: '',
                poNumber: '',
                salesmanCode: '',
                terms: '',
                productCode: '',
                taxCode: '',
                lotNumber: '',
                expiryDate: '',
                split: '',
                order: '',
                delivered: '',
                uom: '',
                unitPriceWOVat: '',
                unitPriceWithVat: '',
                rate: '',
                productDiscountWOVat: '',
                productDiscountWithVat: '',
                amountWithVat: '',
            });
            
            console.log(this.data);
          
            },
            
            remove() {
                const removedItem = this.data.items.splice(index, 1)[0];
                this.removedItems.push(removedItem);
                
            },

             setPage(p) {
                this.search = '';
                this.pagination = this.paginator(this.purchase_orders.length, p);
            },
           
            paginate(purchase_orders) {
                return _.slice(purchase_orders, this.pagination.startIndex, this.pagination.endIndex + 1)
            },
            paginator(totalItems, currentPage) {
                var startIndex = (currentPage - 1) * this.perPage,
                endIndex = Math.min(startIndex + this.perPage - 1, totalItems - 1);
                return {
                currentPage: currentPage,
                startIndex: startIndex,
                endIndex: endIndex,
                pages: _.range(1, Math.ceil(totalItems / this.perPage) + 1)
                };
            },

            async addPurchaseOrder(){
                if(this.data.soldTo.trim()=='') return this.error('Sold to is required')
                
                if(this.permission.find(item => item.name === 'purchase_order').write === true) {
                    const res = await this.callApi('post', 'api/create_purchase_order', this.data.items[{
                customerCode: '',
                soldTo: '',
                salesman: '',
                customerType: '',
                address: '',
                poNumber: '',
                salesmanCode: '',
                terms: '',
                productCode: '',
                taxCode: '',
                lotNumber: '',
                expiryDate: '',
                split: '',
                order: '',
                delivered: '',
                uom: '',
                unitPriceWOVat: '',
                unitPriceWithVat: '',
                rate: '',
                productDiscountWOVat: '',
                productDiscountWithVat: '',
                amountWithVat: '',
            }],
            )
                    if(res.status===201){
                        this.createdMethods();
                        this.success('Purchase Order has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.soldTo = '';
                        this.data.customerCode = '';
                        this.data.salesman = '';
                        this.data.customerType = '';
                        this.data.address = '';
                        this.data.poNumber = '';
                        this.data.salesmanCode = '';
                        this.data.terms = '';
                        this.data.productCode = '';
                        this.data.taxCode = '';
                        this.data.lotNumber = '';
                        this.data.expiryDate = '';
                        this.data.split = '';
                        this.data.order = '';
                        this.data.delivered = '';
                        this.data.uom = '';
                        this.data.unitPriceWOVat = '';
                        this.data.unitPriceWithVat = '';
                        this.data.rate = '';
                        this.data.productDiscountWOVat = '';
                        this.data.productDiscountWithVat = '';
                        this.data.amountWithVat = '';

                    }else{
                        if(res.status==422){
                            for(let i in res.data.errors){
                                this.error(res.data.errors[i][0])
                            }
                        }else{
                            this.swr()
                        }

                    }
                }
            },

            showDeletingModal(purchase_order, i) {
                if(this.permission.find(item => item.name === 'purchase_order').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_purchase_order",
                        data: purchase_order,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async editPurchaseOrder() {
                if(this.permission.find(item => item.name === 'purchase_order').update === true) {
                    const res = await this.callApi('post', 'api/edit_purchase_order', this.editData)
                    if(res.status === 200){
                        // this.purchase_orders[this.index] = this.editData
                        this.createdMethods();
                        this.success('this is edited successfully');
                        this.editModal = false;
                    }else{
                        if(res.status==422){
                            for(let i in res.data.errors){
                                this.error(res.data.errors[i][0])
                            }
                        }else{
                            this.swr();
                        }
                    }
                }
            },
            async markPurchaseOrderDelivered() {
            if (this.permission.find((item) => item.name === 'purchase_order').update === true) {
                // Deduct the bad order quantity from the item quantity
                const itemQty = parseInt(this.editData.itemQty) - parseInt(this.editData.badOrderQty);

                // Copy the data from the purchase order to the delivered stocks table
                const deliveredStock = {
                purchaseOrderId: this.editData.purchaseOrderId,
                supplierName: this.editData.supplierName,
                brandName: this.editData.brandName,
                itemName: this.editData.itemName,
                itemDescription: this.editData.itemDescription,
                itemQty: itemQty.toString(), // Save the adjusted item quantity to the delivered stocks table
                fromLocation: this.editData.fromLocation,
                };

                // Copy the data from the purchase order to the bad orders table
                const badOrder = {
                purchaseOrderId: this.editData.purchaseOrderId,
                supplierName: this.editData.supplierName,
                brandName: this.editData.brandName,
                itemName: this.editData.itemName,
                itemDescription: this.editData.itemDescription,
                itemQty: this.editData.badOrderQty, // Save the bad order quantity to the bad orders table
                fromLocation: this.editData.fromLocation,
                reason: this.editData.reason, // Add the reason for the bad order
                };

                try {
                // Make API requests to save the data in the respective tables
                const [deliveredResponse, badOrderResponse] = await Promise.all([
                    axios.post('/api/mark_as_delivered', deliveredStock),
                    axios.post('/api/save_bad_order', badOrder),
                ]);

                // Handle success responses
                console.log('Stock marked as delivered:', deliveredResponse.data);
                console.log('Bad order saved:', badOrderResponse.data);

                // Show success message
                    this.success('Stock marked as delivered successfully');

                // Optionally, you can remove the purchase order from the current table if needed
                this.purchase_orders.splice(this.index, 1);

                // Reset the form data
                this.editData = {
                    purchaseOrderId: '',
                    supplierName: '',
                    brandName: '',
                    itemName: '',
                    itemDescription: '',
                    itemQty: '',
                    fromLocation: '',
                    badOrderQty: '',
                    reason: '',
                };

                // Close the modal
                this.markAsDeliveredModal = false;
                } catch (error) {
                // Handle error responses
                console.error('Error marking stock as delivered:', error);
                }
            }
            },


            

            showEditModal(purchase_order, index){
                let obj ={
                    purchaseOrderId: purchase_order.purchaseOrderId,
                    supplierName : purchase_order.supplierName,
                    brandName : purchase_order.brandName,
                    itemName : purchase_order.itemName,
                    itemDescription : purchase_order.itemDescription,
                    itemQty : purchase_order.itemQty,
                    fromLocation : purchase_order.fromLocation,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },
            showMarkAsDeliveredModal(purchase_order, index){
                let obj ={
                    purchaseOrderId: purchase_order.purchaseOrderId,
                    supplierName : purchase_order.supplierName,
                    brandName : purchase_order.brandName,
                    itemName : purchase_order.itemName,
                    itemDescription : purchase_order.itemDescription,
                    itemQty : purchase_order.itemQty,
                    fromLocation : purchase_order.fromLocation,
                }
                this.editData = obj
                this.markAsDeliveredModal = true  // Update this line
                this.index = index
            },

            async createdMethods() {
                const [res] = await Promise.all([
                    this.callApi('get', 'api/purchase_orders'),
                ])
                if(res.status==200){
                    this.purchase_orders = res.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            },
                markAsDelivered(purchase_order, index) {
                // Copy the data from the purchase order to the delivered stocks table
                // Example logic:
                const deliveredStock = {
                purchaseOrderId: purchase_order.purchaseOrderId,
                supplierName: purchase_order.supplierName,
                brandName : purchase_order.brandName,
                itemName: purchase_order.itemName,
                itemDescription: purchase_order.itemDescription,
                itemQty: purchase_order.itemQty,
                fromLocation: purchase_order.fromLocation
                };

                axios.post('/api/mark_as_delivered', deliveredStock)
                .then(response => {
                    // Handle success response
                    console.log('Stock marked as delivered:', response.data);
                    // Optionally, you can remove the purchase order from the current table if needed
                    this.collection.splice(index, 1);
                })
                .catch(error => {
                    // Handle error response
                    console.error('Error marking stock as delivered:', error);
                });
            },
            convertToInputBoxes() {
            const tdElements = this.$el.querySelectorAll('td');
            tdElements.forEach((td) => {
                const text = td.innerText;
                td.innerHTML = `<input type="text" placeholder="${text}">`;
            });
            },
        },
   
        // async created(){
        //     const [res] = await Promise.all([
        //         this.callApi('get', 'api/suppliers'),
        //     ])
        //     if(res.status==200){
        //         this.suppliers = res.data
        //     }else{
        //         this.swr()
        //     }
        //     this.setPage(1);
        // },

        created() {
            this.createdMethods();
        },
        mounted() {
        this.convertToInputBoxes();
        //fetch suppliers
        axios.get('/api/suppliers')
            .then(response => {
            this.suppliers = response.data;
            })
            .catch(error => {
            console.error(error);
            });
             //fetch brands
            axios.get('/api/brands')
            .then(response => {
            this.brands = response.data;
            })
            .catch(error => {
            console.error(error);
            });
        },

        components : {
            deleteModal
        },
        computed : {
            ...mapGetters(['getDeleteModalObj']),
              collection() {
                    if (this.search != ''){
                        return this.purchase_orders.filter(purchase_order => {
                        return purchase_order.soldTo.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.purchase_orders);
                    }
                
                },
        },
        watch : {
            getDeleteModalObj(obj){
                if(obj.isDeleted){
                    // this.tags.splice(obj.deletingIndex,1)
                    this.createdMethods();
                }
            }
        },
        props: ['permission'],
    }
</script>
<style>
input[type="text"]{
  border: none;
  outline: none;
 
}


</style>