<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'table').write === true"><Icon type="md-add" /> Add Table</Button>
                         <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Table Number</th>
                                <th>Table Name</th>
                                <th>Table Description</th>
                                <th>Table Capacity</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(table,i) in collection" :key="i" v-if="tables.length" >
                                <td>{{table.tableId}}</td>
                                <td>{{table.tableNumber}}</td>
                                <td>{{table.tableName}}</td>
                                <td>{{table.tableDescription}}</td>
                                <td>{{table.tableCapacity}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(table,i)" v-if="permission.find(item => item.name === 'table').update === true">Edit</Button>
                                    <!-- <Button type="error" size="small" @click="showDeleteModal(department,i)">Delete</Button> -->
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
                    title="Add Table"
                    :mask-closable = "false"
                    :closable = "false">
                    <div class="space">
                        <Input type="text" v-model="data.tableNumber" placeholder="Table Number" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.tableName" placeholder="Table Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.tableDescription" placeholder="Table Description" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.tableCapacity" placeholder="Table Capacity" />
                    </div>
                
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addTable" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Table'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Table"
                    :mask-closable = "false"
                    :closable = "false">
            
                    <div class="space">
                        <Input type="text" v-model="editData.tableNumber" placeholder="Table Number" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.tableName" placeholder="Table Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.tableDescription" placeholder="Table Description" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.tableCapacity" placeholder="Table Capacity" />
                    </div>
                    <div class="space">
                            <Select v-model="editData.tableUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>
            
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editTable" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Table'}}</Button>
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
                    tableNumber: '',
                    tableName: '',
                    tableDescription: '',
                    tableCapacity: '',
                    tableUse: ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                tables: [],
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
                this.pagination = this.paginator(this.tables.length, p);
            },
            paginate(tables) {
                return _.slice(tables, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addTable(){
                if(this.data.tableNumber.trim()=='') return this.error('Table Number is required')
       
                if(this.permission.find(item => item.name === 'table').write === true) {
                    const res = await this.callApi('post', 'api/create_table', this.data)
                    if(res.status===201){
                        // this.tables.unshift(res.data)
                        this.createdMethods();
                        this.success('Table has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.tableNumber = '';
                        this.data.tableName = '';
                        this.data.tableDescription = '';
                        this.data.tableCapacity = '';
                        this.data.tableUse = '';
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

            async editTable() {
                if(this.permission.find(item => item.name === 'table').update === true) {
                    const res = await this.callApi('post', 'api/edit_table', this.editData)
                    if(res.status === 200){
                        // this.tables[this.index] = this.editData
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

            showEditModal(table, index){
                let obj ={
                    tableId: table.tableId,
                    tableNumber : table.tableNumber,
                    tableName : table.tableName,
                    tableDescription : table.tableDescription,
                    tableCapacity: table.tableCapacity,
                    tableUse : table.tableUse,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            async createdMethods(){
                const [res] = await Promise.all([
                    this.callApi('get', 'api/tables'),
                ])
                if(res.status==200){
                    this.tables = res.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            },
        },
   
        // async created(){
        //     const [res] = await Promise.all([
        //         this.callApi('get', 'api/tables'),
        //     ])
        //     if(res.status==200){
        //         this.tables = res.data
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
                        return this.tables.filter(table => {
                        return table.tableName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.tables);
                    }
                
                },
        },
        watch : {
            getDeleteModalObj(obj){
                if(obj.isDeleted){
                    this.tags.splice(obj.deletingIndex,1)
                }
            }
        },
        props: ['permission'],
    }
</script>
