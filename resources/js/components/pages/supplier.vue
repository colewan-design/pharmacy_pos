<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'suppliers').write === true"><Icon type="md-add" /> Add Supplier</Button>
                        <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Supplier Name</th>
                                <th>Supplier Description</th>
                                <th>Use</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(supplier,i) in collection" :key="i" v-if="suppliers.length" >
                                <td>{{supplier.supplierId}}</td>
                                <td>{{supplier.supplierName}}</td>
                                <td>{{supplier.supplierDescription}}</td>
                                <td>{{supplier.supplierUse}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'suppliers').update === true" @click="showEditModal(supplier,i)">Edit</Button>
                                    <Button type="error" size="small" v-if="permission.find(item => item.name === 'suppliers').delete === true" @click="showDeletingModal(supplier,i)" icon="md-add"><Icon type=""  />Delete</Button>
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
                    title="Add Supplier"
                    :mask-closable = "false"
                    :closable = "false">
                    <div class="space">
                        <Input type="text" v-model="data.supplierName" placeholder="Supplier Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.supplierDescription" placeholder="Supplier Description" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addSupplier" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Supplier'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Supplier"
                    :mask-closable = "false"
                    :closable = "false">
            
                    <div class="space">
                        <Input type="text" v-model="editData.supplierName" placeholder="Supplier Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.supplierDescription" placeholder="Supplier Description" />
                    </div>
                    <div class="space">
                            <Select v-model="editData.supplierUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>
            
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editSupplier" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Supplier'}}</Button>
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
                    supplierName: '',
                    supplierDescription: '',
                    supplierUse: ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
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
                this.pagination = this.paginator(this.suppliers.length, p);
            },
            paginate(suppliers) {
                return _.slice(suppliers, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addSupplier(){
                if(this.data.supplierName.trim()=='') return this.error('Supplier name is required')
                
                if(this.permission.find(item => item.name === 'suppliers').write === true) {
                    const res = await this.callApi('post', 'api/create_supplier', this.data)
                    if(res.status===201){
                        // this.suppliers.unshift(res.data)
                        this.createdMethods();
                        this.success('Supplier has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.supplierName = '';
                        this.data.supplierDescription = '';
                        this.data.supplierUse = '';
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

            showDeletingModal(supplier, i) {
                if(this.permission.find(item => item.name === 'suppliers').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_supplier",
                        data: supplier,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async editSupplier() {
                if(this.permission.find(item => item.name === 'suppliers').update === true) {
                    const res = await this.callApi('post', 'api/edit_supplier', this.editData)
                    if(res.status === 200){
                        // this.suppliers[this.index] = this.editData
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

            showEditModal(supplier, index){
                let obj ={
                    supplierId: supplier.supplierId,
                    supplierName : supplier.supplierName,
                    supplierDescription : supplier.supplierDescription,
                    supplierUse : supplier.supplierUse,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            async createdMethods() {
                const [res] = await Promise.all([
                    this.callApi('get', 'api/suppliers'),
                ])
                if(res.status==200){
                    this.suppliers = res.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
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
        components : {
            deleteModal
        },
        computed : {
            ...mapGetters(['getDeleteModalObj']),
              collection() {
                    if (this.search != ''){
                        return this.suppliers.filter(supplier => {
                        return supplier.supplierName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.suppliers);
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
