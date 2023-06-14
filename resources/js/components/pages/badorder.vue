<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <!-- <Button @click="addModal=true" v-if="permission.find(item => item.name === 'badorder').write === true"><Icon type="md-add" /> Add Purchase Order</Button> -->
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
                                <!-- <th>Action</th> -->
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(badorder,i) in collection" :key="i" v-if="badorders.length" >
                                <td>{{badorder.purchaseOrderId}}</td>
                                <td>{{badorder.supplierName}}</td>
                                <td>{{badorder.itemName}}</td>
                                <td>{{badorder.itemDescription}}</td>
                                <td>{{badorder.itemQty}}</td>
                                <td>{{badorder.fromLocation}}</td>
                                <!-- <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'badorder').update === true" @click="showEditModal(badorder,i)">Edit</Button>
                                    <Button type="error" size="small" v-if="permission.find(item => item.name === 'badorder').delete === true" @click="showDeletingModal(badorder,i)" icon="md-add"><Icon type=""  />Delete</Button>
                                </td> -->
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
                <!-- <Modal
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
                </Modal> -->

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
                isAdding : false,
                bad_orders: [],
                suppliers: [],
                editData : {
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
                this.pagination = this.paginator(this.badorders.length, p);
            },
            paginate(badorders) {
                return _.slice(badorders, this.pagination.startIndex, this.pagination.endIndex + 1)
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
                
                if(this.permission.find(item => item.name === 'badorder').write === true) {
                    const res = await this.callApi('post', 'api/create_badorder', this.data)
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

            showDeletingModal(badorder, i) {
                if(this.permission.find(item => item.name === 'badorder').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_badorder",
                        data: badorder,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async editPurchaseOrder() {
                if(this.permission.find(item => item.name === 'badorder').update === true) {
                    const res = await this.callApi('post', 'api/edit_badorder', this.editData)
                    if(res.status === 200){
                        // this.badorders[this.index] = this.editData
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

            showEditModal(badorder, index){
                let obj ={
                    purchaseOrderId: badorder.purchaseOrderId,
                    supplierName : badorder.supplierName,
                    itemName : badorder.itemName,
                    itemDescription : badorder.itemDescription,
                    itemQty : badorder.itemQty,
                    fromLocation : badorder.fromLocation,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            async createdMethods() {
                const [res] = await Promise.all([
                    this.callApi('get', 'api/bad_orders'),
                ])
                if(res.status==200){
                    this.badorders = res.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
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
                        return this.badorders.filter(badorder => {
                        return badorder.supplierName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.badorders);
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
