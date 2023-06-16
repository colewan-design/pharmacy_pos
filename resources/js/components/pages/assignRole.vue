<template>
  <div class="content">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Assign Role
                  <Select v-model="data.id"  placeholder="Select admin type" style="width:300px" @on-change="changeAdmin">
                    <Option v-for="(r, i) in roles" :key="i" :value="r.id" v-if="roles.length">{{r.roleName}}</Option>
                </Select>
                </h3>
                  <!-- <Button >
                    <Icon type="md-add" />Add New Category
                  </Button> -->

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Navigation Name</th>
                      <th>View</th>
                      <th>Add</th>
                      <th>Update</th>
                      <th>Delete</th>
                      <th>Select/Unselect All</th>
                    </tr>
                  </thead>
                  <tbody>
                  <!-- ITEMS -->
                  <tr v-for="(r, i) in resources" :key="'item'+i">
                    <td>{{r.resourceName}}</td>
                    <td><Checkbox v-model="r.read" 
                      :disabled="permission.find(item => item.name === 'assignRole').write === false && permission.find(item => item.name === 'assignRole').update === false" @click="r.read = r.write = r.update = r.delete = true;">
                      </Checkbox>
                    </td>
                    <td><Checkbox v-model="r.write"
                      :disabled="permission.find(item => item.name === 'assignRole').write === false && permission.find(item => item.name === 'assignRole').update === false" @click="r.read = r.write = r.update = r.delete = true;">
                      </Checkbox>
                    </td>
                    <td><Checkbox v-model="r.update"
                      :disabled="permission.find(item => item.name === 'assignRole').write === false && permission.find(item => item.name === 'assignRole').update === false" @click="r.read = r.write = r.update = r.delete = true;">
                      </Checkbox>
                    </td>
                    <td><Checkbox v-model="r.delete"
                      :disabled="permission.find(item => item.name === 'assignRole').write === false && permission.find(item => item.name === 'assignRole').update === false" @click="r.read = r.write = r.update = r.delete = true;">
                      </Checkbox>
                    </td>
                    <td>
                      <Button type="text" v-if="permission.find(item => item.name === 'assignRole').write === true || permission.find(item => item.name === 'assignRole').update === true" @click="r.read = r.write = r.update = r.delete = true;">Select All</Button>
                      <Button type="text" v-if="permission.find(item => item.name === 'assignRole').write === true || permission.find(item => item.name === 'assignRole').update === true" @click="r.read = r.write = r.update = r.delete = false;">Unselect All</Button>
                    </td>
                  </tr>
                  <!-- ITEMS -->
                  </tbody>

                </table>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                  <!-- <Button type="primary" :loading="isSending" :disabled="isSending" @click="assignRoles">Assign</Button> -->
                  <button type="button" class="btn btn-success" :loading="isSending" :disabled="isSending" @click="assignRoles" 
                    v-if="permission.find(item => item.name === 'assignRole').write === true || permission.find(item => item.name === 'assignRole').update === true">
                    Assign Role
                  </button>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        id: null
      },
      isSending : false,

      roles: [],
      resources: [
            {resourceName: 'Kitchen Dashboard', read: false, write: false, update: false, delete: false, name: 'kitchen_dashboard', icon: 'ios-restaurant'},
            {resourceName: 'Bar Dashboard', read: false, write: false, update: false, delete: false, name: 'bar_dashboard', icon: 'ios-wine'},
            {resourceName: 'Cashier Dashboard', read: false, write: false, update: false, delete: false, name: 'dashboard', icon: 'ios-cash'},
            {resourceName: 'Outsourced Dashboard', read: false, write: false, update: false, delete: false, name: 'outsourced_dashboard', icon: 'ios-repeat'},
            {resourceName: 'Reports', read: false, write: false, update: false, delete: false, name: 'reports', icon: 'ios-filing'},
            {resourceName: 'Inventory Record', read: false, write: false, update: false, delete: false, name: 'inventory', icon: 'ios-list-box'},
            {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category', icon: 'ios-apps'},
            {resourceName: 'Department', read: false, write: false, update: false, delete: false, name: 'department', icon: 'ios-people'},
            {resourceName: 'Supplier', read: false, write: false, update: false, delete: false, name: 'suppliers', icon: 'ios-people'},
            {resourceName: 'Purchase Order', read: false, write: false, update: false, delete: false, name: 'purchase_order', icon: 'ios-people'},
            {resourceName: 'Delivered Stock', read: false, write: false, update: false, delete: false, name: 'delivered_stock', icon: 'ios-people'},
            
            {resourceName: 'Item', read: false, write: false, update: false, delete: false, name: 'item', icon: 'ios-pricetags'},
            {resourceName: 'Table', read: false, write: false, update: false, delete: false, name: 'table', icon: 'ios-radio-button-off'},
            {resourceName: 'Device', read: false, write: false, update: false, delete: false, name: 'device', icon: 'ios-desktop'},
            {resourceName: 'Expense', read: false, write: false, update: false, delete: false, name: 'expense', icon: 'ios-cash-outline'},
            {resourceName: 'Account Expense', read: false, write: false, update: false, delete: false, name: 'account_expense', icon: 'ios-book-outline'},
            {resourceName: 'Cash In', read: false, write: false, update: false, delete: false, name: 'cashin', icon: 'ios-cash'},
            {resourceName: 'Cash Out', read: false, write: false, update: false, delete: false, name: 'cashout', icon: 'md-cash'},
            {resourceName: 'User', read: false, write: false, update: false, delete: false, name: 'user', icon: 'ios-contact'},
            {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role', icon: 'ios-body'},
            {resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name: 'assignRole', icon: 'ios-clipboard'},
            {resourceName: 'Raw Stock', read: false, write: false, update: false, delete: false, name: 'raw_stock', icon: 'ios-basket'},
        ],
      defaultResourcesPermission: [
            {resourceName: 'Kitchen Dashboard', read: false, write: false, update: false, delete: false, name: 'kitchen_dashboard', icon: 'ios-restaurant'},
            {resourceName: 'Bar Dashboard', read: false, write: false, update: false, delete: false, name: 'bar_dashboard', icon: 'ios-wine'},
            {resourceName: 'Cashier Dashboard', read: false, write: false, update: false, delete: false, name: 'dashboard', icon: 'ios-cash'},
            {resourceName: 'Outsourced Dashboard', read: false, write: false, update: false, delete: false, name: 'outsourced_dashboard', icon: 'ios-repeat'},
            {resourceName: 'Reports', read: false, write: false, update: false, delete: false, name: 'reports', icon: 'ios-filing'},
            {resourceName: 'Inventory Record', read: false, write: false, update: false, delete: false, name: 'inventory', icon: 'ios-list-box'},
            {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category', icon: 'ios-apps'},
            {resourceName: 'Department', read: false, write: false, update: false, delete: false, name: 'department', icon: 'ios-people'},
            {resourceName: 'Supplier', read: false, write: false, update: false, delete: false, name: 'suppliers', icon: 'ios-people'},
            {resourceName: 'Purchase Order', read: false, write: false, update: false, delete: false, name: 'purchase_order', icon: 'ios-people'},
            {resourceName: 'Delivered Stock', read: false, write: false, update: false, delete: false, name: 'delivered_stock', icon: 'ios-people'},


            {resourceName: 'Item', read: false, write: false, update: false, delete: false, name: 'item', icon: 'ios-pricetags'},
            {resourceName: 'Table', read: false, write: false, update: false, delete: false, name: 'table', icon: 'ios-radio-button-off'},
            {resourceName: 'Device', read: false, write: false, update: false, delete: false, name: 'device', icon: 'ios-desktop'},
            {resourceName: 'Expense', read: false, write: false, update: false, delete: false, name: 'expense', icon: 'ios-cash-outline'},
            {resourceName: 'Account Expense', read: false, write: false, update: false, delete: false, name: 'account_expense', icon: 'ios-book-outline'},
            {resourceName: 'Cash In', read: false, write: false, update: false, delete: false, name: 'cashin', icon: 'ios-cash'},
            {resourceName: 'Cash Out', read: false, write: false, update: false, delete: false, name: 'cashout', icon: 'md-cash'},
            {resourceName: 'User', read: false, write: false, update: false, delete: false, name: 'user', icon: 'ios-contact'},
            {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role', icon: 'ios-body'},
            {resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name: 'assignRole', icon: 'ios-clipboard'},
            {resourceName: 'Raw Stock', read: false, write: false, update: false, delete: false, name: 'raw_stock', icon: 'ios-basket'},
        ],
    };
  },

  methods: {
     async assignRoles(){
         let data = JSON.stringify(this.resources)
         const res = await this.callApi('post','api/assign_roles', {'permission' : data, id: this.data.id})
         if(res.status==200){
            // this.success('Role has been assigned successfully!')
            let index = this.roles.findIndex(role => role.id == this.data.id)
            this.roles[index].permission = data
            window.location = '/assignRole'
         }else{
           this.swr()
         }
     },
     changeAdmin(){
       let index = this.roles.findIndex(role => role.id == this.data.id)
       let permission = this.roles[index].permission
       if(!permission){
           this.resources = this.defaultResourcesPermission
       }else{
         this.resources = JSON.parse(permission)
       }
     }

  },

  async created() {
    // console.log(this.$route)
    const res = await this.callApi('get', 'api/roles');
    if (res.status == 200) {
      this.roles = res.data;
      if(res.data.length){
        this.data.id = res.data[0].id;
        if(res.data[0].permission){
          console.log('this.resources');
          console.log(res.data);
          this.resources = JSON.parse(res.data[0].permission);
          //this.resources = this.defaultResourcesPermission
        }
      }
    } else {
      this.swr();
    }
  },
  props: ['permission'],
};
</script>