import axios from 'axios'

const bearerToken = localStorage.getItem('Bearer')

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Authorization'] = bearerToken
axios.defaults.withCredentials = true;

const api = axios.create({

})

export default ({ Vue }) => {
  Vue.prototype.$axios = api
}

export { api }