<template>
    <div class="content">
        <div class="container-fluid">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                <p class="_title0">Admin 
                    <Button @click="addRawMatsModal = true; editRawMatId = '';" v-if="permission.find(item => item.name === 'raw_materials').write === true"><Icon type="md-add" /> Add Raw Material</Button>
                </p>
                <div class="_overflow _table_div">
                    <table class="_table">
                        <tr>
                            <th>Material</th>
                            <th>Portions</th>
                            <th>Action</th>
                        </tr>

                        <tr v-for="(mats, index) in tblRawMats" :key="'row'+index">
                            <td>{{ mats.material }}</td>
                            <td>{{ mats.portions }}</td>
                            <td>
                                <Button type="info" @click="editRawMatId = mats.id; rawMaterial = mats.material; addRawMatsModal = true;">Edit</Button>
                                <Button type="primary" @click="viewRawMatId = mats.id; rawMatInvName = mats.material; fetchRawMatInventory();">View Inventory</Button>
                                <Button type="success" @click="rawMatBatch.raw_mat_name = mats.material; 
                                    rawMatBatch.raw_mat_id = mats.id; 
                                    addRawMatBatchModal = true; 
                                    rawMatBatch.editRawMatBatchId = '';
                                    rawMatBatch.portions = null;
                                    rawMatBatch.expiryDate = '';
                                    rawMatBatch.value = null;">
                                        Add new batch
                                </Button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- add/edit raw material -->
            <Modal
                v-model="addRawMatsModal"
                title="Add Raw Materials">
                <div class="space">
                    <Input v-model="rawMaterial" placeholder="Enter Item Name" />    
                </div>
                <div slot="footer">
                    <Button @click="addRawMatsModal = false">Close</Button>
                    <Button type="success" @click="saveRawMaterial">Submit</Button>
                </div>
            </Modal>

            <!-- add raw mat batch -->
            <Modal
                v-model="addRawMatBatchModal">
                <p slot="header">{{ rawMatBatch.raw_mat_name }}</p>
                <div class="space">
                    <InputNumber controls-outside style="width: 100%;" v-model="rawMatBatch.portions" placeholder="Enter number of portions" />    
                </div>
                <div class="space">
                    <input type="date" class="form-control" v-model="rawMatBatch.expiryDate" placeholder="Enter expiration date" />    
                </div>
                <div class="space">
                    <InputNumber controls-outside style="width: 100%;" v-model="rawMatBatch.value" placeholder="Enter item value" />    
                </div>

                <div slot="footer">
                    <Button @click="addRawMatBatchModal = false">Close</Button>
                    <Button type="success" @click="saveRawMatBatch">Submit</Button>
                </div>
            </Modal>

            <!-- view raw mat inventory -->
            <Modal
                v-model="viewRawMatInvModal"
                width="600">
                <p slot="header">{{ rawMatInvName }}</p>
                <div class="_overflow _table_div">
                    <table class="_table">
                        <tr>
                            <th>Batch Code</th>
                            <th>Original Proportions</th>
                            <th>Expiration Date</th>
                            <th>Value</th>
                            <!-- <th>Action</th> -->
                        </tr>
                        <tr v-for="(inv, index) in rawMatInventory" :key="'invRow'+index">
                            <td>{{ inv.batchCode }}</td>
                            <td>{{ inv.originalPortions }}</td>
                            <td>{{ inv.expiryDate }}</td>
                            <td>{{ inv.value }}</td>
                            <td>
                                <Button @click="rawMatBatch.editRawMatBatchId = inv.id; 
                                    rawMatBatch.raw_mat_name = rawMatInvName; 
                                    rawMatBatch.raw_mat_id = inv.raw_materials_id; 
                                    rawMatBatch.portions = inv.originalPortions;
                                    rawMatBatch.expiryDate = inv.expiryDate;
                                    rawMatBatch.value = inv.value;
                                    addRawMatBatchModal = true;">
                                    Edit Batch
                                </Button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div slot="footer">
                    <Button @click="viewRawMatInvModal = false">Close</Button>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script>
