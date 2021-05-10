import http from '../common/axios.js'

//获取商家信息
function get_merchant(){
		let url='index/user/get_merchant'
		return http.get(url).then(res=>{
			return res;
		})
	}
export default {
	get_merchant
	}