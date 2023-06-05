<template>
    <div>
      <div>
      <!--========== ADMIN SIDE MENU one ========-->
      <div class="_1side_menu" >
        <div class="_1side_menu_logo">
          <h3 style="text-align:center;">POINT OF SALE</h3>
          <!-- <img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/> -->
        </div>

        <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
        <div class="_1side_menu_content">
          <div class="_1side_menu_img_name">
            <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
            <p class="_1side_menu_name"><!-- Admin (POS) --></p>
          </div>

          <!--~~~ MENU LIST ~~~~~~-->
          <div class="_1side_menu_list">
            <ul class="_1side_menu_list_ul">
                <li class="nav-item" v-for="(menuItem, i) in permission" :key="i" v-if="permission.length && menuItem.read">
                  <router-link v-if="menuItem.read === true" :to="'/'+menuItem.name" exact exact-path class="nav-link" :refs="menuItem.name"> <Icon v-if="menuItem.icon" :type="menuItem.icon" /> <p>{{menuItem.resourceName}}</p></router-link>
                </li>
                <!-- href="/logout" -->
                <li><a href="/logout" @click="destroySession"><Icon type="ios-log-out" /> Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
      <!--========== ADMIN SIDE MENU ========-->

      <!--========= HEADER ==========-->
      <div class="header">
        <div class="_2menu _box_shadow">
          <div class="_2menu_logo">
            <ul class="open_button">
              <li>
                <Icon type="ios-list" />
              </li>
              <!--<li><Icon type="ios-albums" /></li>-->
            </ul>
          </div>
        </div>
      </div>
      <!--========= HEADER ==========-->
    </div>
    	  <router-view :permission="permission">
        </router-view>
    </div>
</template>
<script>
export default {
    props: ['user', 'permission'],
    data(){
       return {
          user_permission : []
       }
    },
    created(){
      this.$store.commit('setUpdateUser', this.user)
      this.$store.commit('setUserPermission', this.permission)

      if(!this.$session.has('loadedRedirect')) {
        this.$session.start();
        this.$session.set('loadedRedirect', 'false');
      }
      
      // var res = await Promise([this.redirectTo()]);
      this.redirectTo()
    },
    methods: {
      redirectTo() {
        if(this.$session.get('loadedRedirect') == 'false') {
          if(this.user.role.isAdmin == 1) {
            this.$router.push('reports');
          } else if(this.user.role.isAdmin == 0) {
            if(this.user.role.id == 2) { // kitchen
              this.$router.push('kitchen_dashboard');
            } else if(this.user.role.id == 3) { // bar
              this.$router.push('bar_dashboard');
            } else if(this.user.role.id == 4) { // cashier
              this.$router.push('dashboard');
            } else if(this.user.role.id == 5) { // outsource
              this.$router.push('outsourced_dashboard');
            }
          }
          if(this.$session.has('loadedRedirect')) {
            this.$session.set('loadedRedirect','true')
          }
        }
        return true;
      },
      destroySession() {
        this.$session.set('loadedRedirect', 'false');
      }
    },
}
</script>