export default {
    props: ['permission'],
    data() {
        return {
            addRawMatsModal: false,
            rawMaterial: '',
            tblRawMats: [],
            addRawMatBatchModal: false,
            rawMatBatch: {
                raw_mat_name: '',
                raw_mat_id: '',
                portions: null,
                expiryDate: '',
                value: null,
                editRawMatBatchId: '',
            },
            viewRawMatInvModal: false,
            viewRawMatId: '',
            rawMatInventory: [],
            rawMatInvName: '',
            editRawMatId: '',
        }
    },
    methods: {
        async saveRawMaterial() {
            var checkData = true;
            if(this.rawMaterial == '') {
                this.$Notice.warning({
                    title: 'Warning',
                    desc: 'Please provide item name'
                });
                checkData = false;
            }

            if(checkData === true) {
                var res = await axios.post('api/save_raw_mat', {
                    'rawMaterial' : this.rawMaterial,
                    'editRawMatId': this.editRawMatId
                });
                if(res.status === 200 || res.status === 201) {
                    this.$Notice.success({
                        title: 'Success',
                        desc: 'Successfully saved item'
                    });
                    this.rawMaterial = ''
                    this.addRawMatsModal = false;
                    this.editRawMatId = '';
                    this.fetchRawMats();
                } else {
                    this.$Notice.warning({
                        title: 'Error',
                        desc: 'Error occurred while saving the item'
                    });
                }
            }
        },

        async fetchRawMats() {
            var res = await axios.get('api/fetch_raw_mats');
            if(res.status === 200) {
                this.tblRawMats = res.data;
            } else {
                this.$Notice.error({
                    title: 'Error',
                    desc: 'Error occurred while fetching data'
                });
            }
        },

        async saveRawMatBatch() {
            var checkData = true;
            if(this.rawMatBatch.portions <= 0) {
                this.$Notice.warning({
                    title: 'Warning',
                    desc: 'Please provide number of portions'
                });
                checkData = false;
            }
            if(this.rawMatBatch.expiryDate != '' && this.rawMatBatch.expiryDate != undefined) {
                var todayDate = new Date();
                var inputDate = new Date(this.rawMatBatch.expiryDate);

                if(inputDate < todayDate) {
                    this.$Notice.warning({
                        title: 'Warning',
                        desc: 'Expiration date must be greater than the current date'
                    });
                    checkData = false;
                } else if(inputDate == 'Invalid Date') {
                    this.$Notice.warning({
                        title: 'Warning',
                        desc: 'Please provide a valid date'
                    });
                    checkData = false;
                }
            } 
            // else {
            //     this.$Notice.warning({
            //         title: 'Warning',
            //         desc: 'Please provide expiration date'
            //     });
            //     checkData = false;
            // }
            if(this.rawMatBatch.value < 0) {
                this.$Notice.warning({
                    title: 'Warning',
                    desc: 'Please provide a valid item value'
                });
                checkData = false;
            }

            if(checkData === true) {
                var res = await axios.post('api/save_raw_mat_batch', this.rawMatBatch);
                console.log(res);
                if(res.status === 200 || res.status === 201) {
                    if(res.data == 'false') {
                        this.$Notice.success({
                            title: 'Error',
                            desc: 'Error occurred while saving item batch'
                        });
                    } else {
                        this.$Notice.success({
                            title: 'Success',
                            desc: 'Succesfully saved item batch'
                        });
                        this.addRawMatBatchModal = false;
                        if(this.rawMatBatch.editRawMatBatchId != '')
                            this.viewRawMatInvModal = false;
                    }
                    this.fetchRawMats();
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: 'Error occurred while saving item batch'
                    });
                }
            }
        },

        async fetchRawMatInventory() {
            var res = await axios.get('api/fetch_raw_mat_inv/' + this.viewRawMatId);
            if(res.status === 200) {
                this.rawMatInventory = res.data;
                this.viewRawMatInvModal = true;
            } else {
                this.$Notice.error({
                    title: 'Error',
                    desc: 'Error occurred while fetching data'
                });
            }
        },

        
    },
    created() {
        this.fetchRawMats();
    },
}
</script>