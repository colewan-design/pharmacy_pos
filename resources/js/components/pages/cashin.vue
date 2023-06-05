<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'cashin').write === true"><Icon type="md-add" />Cashin</Button>
                     <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>
                   
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Given by</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                 
                            <tr v-for="(cashin,i) in collection" :key="i" v-if="cashins.length" >
                                <td>{{cashin.cashInId}}</td>
                                <td>{{cashin.giveBy}}</td>
                                <td>{{formatPrice(cashin.amount)}}</td>
                                <td>{{cashin.note}}</td>
                                <td>{{cashin.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'cashin').update === true" @click="showEditModal(cashin,i)">Edit</Button>
                                    <Button type="info" size="small"  @click="printCashin(cashins,cashin.cashInId)">Print</Button>
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
                    title="Add CashIn"
                    :mask-closable = "false"
                    :closable = "false">
  
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
                        <div class="space">
                        <h3>Note</h3>
                        <Input type="text" v-model="data_cashin.note" />
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addCashIn" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add CashIn'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit CashIn"
                    :mask-closable = "false"
                    :closable = "false">

                    <div class="space">
                        <h3>Given By</h3>
                        <Input type="text" v-model="editData.giveBy" />
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
                        <Button type="primary" @click="editCashIn" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit CashIn'}}</Button>
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
                data_cashin : {
                    cashInId:'',
                    giveBy: '',
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
                cashins:[],

                perPage: 10,
                pagination: {},
                search:'',
            }
        },

        methods : {

             async printCashin (cashin,cashInId) {
                var resPrintCashin = await axios.get('api/print_cashin_click/'+cashInId);
                if(resPrintCashin.status === 200) {
                  
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
                this.pagination = this.paginator(this.cashins.length, p);
            },
            paginate(cashins) {
                return _.slice(cashins, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addCashIn(){
                if(this.permission.find(item => item.name === 'cashin').write === true) {
                    if(this.data_cashin.giveBy.trim()=='') return this.error('Give by is required')
                    if(this.data_cashin.amount =='') return this.error('Amount is required')
                    if(this.data_cashin.note.trim()=='') return this.error('Note is required')
        
                    let resCashIn = await axios.post('api/add_cashin',this.data_cashin);
                    if(resCashIn.status === 200) {
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: '' 
                        });
                    }
                }
            },

            async editCashIn() {
                if(this.permission.find(item => item.name === 'cashin').update === true) {
                    let resCashIn = await axios.post('api/edit_cashin',this.editData);
                    if(resCashIn.status === 200) {
                        location.reload();
                    } else {
                        this.$Notice.error({
                            title: 'Error',
                            desc: '' 
                        });
                    }
                }
            },

            showEditModal(cashin, index){
                let obj ={
                    cashInId: cashin.cashInId,
                    giveBy: cashin.giveBy,
                    amount : cashin.amount,
                    note : cashin.note,
                   
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

        

           

          
        },

        async created(){
            const [resCashin] = await Promise.all([
                this.callApi('get', 'api/cashins'),
            ])
            if(resCashin.status==200){
                this.cashins = resCashin.data
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
                    return this.cashins.filter(cashin => {
                    return cashin.giveBy.toLowerCase().includes(this.search.toLowerCase())
                    })
                }else{
                    return this.paginate(this.cashins);
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
