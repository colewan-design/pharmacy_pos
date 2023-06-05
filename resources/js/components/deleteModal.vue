<template>
    <div>
        <!-- delete modal -->
        <Modal :value="getDeleteModalObj.showDeleteModal" width="360" :closable="false">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Are you sure you want to delete ?</p>
            </div>
            <div slot="footer">
                <Button @click="closeModal()" size="large">Close</Button>
                <Button type="error" size="large" :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        data(){
            return{
                isDeleting : false,
            }
        },

        methods : {
            async deleteTag(){
                this.isDeleting = true
                const res = await this.callApi('delete', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data)
                if(res.status===200){
                    if(res.data == false || res.data == 'false') {
                        this.$Notice.warning({
                            title: 'Warning',
                            desc: 'This item is still in use or has subitems that are currently being used. Please disable and delete the subitems under this item to delete'
                        })
                    } else {
                        this.success(this.getDeleteModalObj.successMsg)
                        this.$store.commit('setDeleteModal', true)
                    }
                }else{
                    this.swr()
                    this.$store.commit('setDeleteModal', false)
                }
                this.isDeleting = false
            },
            closeModal(){
                this.$store.commit('setDeleteModal', false)
            }
        },

        computed : {
            ...mapGetters(['getDeleteModalObj'])
        }
    }
</script>
