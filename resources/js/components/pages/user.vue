<template>
  <div class="content">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>
                  <!-- <Button >
                    <Icon type="md-add" />Add New Category
                  </Button> -->
                  <div class="card-tools">
                    <button class="btn btn-success" @click="addModal=true" v-if="permission.find(item => item.name === 'user').write === true">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                  </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
					<th>ID</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <!-- ITEMS -->
					<tr v-for="(user,i) in users" :key="i" v-if="users.length" >
						<td>{{user.id}}</td>
						<td>{{user.fullname}}</td>
						<td>{{user.email}}</td>
						<td v-for="(r, i) in roles" :key="i" v-if="r.id == user.role_id ">{{r.roleName}}</td>
						<td>
							<Button type="info" size="small" v-if="permission.find(item => item.name === 'user').update === true" @click="showEditModal(user,i)">Edit</Button>
							<Button type="error" size="small" v-if="permission.find(item => item.name === 'user').delete === true" @click="showDeletingModal(user, i)" :loading="user.isDeleting">Delete</Button>
						</td>
					</tr>
                  <!-- ITEMS -->
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
				<Page :total="pageInfo.total" :current="pageInfo.current_page" :page-size="parseInt(pageInfo.per_page)" @on-change="getUserData" v-if="pageInfo" />
				<!-- tag adding modal -->
				     <Modal
						v-model="addModal"
						title="Add admin"
						:mask-closable = "false"
						:closable = "false">
						<div class="space">
							<Input type="text" v-model="data.fullname" placeholder="FullName" />
						</div>
						<div class="space">
							<Input type="email" v-model="data.email" placeholder="Email" />
						</div>
						<div class="space">
							<Input type="password" v-model="data.password" placeholder="Password" />
						</div>

						<div class="space">
							<Select v-model="data.role_id" placeholder="Select admin type">
								<Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
								<!-- <Option value="Editor" >Editor</Option> -->
							</Select>
						</div>

						<div class="space">
							<Input type="text" v-model="data.position" placeholder="Position" />
						</div>

						<!-- <div class="space">
							<Input type="text" v-model="data.agency" placeholder="Agency" />
						</div> -->

						<div slot="footer">
							<Button type="default" @click="addModal=false">Close</Button>
							<Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add user'}}</Button>
						</div>
					</Modal>

				<!-- tag edit modal -->
					<Modal
					v-model="editModal"
					title="Edit User"
					:mask-closable = "false"
					:closable = "false">

						<div class="space">
							<Input type="text" v-model="editData.fullname" placeholder="FullName" />
						</div>
						<div class="space">
							<Input type="email" v-model="editData.email" placeholder="Email" />
						</div>
						<div class="space">
							<Input type="password" v-model="editData.password" placeholder="Password" />
						</div>

						<div class="space">
							<Select v-model="editData.role_id" placeholder="Select admin type">
								<Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
							</Select>
						</div>

						<div class="space">
							<Input type="text" v-model="editData.position" placeholder="Position" />
						</div>

						<!-- <div class="space">
							<Input type="text" v-model="editData.agency" placeholder="Agency" />
						</div> -->

					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Admin'}}</Button>
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
				fullName: '',
				email: '',
				password: '',
				role_id: null,
				position: '',
				// agency: '',
			},
			addModal : false,
			editModal : false,
			isAdding : false,
			users: [],
			editData : {
				fullname: '',
				email: '',
				password: '',
				role_id: null
			},
			index : -1,
			showDeleteModal: false,
			isdeleting: false,
			deleteItem: {},
			deletingIndex: -1,
			roles: [],
			total: 10,
			pageInfo:null
		}
	},

	methods : {
		async addAdmin(){
			if(this.permission.find(item => item.name === 'user').write === true) {
				if(this.data.fullname.trim()=='') return this.error('Full name is required')
				if(this.data.email.trim()=='') return this.error('Email is required')
				if(this.data.password.trim()=='') return this.error('Password is required')
				if(this.data.position.trim()=='') return this.error('Position is required')
				// if(this.data.agency.trim()=='') return this.error('Agency is required')
				
				// if(!this.data.role_id) return this.error('User type  is required')
				
				const res = await this.callApi('post', 'api/create_user', this.data)
				if(res.status===201){
					this.users.unshift(res.data)
					this.success('Admin user has been added successfully!')
					this.addModal = false
					this.data.fullname = ''
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

		async editAdmin() {
			if(this.permission.find(item => item.name === 'user').update === true) {
				if(this.editData.fullname.trim()=='') return this.error('Full name is required')
				if(this.editData.email.trim()=='') return this.error('Email is required')
				if(!this.editData.role_id) return this.error('User type  is required')
				if(this.editData.position.trim()=='') return this.error('Position is required')
				// if(this.editData.agency.trim()=='') return this.error('Agency is required')

				const res = await this.callApi('post', 'api/edit_user', this.editData)
				if(res.status === 200){
					this.users[this.index].fullname = this.editData.fullname
					this.users[this.index].email = this.editData.email
					this.users[this.index].role_id = this.editData.role_id
					this.users[this.index].position = this.editData.position
					// this.users[this.index].agency = this.editData.agency
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
		showEditModal(user, index){
			let obj ={
				id: user.id,
				fullname : user.fullname,
				email : user.email,
				role_id : user.role_id,
				position: user.position,
				// agency: user.agency
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},
		async getUserData(page = 1){
			const res = await this.callApi('get', `api/users?page=${page}&total=${this.total}`)
			if(res.status==200){
				this.users = res.data.data
				this.pageInfo =res.data
			}else{
				this.swr()
			}	
		},
		showDeletingModal(user, i) {
			if(this.permission.find(item => item.name === 'user').delete === true) {
				const deleteModalObj = {
					showDeleteModal: true,
					deleteUrl: "api/delete_user",
					data: user,
					deletingIndex: i,
					isDeleted: false
				};
				this.$store.commit("setDeletingModalObj", deleteModalObj);
			}
		},
		async createdMethods(){
			const [res,resRole] = await Promise.all([
				this.getUserData(),
				this.callApi('get', 'api/roles'),
			]) 
			if(resRole.status==200){
				this.roles = resRole.data
			}else{
				this.swr()
			}
		},
	},

	// async created(){
	// 	const [res,resRole] = await Promise.all([
	// 		this.getUserData(),
	// 		this.callApi('get', 'api/roles'),
	// 	]) 
	// 	if(resRole.status==200){
	// 		this.roles = resRole.data
	// 	}else{
	// 		this.swr()
	// 	}
	// },
	created() {
		this.createdMethods();
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
				this.createdMethods();
			}
		}
	},
	props: ['permission'],
}
</script>