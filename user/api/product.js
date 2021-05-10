import http from '../common/axios.js'

//获取商品信息
function get_one_product(id) {
	let url = 'product/get_product?id='
	return http.get(url + id).then(res => {
		return res;
	})
}
//获取订单价格
function get_order_money(data) {
	let url = 'order/get_order_money'
	return http.post(url, data).then(res => {
		return res;
	})
}
//获取商品评价
function get_goods_rate(id) {
	let url = 'rate/goods_rate?id='
	return http.get(url + id).then(res => {
		return res;
	})
}
export default {
	get_one_product,
	get_order_money,
	get_goods_rate
}
