<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'department').write === true"><Icon type="md-add" /> Add Department</Button>
                        <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Department Name</th>
                                <th>Department Description</th>
                                <th>Use</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(department,i) in collection" :key="i" v-if="departments.length" >
                                <td>{{department.departmentId}}</td>
                                <td>{{department.departmentName}}</td>
                                <td>{{department.departmentDescription}}</td>
                                <td>{{department.departmentUse}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'department').update === true" @click="showEditModal(department,i)">Edit</Button>
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
                    title="Add Department"
                    :mask-closable = "false"
                    :closable = "false">
                    <div class="space">
                        <Input type="text" v-model="data.departmentName" placeholder="Department Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.departmentDescription" placeholder="Department Description" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addDepartment" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Department'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Department"
                    :mask-closable = "false"
                    :closable = "false">
            
                    <div class="space">
                        <Input type="text" v-model="editData.departmentName" placeholder="Department Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.departmentDescription" placeholder="Department Description" />
                    </div>
                    <div class="space">
                            <Select v-model="editData.departmentUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>
            
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editDepartment" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Department'}}</Button>
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
                    departmentName: '',
                    departmentDescription: '',
                    departmentUse: ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                departments: [],
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
                this.pagination = this.paginator(this.departments.length, p);
            },
            paginate(departments) {
                return _.slice(departments, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addDepartment(){
                if(this.data.departmentName.trim()=='') return this.error('Department name is required')
                
                if(this.permission.find(item => item.name === 'department').write === true) {
                    const res = await this.callApi('post', 'api/create_department', this.data)
                    if(res.status===201){
                        // this.departments.unshift(res.data)
                        this.createdMethods();
                        this.success('Department has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.departmentName = '';
                        this.data.departmentDescription = '';
                        this.data.departmentUse = '';
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

            async editDepartment() {
                if(this.permission.find(item => item.name === 'department').update === true) {
                    const res = await this.callApi('post', 'api/edit_department', this.editData)
                    if(res.status === 200){
                        // this.departments[this.index] = this.editData
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

            showEditModal(department, index){
                let obj ={
                    departmentId: department.departmentId,
                    departmentName : department.departmentName,
                    departmentDescription : department.departmentDescription,
                    departmentUse : department.departmentUse,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            async createdMethods() {
                const [res] = await Promise.all([
                    this.callApi('get', 'api/departments'),
                ])
                if(res.status==200){
                    this.departments = res.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            }
        },
   
        // async created(){
        //     const [res] = await Promise.all([
        //         this.callApi('get', 'api/departments'),
        //     ])
        //     if(res.status==200){
        //         this.departments = res.data
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
                        return this.departments.filter(department => {
                        return department.departmentName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.departments);
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
