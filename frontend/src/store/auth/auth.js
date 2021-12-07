import axios from "axios";
import {
    showErrorNotification,
    showSuccessNotification
} from "../../functions/show-notifications";
import createPersistedState from 'vuex-persistedstate'
import Cookies from "js-cookie";

export default {
    // plugins: [
    //     createPersistedState({
    //         storage: window.sessionStorage
    //     })
    // ],
    state: {
        status: '',
        session: '',
        user: {},
        permissions: []
    },

    getters: {
        isLoggedIn: state => !state.token,
        authStatus: state => state.status,
        authPermissions: state => state.permissions
    },

    mutations: {
        setPermissions: (state, fetchedData) => (state.permissions = fetchedData),
        auth_request(state) {
            state.status = 'loading'

        },
        auth_success(state, user, role) {
            state.status = 'success'
            state.user = user
            state.role = role
        },
        auth_error(state) {
            state.status = 'error'
        },
        logout(state) {
            state.status = ''
            state.session = ''
        }
    },

    actions: {
        // login({ commit }, user) {
        // return new Promise((resolve, reject) => {
        //         commit('auth_request')
        //         axios({ url: `http://127.0.0.1:8000/api/login`, data: user, method: 'POST' })
        //             .then(resp => {
        //                 const session = resp.data.token
        //                 const user = resp.data.user
        //                 const role = resp.data.user.role
        //                 console.log(resp.data)
        //                 this.$session.start()
        //                 // this.$session.set('role', role)

        //                 // this.$session.has('role')
        //             })
        //             .catch(err => {
        //                 console.log(err.message, '`` Error Login');
        //             })
        //     })
        // },

        // register({ commit }, user) {
        //     return new Promise((resolve, reject) => {
        //         commit('auth_request')
        //         axios({ url: `http://127.0.0.1:8000/api/register`, data: user, method: 'POST' })
        //             .then(resp => {
        //                 this.$session.set("token_type", res.data.token_type);
        //                 this.$session.set("user", res.data.user);
        //                 this.$session.set("token", res.data.token);
        //                 axios.defaults.headers.common['Authorization'] = token
        //                 commit('auth_success', token, user)
        //             })
        //             .catch(err => {
        //                 console.log(err);
        //                 commit('auth_error', err)
        //                 // Cookies.remove('Session')
        //                 localStorage.removeItem('Session')
        //                 // reject(err)
        //             })
        //     })
        // },

        // logout({ commit }) {
        //     commit('logout')
        //     Cookies.remove('Session')
        //     localStorage.removeItem('Session')
        //     delete axios.defaults.headers.common['Authorization']
        //     this.$router.push({ name: 'LoginPatient' })
        //     // resolve()

        // }

    }
}