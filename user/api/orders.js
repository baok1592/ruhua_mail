import http from '../common/axios.js'

//获取未支付订单
function get_not_order() {
	let url = 'order/user/not_order'
	return http.get(url).then(res => {
		return res;
	})
}
//获取历史订单
function get_all_order() {
	let url = 'order/user/all_order'
	return http.get(url).then(res => {
		return res;
	})
}
//下单
function order_create(data) {
	let url = 'order/create'
	return http.post(url, data).then(res => {
		return res;
	})
}
//支付
function order_pay(data) {
	let url = 'order/pay/pre_order'
	return http.post(url, data).then(res => {
		uni.removeStorageSync('cart')
		uni.removeStorageSync('shopcart')
		return res;
	})
}
//支付
function H5_order_pay(data) {
	let url = 'order/gzh_pay'
	return http.post(url, data).then(res => {
		return res;
	})
}
// 删除未支付订单
function deleteOrder(id) {
	let url = 'order/user/del_order';
	return http.put(url, {id: id}).then(res => {
		return res;
	})
}
// 获取某个订单信息
function getOrderInfo(id) {
	let url = 'order/user/get_order_one?id=' + id;
	return http.get(url).then(res => {
		return res;
	})
}

export default {
	get_not_order,
	get_all_order,
	order_create,
	order_pay,
	deleteOrder,
	getOrderInfo,
	H5_order_pay
}
