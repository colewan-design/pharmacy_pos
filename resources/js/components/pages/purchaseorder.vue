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
                                <th>ID</th>
                                <th>Supplier Name</th>
                                <th>Item Name</th>
                                <th>Item Description</th>
                                <th>Item Quantity</th>
                                <th>From Location</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(purchase_order,i) in collection" :key="i" v-if="purchase_orders.length" >
                                <td>{{purchase_order.purchaseOrderId}}</td>
                                <td>{{purchase_order.supplierName}}</td>
                                <td>{{purchase_order.itemName}}</td>
                                <td>{{purchase_order.itemDescription}}</td>
                                <td>{{purchase_order.itemQty}}</td>
                                <td>{{purchase_order.fromLocation}}</td>
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
                    :mask-closable = "false"
                    :closable = "false">

                    <div class="space">
                        <AutoComplete v-model="data.supplierName" placeholder="Supplier Name">
                        <Option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.supplierName">{{ supplier.supplierName }}</Option>
                        </AutoComplete>

                    </div>

                    <div class="space">
                        <Input type="text" v-model="data.itemName" placeholder="Item Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.itemDescription" placeholder="Item Description" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.itemQty" placeholder="Item Quantity" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.fromLocation" placeholder="From Location" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addPurchaseOrder" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Purchase Order'}}</Button>
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
                data : {
                    purchaseOrderId: '',
                    supplierName: '',
                    itemName: '',
                    itemDescriptionDescription: '',
                    itemQty: '',
                    fromLocation: '',
                },
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
                if(this.data.supplierName.trim()=='') return this.error('Supplier Name is required')
                
                if(this.permission.find(item => item.name === 'purchase_order').write === true) {
                    const res = await this.callApi('post', 'api/create_purchase_order', this.data)
                    if(res.status===201){
                        // this.suppliers.unshift(res.data)
                        this.createdMethods();
                        this.success('Purchase Order has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.supplierName = '';
                        this.data.itemName = '';
                        this.data.itemDescription = '';
                        this.data.itemQty = '';
                        this.data.fromLocation = '';
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
                itemName: this.editData.itemName,
                itemDescription: this.editData.itemDescription,
                itemQty: itemQty.toString(), // Save the adjusted item quantity to the delivered stocks table
                fromLocation: this.editData.fromLocation,
                };

                // Copy the data from the purchase order to the bad orders table
                const badOrder = {
                purchaseOrderId: this.editData.purchaseOrderId,
                supplierName: this.editData.supplierName,
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
            }
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
        // Make an API call to fetch the data from the suppliers table
        // Example using axios library:
        axios.get('/api/suppliers')
            .then(response => {
            this.suppliers = response.data;
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
                        return purchase_order.supplierName.toLowerCase().includes(this.search.toLowerCase())
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
