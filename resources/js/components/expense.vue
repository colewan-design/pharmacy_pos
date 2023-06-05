<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addExpenseModal = true" v-if="permission.find(item => item.name === 'expense').write === true"><Icon type="md-add" /> Add Expense</Button>
                        <Button @click="generateSummaryModal = true;"> Expense Report Summary</Button>
                    </p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>Expense Date</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>

                            <tr v-for="expense in expenses" :key="'expense'+expense.expenseId">
                                <td>{{ expense.expenseDate }}</td>
                                <td>{{ expense.expenseAmount }}</td>
                                <td>
                                    <Button type="primary" v-if="permission.find(item => item.name === 'expense').update === true" @click="editExpenseModal = true; editExpense(expense.expenseId);">Edit</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <Modal
                    v-model="addExpenseModal"
                    title="Add Expense">
                    <div class="space">
                        <Select v-model="accountId" placeholder="Select">
                            <Option v-for="account in accounts" :key="'account'+account.accountExpenseId" :value="account.accountExpenseId">{{ account.accountDescription }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input v-model="accountDesc" v-if="!flagAccountCode" placeholder="Account Description"/>
                    </div>
                    <div class="space">
                        <Input type="number" step="0.01" v-model="expenseAmt" placeholder="Amount"/>
                    </div>
                    <div class="space">
                        <input type="date" class="form-control" v-model="expenseDate">
                    </div>
                    <div class="space">
                        <textarea class="form-control" v-model="expenseRemarks" placeholder="Remarks" rows="3"></textarea>
                    </div>
                    <div slot="footer">
                        <Button @click="addExpenseModal = false">Close</Button>
                        <Button type="primary" @click="addExpense()">Add Expense</Button>
                    </div>
                </Modal>

                <Modal
                    v-model="editExpenseModal"
                    title="Edit Expense">
                    <div class="space">
                        <Select v-model="editData.accountId" placeholder="Select">
                            <Option v-for="account in accounts" :key="'edit'+account.accountExpenseId" :value="account.accountExpenseId">{{ account.accountDescription }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input v-model="editData.accountDesc" v-if="!flagAccountCode" placeholder="Account Description"/>
                    </div>
                    <div class="space">
                        <Input type="number" step="0.01" v-model="editData.expenseAmt" placeholder="Amount"/>
                    </div>
                    <div class="space">
                        <input type="date" class="form-control" v-model="editData.expenseDate">
                    </div>
                    <div class="space">
                        <textarea class="form-control" v-model="editData.remarks" placeholder="Remarks" rows="3"></textarea>
                    </div>
                    <div slot="footer">
                        <Button @click="editExpenseModal = false">Close</Button>
                        <Button type="primary" @click="updateExpense()">Edit Expense</Button>
                    </div>
                </Modal>

                <Modal
                    v-model="generateSummaryModal"
                    title="Generate Expense Report Summary">
                    <div class="row space">
                        <div class="col-sm-5">
                            <input type="date" class="form-control form-control-sm" v-model="filterDate1">
                        </div>
                        <div class="col-sm-1 text-center">
                            <Icon type="md-remove" size="20" />
                        </div>
                        <div class="col-sm-5">
                            <input type="date" class="form-control form-control-sm" v-model="filterDate2">
                        </div>
                    </div>
                    <div class="row space">
                        <div class="col-sm-6">
                            <Select v-model="reportPreparedBy" placeholder="Prepared By">
                                <Option v-for="user in userList" :key="'preparedBy' + user.id" :value="user.fullname">{{ user.fullname }}</Option>
                            </Select>
                        </div>
                        <div class="col-sm-6">
                            <Select v-model="reportReviewedBy" placeholder="Reviewed By">
                                <Option v-for="user in userList" :key="'reviewedBy' + user.id" :value="user.fullname">{{ user.fullname }}</Option>
                            </Select>
                        </div>
                    </div>
                    <div slot="footer">
                        <Button @click="generateSummaryModal = false">Close</Button>
                        <Button :to="'api/expense_summary/' + filterDate1 + '/' + filterDate2 + '/' + reportPreparedBy + '/' + reportReviewedBy" target="_blank">Generate Report</Button>
                    </div>
                </Modal>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            expenses: [],
            addExpenseModal: false,
            accounts: [],
            accountId: '',
            accountDesc: '',
            expenseAmt: 0,
            expenseDate: '',
            flagAccountCode: true,
            editExpenseModal: false,
            editData: {
                expenseId: '',
                accountId: '',
                accountDesc: '',
                expenseAmt: '',
                expenseDate: '',
                remarks: ''
            },
            generateSummaryModal: false,
            filterDate1: '',
            filterDate2: '',
            userList: [],
            reportPreparedBy: '',
            reportReviewedBy: '',
            expenseRemarks: '',
        }
    },
    methods: {
        async getExpenses() {
            var res = await axios.get('./api/get_expenses');
            if(res.status === 200) {
                this.expenses = res.data;
            } else {
                this.$Notice.error({
                    title: 'Error',
                    desc: 'Error occurred while loading data'
                })
            }
        },
        async getAccounts() {
            var res = await axios.get('./api/account_expense');
            if(res.status === 200) {
                this.accounts = res.data;
            } else {
                this.$Notice.error({
                    title: 'Error',
                    desc: 'Error occurred while loading data'
                });
            }
        },
        async addExpense() {
            if(this.permission.find(item => item.name === 'expense').write === true) {
                if(this.accountId != '' && this.expenseAmt > 0 && this.expenseDate != '') {
                    if(this.flagAccountCode === false && this.accountDesc == '') {
                        this.$Notice.warning({
                            title: 'Warning',
                            desc: 'Please provide account description'
                        });
                    } else {
                        var data = {
                            accountId: this.accountId,
                            accountDesc: this.accountDesc,
                            amt: this.expenseAmt,
                            date: this.expenseDate,
                            remarks: this.expenseRemarks
                        };
                        var res = await axios.post('./api/add_expense', data);
                        
                        if(res.status === 201 || res.status === 200) {
                            this.$Notice.success({
                                title: 'Success',
                                desc: 'Saved successfully'
                            });
                            this.addExpenseModal = false;

                            this.accountId = '';
                            this.accountDesc = '';
                            this.expenseAmt = '';
                            this.expenseDate = '';
                            this.expenseRemarks = '';

                            this.getExpenses();
                        } else {
                            this.$Notice.error({
                                title: 'Error',
                                desc: 'Error occurred while saving data'
                            });
                        }
                    }
                } else {
                    this.$Notice.warning({
                        title: 'Warning',
                        desc: 'Please provide all details'
                    });
                }
            }
        },
        async editExpense(expenseId) {
            var res = await axios.get('./api/get_expense/' + expenseId);
            if(res.status === 200) {
                this.editData.expenseId = res.data.expenseId;
                this.editData.accountId = parseInt(res.data.accountExpenseId);
                this.editData.accountDesc = res.data.accountDescription;
                this.editData.expenseAmt = res.data.expenseAmount;
                this.editData.expenseDate = res.data.expenseDate;
                this.editData.remarks = res.data.remarks;
            }
        },
        async updateExpense() {
            if(this.permission.find(item => item.name === 'expense').update === true) {
                var res = await axios.post('./api/update_expense', this.editData);
                if(res.status === 200) {
                    this.$Notice.success({
                        title: 'Success',
                        desc: 'Successfully updated data'
                    });
                    this.editExpenseModal = false;
                    this.getExpenses();
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: 'Error occurred while updating data'
                    });
                }
            }
        },
        async getAllUsers() {
            var res = await axios.get('./api/get_all_users');
            console.log(res);
            if(res.status === 200) {
                this.userList = res.data;
            } else {
                this.$Notice.error({
                    title: 'Error',
                    desc: 'Error occurred while loading data'
                });
            }
        }
    },
    created() {
        this.getExpenses();
        this.getAccounts();
        this.getAllUsers();
    },
    watch: {
        accountId(value) {
            if(this.accounts.find(account => value === account.accountExpenseId).accountCode == '') {
                this.flagAccountCode = false;
            } else {
                this.flagAccountCode = true;
            }
        }
    },
    props: ['permission'],
}
</script>