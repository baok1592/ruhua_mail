import http from '../common/axios.js'

//获取下单可用优惠卷
function get_order_coupon(data) {
	let url = 'coupon/user/order_coupon'
	return http.post(url, data).then(res => {
		return res;
	})
}
//获取用户优惠卷
function get_coupon() {
	let url = 'coupon/user/get_coupon'
	return http.get(url).then(res => {
		return res;
	})
}
//获取所有优惠卷
function get_all_coupon() {
	let url = 'coupon/get_coupon'
	return http.get(url).then(res => {
		return res;
	})
}
//用户领取优惠券
function user_lq_coupon(id) {
	let url = 'coupon/add_coupon?id='+id
	return http.get(url).then(res => {
		return res;
	})
}
export default {
	get_order_coupon,
	get_coupon,
	get_all_coupon,
	user_lq_coupon
}
