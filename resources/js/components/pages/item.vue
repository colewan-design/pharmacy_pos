<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'item').write === true" icon="md-add">Add Item</Button>
                        <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>
                   
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Item Description</th>
                                <!-- <th>Qty</th> -->
                                <th>Price</th>
                                <th>Use</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            
                            <tr v-for="(item,i) in collection" :key="i" v-if="items.length" >
                                <td>{{item.itemId}}</td>
                                <td>{{item.categoryName}}</td>
                                <td>{{item.itemName}}</td>
                                <td>{{item.itemDescription}}</td>
                                <!-- <td>{{item.itemQty}}</td> -->
                                
                                <td>₱{{formatPrice(item.itemPrice)}}</td>
                                <td>{{item.itemUse}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(item,i)" v-if="permission.find(item => item.name === 'item').update === true">Edit</Button>
                                    <!-- <Button type="primary" size="small" @click="viewInventory(item.itemId, item.itemName)" v-if="permission.find(item => item.name === 'inventory').read === true">View Inventory</Button>
                                    <Button type="success" size="small" @click="addNewBatchModal = true; openItemId = item.itemId; itemInventoryModalTitle = item.itemName;" v-if="permission.find(item => item.name === 'inventory').write === true">Add new batch</Button> -->
                                    
                                    <Button type="success" size="small" @click="showPulloutModal(item,index)" v-if="item.departmentId == 4">Pullout</Button>

                                    <Button type="error" size="small" @click="showDeletingModal(item,i)" v-if="permission.find(item => item.name === 'inventory').delete === true">Delete</Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->

                        </table>
                    </div>
                </div>

                <!-- item inventory modal -->
                <Modal
                    v-model="itemInventoryModal"
                    :title="itemInventoryModalTitle"
                    :width="850">
                    <p slot="title"></p>
                    <Card v-if="itemInventory.length > 0">
                        <div class="_overflow _table_div">
                            <table class="_table">
                                <tr>
                                    <th>Date Encoded</th>
                                    <th>Batch Code</th>
                                    <th>Original Quantity</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="batch in itemInventory" :key="batch.batchCode">
                                    <td>{{ batch.dateEncoded }}</td>
                                    <td>{{ batch.batchCode }}</td>
                                    <td>{{ batch.originalQty }}</td>
                                    <td>{{ batch.expiryDate }}</td>
                                    <td><Button 
                                            v-if="permission.find(item => item.name === 'inventory').update === true"
                                            @click="editBatchModal = true; editBatch.qty = batch.originalQty; editBatch.expiryDate = batch.expiryDate; editBatch.batchId = batch.inventoryId; 
                                                editBatch.origQtyVal = batch.originalQty; editBatch.origCurrentQtyVal = batch.currentQty; editBatch.itemId = batch.itemId;">
                                            Edit Batch
                                        </Button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </Card>
                    <Card v-else>
                        <p style="text-align: center;">Inventory empty</p>
                    </Card><br><br>
                    <div slot="footer">
                        <Button @click="itemInventoryModal = false">Close</Button>
                    </div>
                </Modal>

                <Modal v-model="addNewBatchModal" title="Add New Batch">
                    <InputNumber placeholder="Quantity" controls-outside :min="1" v-model="addBatch.qty" style="width: 100%;"></InputNumber><br><br>
                    <input type="date" class="form-control form-control-sm" placeholder="Expiry Date" style="width: 100%;" v-model="addBatch.expiryDate">
                    <div slot="footer">
                        <Button @click="addNewBatchModal = false">Close</Button>
                        <Button type="success" @click="addNewItemBatch()">Add new batch for this item</Button>
                    </div>
                </Modal>

                <Modal v-model="editBatchModal" title="Edit Batch">
                    <InputNumber placeholder="Quantity" controls-outside :min="1" v-model="editBatch.qty" style="width: 100%;"></InputNumber><br><br>
                    <input type="date" class="form-control form-control-sm" placeholder="Expiry Date" style="width: 100%;" v-model="editBatch.expiryDate"><br>
                    <div slot="footer">
                        <Button @click="editBatchModal = false">Close</Button>
                        <Button type="success" @click="editItemBatch()">Submit changes</Button>
                    </div>
                </Modal>

                <div class="btn-toolbar">
                    <div class="btn-group">
                     <button class="btn btn-primary" v-for="p in pagination.pages" @click.prevent="setPage(p)" :key="'page' + p">{{p}}</button>
                    </div>
                </div>
            
                <!-- tag adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add Item"
                    :mask-closable = "false"
                    :closable = "false"
                    width="800">
  
                    <div class="space">
                        <Select v-model="data.categoryId" placeholder="Select Category">
                            <Option :value="category.categoryId" v-for="(category, i) in item_categories" :key="i" v-if="item_categories.length">{{category.categoryName}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>

                    <div class="space">
                        <Input type="text" v-model="data.itemName" placeholder="Item Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.itemDescription" placeholder="Item Description" />
                    </div>
                    <!-- <div class="space">
                        <Input type="text" v-model="data.itemQty" placeholder="Item Qty" />
                    </div> -->
                    <div class="space">
                        <Input type="text" v-model="data.itemPrice" placeholder="Item Price" />
                    </div>

                    <br><hr><br>
                    <!-- proportions per order -->
                    <Card>
                        <p slot="title">Proportions consumed per order</p>
                        <Card v-if="data.rawItemId.length > 0">
                            <div v-for="(rawItem, index) in data.rawItemId" :key="'rii'+index">
                                <div class="row">
                                    <div class="col-md-7">
                                        <Select v-model="data.rawItemId[index]" placeholder="Select Raw Material" filterable>
                                            <Option v-for="(mat, index) in rawMaterials" :key="'rawmat'+index" :value="mat.id">{{ mat.material }}</Option>
                                        </Select>
                                    </div>
                                    <div class="col-md-3">
                                        <InputNumber width="100%" placeholder="Proportions" controls-outside v-model="data.rawItemProportions[index]"></InputNumber>
                                    </div>
                                    <div class="col-md-1">
                                        <Button icon="ios-remove-circle" @click="data.rawItemId.splice(index, 1); data.rawItemProportions.splice(index, 1)" title="Remove"></Button>
                                    </div>
                                </div>
                            </div>
                        </Card><br>
                        <div class="space">
                            <Select v-model="tempRawItemId" placeholder="Select Raw Material" filterable>
                                <Option v-for="(mat, index) in rawMaterials" :key="'rawmat'+index" :value="mat.id">{{ mat.material }}</Option>
                            </Select>
                        </div>
                        <div class="space">
                            <InputNumber placeholder="Proportions" controls-outside v-model="tempRawItemProportions" style="width: 100%;"></InputNumber>
                        </div>
                        <Button @click="addToItemRawMats" type="info" long>Add</Button>
                    </Card>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addItem" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Item'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Item"
                    :mask-closable = "false"
                    :closable = "false"
                    width="800">

                    <div class="space">
                        <Select v-model="editData.categoryId" placeholder="Select Category">
                            <Option :value="category.categoryId" v-for="(category, i) in item_categories" :key="i" v-if="item_categories.length">{{category.categoryName}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.itemName" placeholder="Item Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.itemDescription" placeholder="Item Description" />
                    </div>
                    <!-- <div class="space">
                        <Input type="text" v-model="editData.itemQty" placeholder="Item Qty" />
                    </div> -->
                    <div class="space">
                        <Input type="text" v-model="editData.itemPrice" placeholder="Item Price" />
                    </div>
                     <div class="space">
                            <Select v-model="editData.itemUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>

                    <br><hr><br>
                    <!-- proportions per order -->
                    <Card>
                        <p slot="title">Proportions consumed per order</p>
                        <Card v-if="editData.rawItemId.length > 0">
                            <div v-for="(rawItem, index) in editData.rawItemId" :key="'edit_rii'+index">
                                <div class="row">
                                    <div class="col-md-7">
                                        <Select v-model="editData.rawItemId[index]" placeholder="Select Raw Material" filterable>
                                            <Option v-for="(mat, index) in rawMaterials" :key="'edit_rawmat'+index" :value="mat.id">{{ mat.material }}</Option>
                                        </Select>
                                    </div>
                                    <div class="col-md-4">
                                        <InputNumber placeholder="Proportions" controls-outside v-model="editData.rawItemProportions[index]"></InputNumber>
                                    </div>
                                    <div class="col-md-1">
                                        <Button icon="ios-remove-circle" @click="editData.rawItemId.splice(index, 1); editData.rawItemProportions.splice(index, 1); editData.itemRawEditId.splice(index, 1);" title="Remove"></Button>
                                    </div>
                                </div>
                            </div>
                        </Card><br>
                        <div class="space">
                            <Select v-model="tempRawItemId" placeholder="Select Raw Material" filterable>
                                <Option v-for="(mat, index) in rawMaterials" :key="'edit1_rawmat'+index" :value="mat.id">{{ mat.material }}</Option>
                            </Select>
                        </div>
                        <div class="space">
                            <InputNumber placeholder="Proportions" controls-outside v-model="tempRawItemProportions" style="width: 100%;"></InputNumber>
                        </div>
                        <Button @click="editAddToItemRawMats" type="info" long>Add</Button>
                    </Card>
                  
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editItem" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Item'}}</Button>
                    </div>
                </Modal>

                <Modal v-model="pulloutModal" title="Pullout">
                    <div class="space">
                        <Select v-model="pulloutData.categoryId" placeholder="Select Category">
                            <Option :value="category.categoryId" v-for="(category, i) in item_categories" :key="i" v-if="item_categories.length">{{category.categoryName}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="pulloutData.itemName" placeholder="Item Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="pulloutData.itemDescription" placeholder="Item Description" />
                    </div>
                    <!-- <div class="space">
                        <Input type="text" v-model="data.itemQty" placeholder="Item Qty" />
                    </div> -->
                    <div class="space">
                        <Input type="text" v-model="pulloutData.itemPrice" placeholder="Item Price" />
                    </div>

                    <div slot="footer">
                        <Button @click="pulloutModal = false">Close</Button>
                        <Button type="success" @click="pullout()">Pullout</Button>
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
        props: ['permission'],
        data() {
            return{
                data : {
                    categoryId:'',
                    itemName: '',
                    itemDescription: '',
                    itemQty: 0,
                    itemPrice: '',
                    itemUse: '',
                    rawItemId: [],
                    rawItemProportions: [],
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                items: [],
                editData : {
                    tagName : '',
                    rawItemId: [],
                    rawItemProportions: [],
                },
                pulloutData : {
                    tagName : ''
                },
                index : -1,
                showDeleteModal: false,
                isdeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                item_categories: [],
                perPage: 10,
                pagination: {},
                search:'',
                itemInventoryModal: false,
                itemInventory: [],
                addNewBatchModal: false,
                pulloutModal: false,
                openItemId: '',
                addBatch: {
                    itemId: '',
                    qty: null,
                    expiryDate: '',
                },
                itemInventoryModalTitle: '',
                editBatchModal: false,
                editBatch: {
                    batchId: '',
                    origQtyVal: '',
                    origCurrentQtyVal: '',
                    qty: null,
                    expiryDate: '',
                    itemId: '',
                },
                rawMaterials: [],
                tempRawItemId: '',
                tempRawItemProportions: null,
            }
        },

        methods : {
            formatPrice(value) {
                return value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },
            setPage(p) {
                this.search = '';
                this.pagination = this.paginator(this.items.length, p);
            },
            paginate(items) {
                return _.slice(items, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addItem(){
                if(this.permission.find(item => item.name === 'item').write === true) {
                    if(this.data.itemName.trim()=='') return this.error('Item name is required')
       
                    const res = await this.callApi('post', 'api/create_item', this.data)
                    if(res.status===201){
                        // this.items.unshift(res.data)
                        this.createdMethods();
                        this.success('Item has been added successfully!')
                        this.addModal = false
                        this.data.tagName = '';
                        this.data.categoryId = '';
                        this.data.itemName = '';
                        this.data.itemDescription = '';
                        this.data.itemQty = 0;
                        this.data.itemPrice = '';
                        this.data.itemUse = '';
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

            async editItem() {
                if(this.permission.find(item => item.name === 'item').update === true) {
                    const res = await this.callApi('post', 'api/edit_item', this.editData)
                    if(res.status === 200){
                        // this.items[this.index] = this.editData
                        this.createdMethods();
                        this.success('Item is edited successfully');
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

            showEditModal(item, index){
                let obj ={
                    itemId: item.itemId,
                    categoryId: item.categoryId,
                    itemName : item.itemName,
                    itemDescription : item.itemDescription,
                    itemQty : item.itemQty,
                    itemPrice : item.itemPrice,
                    itemUse : item.itemUse,
                    rawItemId: [],
                    rawItemProportions: [],
                    itemRawEditId: [],
                }
                if(item.rawMaterial.length > 0) {
                    for(var i = 0; i < item.rawMaterial.length; i++) {
                        obj.rawItemId.push(item.rawMaterial[i].raw_materials_id);
                        obj.rawItemProportions.push(item.rawMaterial[i].portionConsumed);
                        obj.itemRawEditId.push(item.rawMaterial[i].id);
                    }
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            showPulloutModal(item, index){
                let obj ={
                    itemId: item.itemId,
                    itemQty: item.itemQty,
                }
                this.pulloutData = obj
                this.pulloutModal = true
                this.index = index
            },

            async pullout(){
      
                    if(this.pulloutData.itemName.trim()=='') return this.error('Item name is required')
       
                    const res = await this.callApi('post', 'api/pullout_item', this.pulloutData)
                    if(res.status===201){
                        // this.items.unshift(res.data)
                        this.createdMethods();
                        this.success('Pullout successfully!')
                        this.pulloutModal = false
                        this.pulloutData.tagName = '';
                        this.pulloutData.categoryId = '';
                        this.pulloutData.itemName = '';
                        this.pulloutData.itemDescription = '';
                        this.pulloutData.itemQty = 0;
                        this.pulloutData.itemPrice = '';
                    }else{
                        if(res.status==422){
                            for(let i in res.pulloutData.errors){
                                this.error(res.pulloutData.errors[i][0])
                            }
                        }else{
                            this.swr()
                        }

                    }
                
            },



            async viewInventory(itemId, itemName) {
                var res = await axios.get('api/get_item_inventory/' + itemId);
                if(res.status === 200) {
                    this.itemInventory = res.data;
                } else {
                    this.$Notice.error({ 
                        title: 'Error',
                        desc: 'Error occurred while fetching item inventory'
                    });
                }

                this.itemInventoryModal = true; 
                this.openItemId = itemId; 
                this.itemInventoryModalTitle = itemName;
            },

            async addNewItemBatch() {
                if(this.permission.find(item => item.name === 'inventory').write === true) {
                    var validate = true;
                    if(this.addBatch.qty <= 0) {
                        this.$Notice.warning({
                            title: 'Warning',
                            desc: 'Quantity must be greater than 0'
                        });
                        validate = false;
                    }
                    if(this.addBatch.expiryDate.trim != '' && this.addBatch.expiryDate != undefined) {
                        var todayDate = new Date();
                        var inputDate = new Date(this.addBatch.expiryDate)                 
                        if(inputDate < todayDate) {
                            this.$Notice.warning({
                                title: 'Warning',
                                desc: 'Expiration date must be greater than the current date'
                            });
                            validate = false;
                        } 
                        // else if(inputDate == 'Invalid Date') {
                        //     this.$Notice.warning({
                        //         title: 'Warning',
                        //         desc: 'Please provide a valid expiration date'
                        //     });
                        //     validate = false;
                        // }
                    } 
                    // else {
                    //     this.$Notice.warning({
                    //         title: 'Warning',
                    //         desc: 'Please provide the expiration date'
                    //     });
                    //     validate = false;
                    // }
                    
                    if(validate === true) {
                        this.addBatch.itemId = this.openItemId;
                        var res = await axios.post('api/add_new_batch', this.addBatch);
                        if(res.status === 200) {
                            // if(Array.isArray(res.data)) {
                            //     var insufficientItems = res.data.join(',');
                            //     this.$Notice.warning({
                            //         title: 'Insufficient Raw Materials',
                            //         desc: 'Please add more stocks to the following items and try again: ' + insufficientItems,
                            //         duration: 15
                            //     });
                            // } else if(res.data == 'ItemRawMaterialNotSet') {
                            //     this.$Notice.warning({
                            //         title: 'Warning',
                            //         desc: 'Please set the proportions consumed per order and try again',
                            //     });
                            // } else {
                                this.$Notice.success({
                                    title: 'Success',
                                    desc: 'Successfully added new item batch'
                                });
                            // }
                            this.addBatch.itemId = '';
                            this.addBatch.qty = null;
                            this.addBatch.expiryDate = '';
                            this.addNewBatchModal = false;
                            this.itemInventoryModal = false;
                            this.openItemId = '';
                            this.itemInventoryModalTitle = '';
                            this.createdMethods();
                        } else {
                            this.$Notice.error({ 
                                title: 'Error',
                                desc: 'Error occurred while saving new item batch'
                            });
                        }
                    }
                }
            },

            async editItemBatch() {
                if(this.permission.find(item => item.name === 'inventory').update === true) {
                    var validate = true;
                    if(this.editBatch.qty <= 0) {
                        this.$Notice.warning({
                            title: 'Warning',
                            desc: 'Quantity must be greater than 0'
                        });
                        validate = false;
                    }
                    if(this.editBatch.expiryDate.trim != '' && this.editBatch.expiryDate != undefined) {
                        var todayDate = new Date();
                        var inputDate = new Date(this.editBatch.expiryDate)
                        if(inputDate < todayDate) {
                            this.$Notice.warning({
                                title: 'Warning',
                                desc: 'Expiration date must be greater than the current date'
                            });
                            validate = false;
                        } else if(inputDate == 'Invalid Date') {
                            this.$Notice.warning({
                                title: 'Warning',
                                desc: 'Please provide the expiration date'
                            });
                            validate = false;
                        }
                    } else {
                        this.$Notice.warning({
                            title: 'Warning',
                            desc: 'Please provide the expiration date'
                        });
                        validate = false;
                    }

                    if(validate === true) {
                        var res = await axios.post('api/edit_batch', this.editBatch);
                        if(res.status === 200) {
                            if(Array.isArray(res.data)) {
                                var insufficientItems = res.data.join(',');
                                this.$Notice.warning({
                                    title: 'Insufficient Raw Materials',
                                    desc: 'Please add more stocks to the following items and try again: ' + insufficientItems,
                                    duration: 15
                                });
                            } else if(res.data == 'ItemRawMaterialNotSet') {
                                this.$Notice.warning({
                                    title: 'Warning',
                                    desc: 'Please set the proportions consumed per order and try again',
                                });
                            } else {
                                this.$Notice.success({
                                    title: 'Success',
                                    desc: 'Successfully updated item batch'
                                });
                            }
                            // this.editBatchModal = false;
                            // this.itemInventoryModal = false;
                            this.createdMethods();
                        } else {
                            this.$Notice.error({ 
                                title: 'Error',
                                desc: 'Error occurred while updating item batch'
                            });
                        }
                    }
                }
            },

            showDeletingModal(item, i) {
                if(this.permission.find(item => item.name === 'item').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_item",
                        data: item,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async createdMethods() {
                const [res,resItemCategory] = await Promise.all([
                    this.callApi('get', 'api/items'),
                    this.callApi('get', 'api/item_categories'),
                ])
                if(res.status==200){
                    this.items = res.data
                }else{
                    this.swr()
                }
                if(resItemCategory .status==200){
                    this.item_categories = resItemCategory.data
                }else{
                    this.swr()
                }
                
                this.setPage(1);
                this.$refs.search.focus();
            },

            async getRawMaterials() {
                var res = await axios.get('api/fetch_raw_mats');
                if(res.status === 200) {
                    this.rawMaterials = res.data;
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: 'Error occurred while loading data'
                    });
                }
            },

            addToItemRawMats() {
                this.data.rawItemId.push(this.tempRawItemId);
                this.data.rawItemProportions.push(this.tempRawItemProportions);
                this.tempRawItemId = '';
                this.tempRawItemProportions = null;
            },

            editAddToItemRawMats() {
                this.editData.rawItemId.push(this.tempRawItemId);
                this.editData.rawItemProportions.push(this.tempRawItemProportions);
                this.tempRawItemId = '';
                this.tempRawItemProportions = null;
            }
        },

        // async created(){
        //     const [res,resItemCategory] = await Promise.all([
        //         this.callApi('get', 'api/items'),
        //         this.callApi('get', 'api/item_categories'),
        //     ])
        //     if(res.status==200){
        //         this.items = res.data
        //     }else{
        //         this.swr()
        //     }
        //     if(resItemCategory .status==200){
		//     	this.item_categories = resItemCategory.data
        //     }else{
        //         this.swr()
        //     }
            
        //     this.setPage(1);
        // },

        created() {
            this.createdMethods();
            this.getRawMaterials();
        },

        components : {
            deleteModal
        },
        computed : {
            ...mapGetters(['getDeleteModalObj']),
            
            collection() {
                if (this.search != ''){
                    return this.items.filter(item => {
                    return item.itemName.toLowerCase().includes(this.search.toLowerCase())
                    })
                }else{
                    return this.paginate(this.items);
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
        }

    }
</script>
