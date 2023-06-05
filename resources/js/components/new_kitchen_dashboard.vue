<style>
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab{
        border-radius: 0;
        background: #fff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active{
        border-top: 1px solid #3399ff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active:before{
        content: '';
        display: block;
        width: 100%;
        height: 1px;
        background: #3399ff;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>


<style scoped>
    .layout{
        border: 1px solid #d7dde4;
        background: #f5f7f9;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }
    .layout-logo{
        width: 100px;
        height: 30px;
        background: #5b6270;
        border-radius: 3px;
        float: left;
        position: relative;
        top: 15px;
        left: 20px;
    }
    .layout-nav{
        width: 420px;
        margin: 0 auto;
        margin-right: 20px;
    }
    .layout-footer-center{
        text-align: center;
    }
</style>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        padding: 10px;
        grid-column-gap: 10px;
        grid-row-gap: 5px;
    }
    .grid-item {
        background-color: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(0, 0, 0, 0.8);
        padding: 20px;
        font-size: 30px;
        text-align: center;
    }
</style>

<template>
    <div class="layout">
        <Layout>
            <Header>
                <Menu mode="horizontal" theme="dark" active-name="1">
                    <div class="layout-logo"></div>
                    <div class="layout-nav">
                        <MenuItem name="1">
                            <Icon type="ios-navigate"></Icon>
                            Item 1
                        </MenuItem>
                        <MenuItem name="2">
                            <Icon type="ios-keypad"></Icon>
                            Item 2
                        </MenuItem>
                        <MenuItem name="3">
                            <Icon type="ios-analytics"></Icon>
                            Item 3
                        </MenuItem>
                        <MenuItem name="4">
                            <Icon type="ios-paper"></Icon>
                            Item 4
                        </MenuItem>
                    </div>
                </Menu>
            </Header>
            <Content :style="{padding: '0 50px'}">
                <Breadcrumb :style="{margin: '20px 0'}">
                    <BreadcrumbItem>New Kitchen Dashboard</BreadcrumbItem>
                </Breadcrumb>
                <Card>
                    <div style="min-height: 800px;" >
                        <template >
                         <div class="demo-split">
                            <Split v-model="split1">
                                <div slot="left" class="demo-split-pane">
                                    <template>
                                    <div class="wrapper">
                                        <div class="container" v-dragula="colOne" bag="first-bag">
                                            <!-- with click -->
                                            <div v-for="text in colOne" @click="onClick">{{text}} [click me]</div>
                                        </div>
                                        
                                    </div>

                                    </template>
                                </div>
                                <div slot="right" class="demo-split-pane">
                                   <div class="container" v-dragula="colTwo" bag="first-bag">
                                        <div v-for="text in colTwo">{{text}}</div>
                                    </div>
                                </div>
                                <div slot="right" class="demo-split-pane">
                                    Right Pane
                                </div>
                            
                            </Split>

                        </div>
                        </template>
                    </div>
                </Card>
            </Content>
            <Footer class="layout-footer-center">2021-2099 &copy; POS</Footer>
        </Layout>
    </div>

</template>

<script>
 export default {
    data() {
        return {
            split1: 0.5,
            colOne: [
            'You can move these elements between these two containers',
            'Moving them anywhere else isn"t quite possible',
            'There"s also the possibility of moving elements around in the same container, changing their position'
            ],
            colTwo: [
            'This is the default use case. You only need to specify the containers you want to use',
            'More interactive use cases lie ahead',
            'Another message'
            ],
            categories: [
            [1, 2, 3],
            [4, 5, 6]
            ],
            copyOne: [
            'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
            'Aenean commodo ligula eget dolor. Aenean massa.'
            ],
            copyTwo: [
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
            'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.'
            ]
        }
        
    },
    created: function () {
         const service = Vue.$dragula.$service
         service.options('my-drake', {
         direction: 'horizontal'

        })
    },
    ready: function () {
        var _this = this
        Vue.vueDragula.eventBus.$on(
        'drop',
        function (args) {
            console.log('drop: ' + args[0])
            console.log(_this.categories)
        }
        )
    Vue.vueDragula.eventBus.$on(
      'dropModel',
      function (args) {
        console.log('dropModel: ' + args)
        console.log(_this.categories)
      }
    )
  },
  methods: {
    onClick: function () {
      console.log(Vue.vueDragula.find('first-bag'))
      window.alert('click event')
    },
    testModify: function () {
      this.categories = [
        ['a', 'b', 'c'],
        ['d', 'e', 'f']
      ]
    }
  }
    }
</script>