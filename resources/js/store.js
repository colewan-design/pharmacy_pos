import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state : {
        deleteModalObj : {
            showDeleteModal: false,
            deleteUrl : '',
            data : null,
            deletingIndex: -1,
            isDeleted : false,
        },
        user: false,
        userPermission: null
    },

    getters: {
        getDeleteModalObj(state){
            return state.deleteModalObj
        },
        getUserPermission(state){
            return state.userPermission
        }
    },

    mutations : {
        setDeleteModal(state, data){
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl : '',
                data : null,
                deletingIndex: -1,
                isDeleted : data,
            }
            state.deleteModalObj = deleteModalObj
        },
        setDeletingModalObj(state, data){
            state.deleteModalObj = data
        },
        setUpdateUser(state, data){
            state.user = data
        },
        setUserPermission(state, data){
            state.userPermission = data
        }
    }
})
