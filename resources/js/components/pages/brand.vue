<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'brand').write === true"><Icon type="md-add" /> Add Brand</Button>
                         <Input v-model="search" placeholder="Search Here!" clearable style="width: 100%" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Brand Name</th>
                                <th>Brand Description</th>
                                <th>Use</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(brand,i) in collection" :key="i" v-if="brands.length" >
                                <td>{{brand.brandId}}</td>
                                <td>{{brand.categoryName}}</td>
                                <td>{{brand.brandName}}</td>
                                <td>{{brand.brandDescription}}</td>
                                <td>{{brand.brandUse}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'brand').update === true" @click="showEditModal(brand,i)" icon="md-add">Edit</Button>
                                    <Button type="error" size="small" v-if="permission.find(item => item.name === 'brand').delete === true" @click="showDeletingModal(brand,i)" icon="md-add"><Icon type=""  />Delete</Button>
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
                    title="Add Brand"
                    :mask-closable = "false"
                    :closable = "false">
  
                    <div class="space">
                        <Select v-model="data.categoryId" placeholder="Select Category">
                            <Option :value="category.categoryId" v-for="(category, i) in brand_categories" :key="i" v-if="brand_categories.length">{{category.categoryName}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.brandName" placeholder="Brand Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.brandDescription" placeholder="Brand Description" />
                    </div>
                    <div class="space">
                            <Select v-model="data.brandStyle" placeholder ="Button Color" style="width:200px">
                            <Option value="#FFA07A">LightSalmon</Option>
                            <Option value="#FFB6C1">LightPink</Option>
                            <Option value="#FFA500">Orange</Option>
                            <Option value="#F0E68C">Khaki</Option>
                            <Option value="#DA70D6">Orchid</Option>
                            <Option value="#00FF00">Lime</Option>
                            <Option value="#008000">Green</Option>
                            <Option value="#006400">DarkGreen</Option>
                            <Option value="#008B8B">DarkCyan</Option>
                            <Option value="#00FFFF">Cyan</Option>
                            <Option value="#00BFFF">DeepSkyBlue</Option>
                            <Option value="#F4A460">SandyBrown</Option>
                            <Option value="#808080">Gray</Option>
                        </Select>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addBrand" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Brand'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Brand"
                    :mask-closable = "false"
                    :closable = "false">

                    <div class="space">
                        <Select v-model="editData.categoryId" placeholder="Select Category">
                            <Option :value="category.categoryId" v-for="(category, i) in brand_categories" :key="i" v-if="brand_categories.length">{{category.categoryName}}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.brandName" placeholder="Brand Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.brandDescription" placeholder="Brand Description" />
                    </div>
            
                    <div class="space">
                            <Select v-model="editData.brandUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editBrand" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Brand'}}</Button>
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
                    categoryId:'',
                    brandName: '',
                    brandDescription: '',
                    brandStyle:'',
                    brandUse: ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                brands: [],
                editData : {
                    tagName : ''
                },
                index : -1,
                showDeleteModal: false,
                isdeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                brand_categories: [],
                perPage: 10,
                pagination: {},
                search:'',
            }
        },

        methods : {
            setPage(p) {
                this.search = '';
                this.pagination = this.paginator(this.brands.length, p);
            },
            paginate(brands) {
                return _.slice(brands, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addBrand(){
                if(this.data.brandName.trim()=='') return this.error('Brand name is required')
       
                if(this.permission.find(item => item.name === 'brand').write === true) {
                    const res = await this.callApi('post', 'api/create_brand', this.data)
                    if(res.status===201){
                        // this.brands.unshift(res.data)
                        this.createdMethods();
                        this.success('Brand has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.categoryId = '';
                        this.data.brandName =  '';
                        this.data.brandDescription =  '';
                        this.data.brandStyle = '';
                        this.data.brandUse = '';
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

            async editBrand() {
                const res = await this.callApi('post', 'api/edit_brand', this.editData)
                if(this.permission.find(item => item.name === 'brand').update === true) {
                    if(res.status === 200){
                        if(res.data == false || res.data == 'false') {
                            this.warning('This brand has menu items that are currently being used. Please disable the menu items under this brand to disable');
                        } else {
                            this.success('this is edited successfully');
                        }
                        // this.brands[this.index] = this.editData
                        this.createdMethods();
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

            showEditModal(brand, index){
                console.log('test');
                let obj ={
                    brandId: brand.brandId,
                    categoryId: brand.categoryId,
                    brandName : brand.brandName,
                    brandDescription : brand.brandDescription,
                    brandStyle : brand.brandStyle,
                    brandUse : brand.brandUse,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            showDeletingModal(brand, i) {
                if(this.permission.find(item => item.name === 'brand').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_brand",
                        data: brand,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async createdMethods() {
                const [res,resBrandCategory] = await Promise.all([
                    this.callApi('get', 'api/brands'),
                    this.callApi('get', 'api/brand_categories'),
                ])
                if(res.status==200){
                    this.brands = res.data
                }else{
                    this.swr()
                }
                if(resBrandCategory.status==200){
                    this.brand_categories = resBrandCategory.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            }
        },

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
                        return this.brands.filter(brand => {
                        return brand.brandName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.brands);
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
