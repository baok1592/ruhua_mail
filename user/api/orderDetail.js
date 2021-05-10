import http from '../common/axios.js'

//订单详情
function get_one_order(id){
		let url='order/user/get_order_one?id='
		return http.get(url+id).then(res=>{
			return res;
		})
	}
	export default {
		get_one_order,
	}