<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'account_expense').write === true"><Icon type="md-add" />Account Expense</Button>
                         <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Account Code</th>
                                <th>Account Description</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(accountexpense,i) in collection" :key="i" v-if="accountexpenses.length" >
                                <td>{{accountexpense.accountExpenseId}}</td>
                                <td>{{accountexpense.accountCode}}</td>
                                <td>{{accountexpense.accountDescription}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'account_expense').update === true" @click="showEditModal(accountexpense,i)">Edit</Button>
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
                    title="Add Account Expense"
                    :mask-closable = "false"
                    :closable = "false">
  
                    <div class="space">
                        <Input type="text" v-model="data.accountCode" placeholder="Account Code" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.accountDescription" placeholder="Account Description" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addAccountExpense" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Account Expense'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Account Expense"
                    :mask-closable = "false"
                    :closable = "false">

                   <div class="space">
                        <Input type="text" v-model="editData.accountCode" placeholder="Account Code" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.accountDescription" placeholder="Account Description" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editAccountExpense" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Account Expense'}}</Button>
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
                    accountExpenseId:'',
                    accountCode: '',
                    accountDescription: '',
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                accountexpenses: [],
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
                this.pagination = this.paginator(this.accountexpenses.length, p);
            },
            paginate(accountexpenses) {
                return _.slice(accountexpenses, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addAccountExpense(){
                if(this.permission.find(item => item.name === 'account_expense').write === true) {
                    if(this.data.accountDescription.trim()=='') return this.error('Account Code is required')
       
                    const res = await this.callApi('post', 'api/create_account_expense', this.data)
                    if(res.status===201){
                        // this.accountexpenses.unshift(res.data)
                        this.createdMethods();
                        this.success('Account Expense has been added successfully!')
                        this.addModal = false
                        this.data.tagName = '';
                        this.data.accountExpenseId = '';
                        this.data.accountCode = '';
                        this.data.accountDescription = '';
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

            async editAccountExpense() {
                if(this.permission.find(item => item.name === 'account_expense').update === true) {
                    const res = await this.callApi('post', 'api/edit_account_expense', this.editData)
                    if(res.status === 200){
                        // this.accountexpenses[this.index] = this.editData
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

            showEditModal(accountexpense, index){
                let obj ={
                    accountExpenseId: accountexpense.accountExpenseId,
                    accountCode: accountexpense.accountCode,
                    accountDescription : accountexpense.accountDescription,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            async createdMethods(){
                const [res] = await Promise.all([
                    this.callApi('get', 'api/account_expense'),
                ])
                if(res.status==200){
                    this.accountexpenses = res.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            },
        },

      

        // async created(){
        //     const [res] = await Promise.all([
        //         this.callApi('get', 'api/account_expense'),
        //     ])
        //     if(res.status==200){
        //         this.accountexpenses = res.data
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
                        return this.accountexpenses.filter(accountexpense => {
                        return accountexpense.accountDescription.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.accountexpenses);
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
