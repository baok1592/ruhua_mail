import Vue from 'vue'
import App from './App'
import store from './store'
import api from './api'
import util from './common/util.js'
import {Api_url} from 'common/config.js'
import minxin from './common/mixins/shopro-share.js'
import http from './common/axios.js'
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
Vue.config.productionTip = false
Vue.prototype.$getimg = Api_url
//Vue.use(ElementUI);
App.mpType = 'app'

Vue.prototype.$store = store
Vue.prototype.$api = api
Vue.prototype.$api = http
Vue.prototype.$util = util
Vue.mixin(minxin)

const app = new Vue({
	store,
    ...App
})
app.$mount()
