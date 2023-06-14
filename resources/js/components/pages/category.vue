<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin 
                        <Button @click="addModal=true" v-if="permission.find(item => item.name === 'category').write === true"><Icon type="md-add" /> Add Category</Button>
                         <Input v-model="search" placeholder="Search Here!" clearable style="width: 100%" ref="search" />
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Department</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Use</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(category,i) in collection" :key="i" v-if="categories.length" >
                                <td>{{category.categoryId}}</td>
                                <td>{{category.departmentName}}</td>
                                <td>{{category.categoryName}}</td>
                                <td>{{category.categoryDescription}}</td>
                                <td>{{category.categoryUse}}</td>
                                <td>
                                    <Button type="info" size="small" v-if="permission.find(item => item.name === 'category').update === true" @click="showEditModal(category,i)" icon="md-add">Edit</Button>
                                    <Button type="error" size="small" v-if="permission.find(item => item.name === 'category').delete === true" @click="showDeletingModal(category,i)" icon="md-add"><Icon type=""  />Delete</Button>
                                    
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
                    title="Add Category"
                    :mask-closable = "false"
                    :closable = "false">
  
                    <div class="space">
                        <Select v-model="data.departmentId" placeholder="Select Department">
                            <Option :value="department.departmentId" v-for="(department, i) in category_departments" :key="i" v-if="category_departments.length">{{department.departmentName}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.categoryName" placeholder="Category Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.categoryDescription" placeholder="Category Description" />
                    </div>
                    <div class="space">
                            <Select v-model="data.categoryStyle" placeholder ="Button Color" style="width:200px">
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
                        <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Category'}}</Button>
                    </div>
                </Modal>

                <!-- tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Department"
                    :mask-closable = "false"
                    :closable = "false">

                    <div class="space">
                        <Select v-model="editData.departmentId" placeholder="Select Department">
                            <Option :value="department.departmentId" v-for="(department, i) in category_departments" :key="i" v-if="category_departments.length">{{department.departmentName}}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.categoryName" placeholder="Category Name" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.categoryDescription" placeholder="Category Description" />
                    </div>
                     <!-- <div class="space">
                            <Select v-model="editData.categoryStyle" placeholder ="Button Color" style="width:200px">
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
                    </div> -->
                    <div class="space">
                            <Select v-model="editData.categoryUse" style="width:200px">
                            <Option value="Y">Y</Option>
                            <Option value="N">N</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Category'}}</Button>
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
                    categoryName: '',
                    categoryDescription: '',
                    categoryStyle:'',
                    categoryUse: ''
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                categories: [],
                editData : {
                    tagName : ''
                },
                index : -1,
                showDeleteModal: false,
                isdeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                category_departments: [],
                perPage: 10,
                pagination: {},
                search:'',
            }
        },

        methods : {
            setPage(p) {
                this.search = '';
                this.pagination = this.paginator(this.categories.length, p);
            },
            paginate(categories) {
                return _.slice(categories, this.pagination.startIndex, this.pagination.endIndex + 1)
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

            async addCategory(){
                if(this.data.categoryName.trim()=='') return this.error('Category name is required')
       
                if(this.permission.find(item => item.name === 'category').write === true) {
                    const res = await this.callApi('post', 'api/create_category', this.data)
                    if(res.status===201){
                        // this.categories.unshift(res.data)
                        this.createdMethods();
                        this.success('Category has been added successfully!');
                        this.addModal = false;
                        this.data.tagName = '';
                        this.data.departmentId = '';
                        this.data.categoryName =  '';
                        this.data.categoryDescription =  '';
                        this.data.categoryStyle = '';
                        this.data.categoryUse = '';
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

            async editCategory() {
                const res = await this.callApi('post', 'api/edit_category', this.editData)
                if(this.permission.find(item => item.name === 'category').update === true) {
                    if(res.status === 200){
                        if(res.data == false || res.data == 'false') {
                            this.warning('This category has menu items that are currently being used. Please disable the menu items under this category to disable');
                        } else {
                            this.success('this is edited successfully');
                        }
                        // this.categories[this.index] = this.editData
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

            showEditModal(category, index){
                console.log('test');
                let obj ={
                    categoryId: category.categoryId,
                    departmentId: category.departmentId,
                    categoryName : category.categoryName,
                    categoryDescription : category.categoryDescription,
                    categoryStyle : category.categoryStyle,
                    categoryUse : category.categoryUse,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },

            showDeletingModal(category, i) {
                if(this.permission.find(item => item.name === 'category').delete === true) {
                    const deleteModalObj = {
                        showDeleteModal: true,
                        deleteUrl: "api/delete_category",
                        data: category,
                        deletingIndex: i,
                        isDeleted: false
                    };
                    this.$store.commit("setDeletingModalObj", deleteModalObj);
                }
            },

            async createdMethods() {
                const [res,resCategoryDepartment] = await Promise.all([
                    this.callApi('get', 'api/categories'),
                    this.callApi('get', 'api/category_departments'),
                ])
                if(res.status==200){
                    this.categories = res.data
                }else{
                    this.swr()
                }
                if(resCategoryDepartment.status==200){
                    this.category_departments = resCategoryDepartment.data
                }else{
                    this.swr()
                }
                this.setPage(1);
                this.$refs.search.focus();
            }
        },

        // async created(){
        //     const [res,resCategoryDepartment] = await Promise.all([
        //         this.callApi('get', 'api/categories'),
        //         this.callApi('get', 'api/category_departments'),
        //     ])
        //     if(res.status==200){
        //         this.categories = res.data
        //     }else{
        //         this.swr()
        //     }
        //     if(resCategoryDepartment.status==200){
		//     	this.category_departments = resCategoryDepartment.data
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
                        return this.categories.filter(category => {
                        return category.categoryName.toLowerCase().includes(this.search.toLowerCase())
                        })
                    }else{
                        return this.paginate(this.categories);
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
