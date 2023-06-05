<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>Item</th>
                                <th>Batch Code</th>
                                <th>Date Encoded</th>
                                <th>Expiry Date</th>
                                <th>Batch Quantity Registered</th>
                            </tr>

                            <tr v-for="batch in inventory" :key="batch.batchCode">
                                <td>{{ batch.itemName }}</td>
                                <td>{{ batch.batchCode }}</td>
                                <td>{{ batch.dateEncoded }}</td>
                                <td>{{ batch.expiryDate }}</td>
                                <td>{{ batch.originalQty }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                inventory: [],
            }
        },
        methods: {
            async getInventoryRecords() {
                var res = await axios.get('./api/get_inventory_records');
                if(res.status === 200) {
                    this.inventory = res.data;
                } else {
                    this.$Notice.error({
                        title: 'Error',
                        desc: 'Error occurred while loading data'
                    });
                }
            }
        },
        mounted() {
            this.getInventoryRecords();
        }
    }
</script>