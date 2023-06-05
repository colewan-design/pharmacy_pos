<template>
  <div class="content">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Role</h3>
                  <!-- <Button >
                    <Icon type="md-add" />Add New Category
                  </Button> -->
                  <div class="card-tools">
                    <button class="btn btn-success" @click="addModal=true" v-if="permission.find(item => item.name === 'role').write === true">Add New <i class="fas fa-user-tag nav-icon"></i></button>
                  </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
						<th>ID</th>
						<th>Role</th>
						<!-- <th>Created at</th> -->
						<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <!-- ITEMS -->
					<tr v-for="(role,i) in roles" :key="i" v-if="roles.length" >
						<td>{{role.id}}</td>
						<td>{{role.roleName}}</td>
						<!-- <td>{{tag.created_at}}</td> -->
						<td>
							<Button type="info" size="small" v-if="permission.find(item => item.name === 'role').update === true" @click="showEditModal(role,i)">Edit</Button>
							<Button type="error" size="small" :disabled="role.id == 1 || role.id == 2 || role.id == 3 || role.id == 4 || role.id == 5 || role.id == 6" 
								v-if="permission.find(item => item.name === 'role').delete === true" @click="showDeletingModal(role, i)" :loading="role.isDeleting">
								Delete
							</Button>
						</td>
					</tr>
                  <!-- ITEMS -->
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			<Page :total="pageInfo.total" :current="pageInfo.current_page" :page-size="parseInt(pageInfo.per_page)" @on-change="getRoleData" v-if="pageInfo" />

				<!-- tag adding modal -->
				     <Modal
						v-model="addModal"
						title="Add Role"
						:mask-closable = "false"
						:closable = "false">
						<Input v-model="data.roleName" placeholder="Add Role Name" />

						<div slot="footer">
							<Button type="default" @click="addModal=false">Close</Button>
							<Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Role'}}</Button>
						</div>
					</Modal>

				<!-- tag edit modal -->
					<Modal
					v-model="editModal"
					title="Edit Role"
					:mask-closable = "false"
					:closable = "false">
					<Input v-model="editData.roleName" placeholder="Edit Role Name" />

					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Role'}}</Button>
					</div>
					</Modal>
 					<deleteModal></deleteModal>

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
				roleName: ''
			},
			addModal : false,
			editModal : false,
			isAdding : false,
			roles: [],
			editData : {
				roleName : ''
			},
			index : -1,
			showDeleteModal: false,
			isdeleting: false,
			deleteItem: {},
			deletingIndex: -1,
			total: 10,
			pageInfo:null
		}
	},

	methods : {
		async add() {
			if(this.permission.find(item => item.name === 'role').write === true) {
				if(this.data.roleName.trim() == '') return this.error('Role name is required!')
				const res = await this.callApi('post', 'api/create_role', this.data)
				if(res.status === 201){
					this.roles.unshift(res.data)
					this.success('Role has been added successfully');
					this.addModal = false;
					this.data.roleName = '';
				}else{
					if(res.status==422){
						if(res.data.errors.roleName){
							this.error(res.data.errors.roleName[0])
						}

					}else{
						this.swr();
					}
					
				}
			}
		},

		async edit() {
			if(this.permission.find(item => item.name === 'role').update === true) {
				if(this.editData.roleName.trim() == '') return this.error('Role name is required!')
				const res = await this.callApi('post', 'api/edit_role', this.editData)
				if(res.status === 200){
					this.roles[this.index].roleName = this.editData.roleName
					this.success('Role has been  edited successfully');
					this.editModal = false;
				}else{
					if(res.status==422){

					}else{
						this.swr();
					}
					
				}
			}
		},
		showEditModal(role, index){
			let obj ={
				id: role.id,
				roleName : role.roleName
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},
		async deleteTag() {
			this.isdeleting =true
			const res = await this.callApi('post', 'api/delete_role', this.deleteItem)
			if(res.status===200){
				this.roles.splice(this.deletingIndex,1)
				this.success('Tag has been deleted successfully!');
			}else{
				this.swr();
			}
			this.isdeleting =false
			this.showDeleteModal = false
		},
		showDeletingModal(role,i) {
			const deleteModalObj  =  {
				showDeleteModal: true, 
				deleteUrl : 'api/delete_role', 
				data : role, 
				deletingIndex: i, 
				isDeleted : false,
			}
			this.$store.commit('setDeletingModalObj', deleteModalObj)
			console.log('delete method called')
			// this.deleteItem = tag
			// this.deletingIndex = i
			// this.showDeleteModal = true
		},
		async getRoleData(page = 1){
			const res = await this.callApi('get', `api/roles_pagination?page=${page}&total=${this.total}`)
			if(res.status==200){
				this.roles = res.data.data
				this.pageInfo =res.data
			}else{
				this.swr()
			}	
		}
	},

	async created(){
		this.getRoleData()
	},
	components : {
		deleteModal
	}, 
	computed : {
		...mapGetters(['getDeleteModalObj'])
	},
	watch : {
		getDeleteModalObj(obj){
			if(obj.isDeleted){
				// this.tags.splice(obj.deletingIndex,1)
				this.getRoleData()
			}
		}
	},
	props: ['permission'],
}
</script>