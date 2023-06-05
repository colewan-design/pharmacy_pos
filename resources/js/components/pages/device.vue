<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'device').write === true"><Icon type="md-add" /> Add Device</Button>
                         <Input v-model="search" placeholder="Search Here!" clearable style="width: 880px" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Department</th>
                                <th>Device Name</th>
                                <th>Device Description</th>
                                <th>Use</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(device,i) in collection" :key="i" v-if="devices.length" >
                                <td>{{device.deviceId}}</td>
                                <td>{{device.departmentName}}</td>
                                <td>{{device.deviceName}}</td>
                                <td>{{device.deviceDescription}}</td>
                                <td>{{device.deviceUse}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(device,i)" v-if="permission.find(item => item.name === 'device').update === true">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(device,i)" v-if="permission.find(item => item.name === 'device').delete === true">Delete</Button>
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
                    title="Add Device"
                    :mask-closable = "false"
                    :closable = "false">
  
                    <div class="space">
                        <Select v-model="data.departmentId" placeholder="Select Department">
                            <Option :value="department.departmentId" v-for="(department, i) in device_departments" :key="i" v-if="device_departments.length">{{department.departmentName}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.deviceName" placeholder="Device Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.deviceDescription" placeholder="Device Description" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addDevice" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Device'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Device"
                    :mask-closable = "false"
                    :closable = "false">

                    <div class="space">
                        <Select v-model="editData.departmentId" placeholder="Select Department">
                            <Option :value="department.departmentId" v-for="(department, i) in device_departments" :key="i" v-if="device_departments.length">{{department.departmentName}}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.deviceName" placeholder="Device Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.deviceDescription" placeholder="Device Description" />
                    </div>
                    <div class="space">
                            <Select v-model="editData.deviceUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editDevice" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Device'}}</Button>
                    </div>
                </Modal>

                <deleteModal></deleteModal>
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
                    departmentId:'',
                    deviceName: '',
                    deviceDescription: '',
                    deviceUse: ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                devices: [],
                editData : {
                    tagName : ''
                },
                index : -1,
                showDeleteModal: false,
                isdeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                device_departments: [],
                perPage: 10,
                pagination: {},
                search:'',
            }
        },

        methods : {
            setPage(p) {
                this.search = '';
                this.pagination = this.paginator(this.devices.length, p);
            },
            paginate(devices) {
                return _.slice(devices, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addDevice(){
                if(this.data.deviceName.trim()=='') return this.error('Device name is required')
       
                if(this.permission.find(item => item.name === 'device').write === true) {
                    const res = await this.callApi('post', 'api/create_device', this.data)
                    if(res.status===201){
                        // this.devices.unshift(res.data)
                        this.createdMethods();
                        this.success('Device has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.departmentId = '';
                        this.data.deviceName =  '';
                        this.data.deviceDescription =  '';
                        this.data.deviceUse =  '';
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

            async editDevice() {
                if(this.permission.find(item => item.name === 'device').update === true) {
                    const res = await this.callApi('post', 'api/edit_device', this.editData)
                    if(res.status === 200){
                        // this.devices[this.index] = this.editData
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

            showEditModal(device, index){
                let obj ={
                    deviceId: device.deviceId,
                    departmentId: device.departmentId,
                    deviceName : device.deviceName,
                    deviceDescription : device.deviceDescription,
                    deviceUse : device.deviceUse,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            showDeletingModal(device, i) {
                if(this.permission.find(item => item.name === 'device').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_device",
                        data: device,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async createdMethods(){
                const [res,resDeviceDepartment] = await Promise.all([
                    this.callApi('get', 'api/devices'),
                    this.callApi('get', 'api/device_departments'),
                ])
                if(res.status==200){
                    this.devices = res.data
                }else{
                    this.swr()
                }
                if(resDeviceDepartment.status==200){
                    this.device_departments = resDeviceDepartment.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            },
        },

        // async created(){
        //     const [res,resDeviceDepartment] = await Promise.all([
        //         this.callApi('get', 'api/devices'),
        //         this.callApi('get', 'api/device_departments'),
        //     ])
        //     if(res.status==200){
        //         this.devices = res.data
        //     }else{
        //         this.swr()
        //     }
        //     if(resDeviceDepartment.status==200){
		//     	this.device_departments = resDeviceDepartment.data
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
                        return this.devices.filter(device => {
                        return device.deviceName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.devices);
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
