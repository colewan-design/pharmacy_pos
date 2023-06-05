<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'cashout').write === true"><Icon type="md-add" />Cashout</Button>
                        <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>
                   
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Receive by</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                 
                            <tr v-for="(cashout,i) in collection" :key="i" v-if="cashouts.length" >
                                <td>{{cashout.cashOutId}}</td>
                                <td>{{cashout.receiveBy}}</td>
                                <td>{{formatPrice(cashout.amount)}}</td>
                                <td>{{cashout.note}}</td>
                                <td>{{cashout.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'cashout').update === true" @click="showEditModal(cashout,i)">Edit</Button>
                                    <Button type="info" size="small" @click="printCashout(cashouts,cashout.cashOutId)">Print</Button>
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
                    title="Add CashOut"
                    :mask-closable = "false"
                    :closable = "false">
  
                    <div class="space">
                        <h3>Received By</h3>
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
                        <div class="space">
                        <h3>Note</h3>
                        <Input type="text" v-model="data_cashout.note" />
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addCashOut" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add CashOut'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit CashOut"
                    :mask-closable = "false"
                    :closable = "false">

                    <div class="space">
                        <h3>Received By</h3>
                        <Input type="text" v-model="editData.receiveBy" />
                        </div>
                        <div class="space">
                        <h3>Amount</h3>
                        <InputNumber 
                            :max="1000000000" 
                            :formatter="value => ` ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                            :parser="value => value.replace(/\$\s?|(,*)/g, '')" 
                            v-model="editData.amount" 
                        style="width: 100%;"/>
                        <div class="space">
                        <h3>Note</h3>
                        <Input type="text" v-model="editData.note" />
                        </div>
                    </div>
                  
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editCashOut" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit CashOut'}}</Button>
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
                addModal : false,
                editModal : false,
                isAdding : false,
                //cashin
                data_cashout : {
                    cashOutId:'',
                    receiveBy: '',
                    amount: 0.00,
                    note: '',
                    created_at: '',
                    updated_at: ''
                },
                editData : {
                    tagName : ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                cashouts:[],

                perPage: 10,
                pagination: {},
                search:'',
            }
        },

        methods : {
            
             async printCashout (cashout,cashOutId) {
                var resPrintCashout= await axios.get('api/print_cashout_click/'+cashOutId);
                if(resPrintCashout.status === 200) {
                  
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: '' 
                    });
                }
             },

            formatPrice(value) {
                return value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },
            setPage(p) {
                this.search = '';
                this.pagination = this.paginator(this.cashouts.length, p);
            },
            paginate(cashouts) {
                return _.slice(cashouts, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addCashOut(){
                if(this.permission.find(item => item.name === 'cashout').write === true) {
                    if(this.data_cashout.receiveBy.trim()=='') return this.error('Received by is required')
                    if(this.data_cashout.amount =='') return this.error('Amount is required')
                    if(this.data_cashout.note.trim()=='') return this.error('Note is required')
        
                    let resCashOut = await axios.post('api/add_cashout',this.data_cashout);
                    if(resCashOut.status === 200) {
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: '' 
                        });
                    }
                }
            },

            async editCashOut() {
                if(this.permission.find(item => item.name === 'cashout').update === true) {
                    let resCashOut = await axios.post('api/edit_cashout',this.editData);
                    if(resCashOut.status === 200) {
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: '' 
                        });
                    }
                }
            },

            showEditModal(cashout, index){
                let obj ={
                    cashOutId: cashout.cashOutId,
                    receiveBy: cashout.receiveBy,
                    amount : cashout.amount,
                    note : cashout.note,
                   
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },
        },

        async created(){
            const [resCashout] = await Promise.all([
                this.callApi('get', 'api/cashouts'),
            ])
            if(resCashout.status==200){
                this.cashouts = resCashout.data
            }else{
                this.swr()
            }
            
            this.setPage(1);
            this.$refs.search.focus();
        },
        components : {
            deleteModal
        },
        computed : {
            ...mapGetters(['getDeleteModalObj']),
            
            collection() {
                if (this.search != ''){
                    return this.cashouts.filter(cashout => {
                    return cashout.receiveBy.toLowerCase().includes(this.search.toLowerCase())
                    })
                }else{
                    return this.paginate(this.cashouts);
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
