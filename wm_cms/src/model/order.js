import http from "../common/axios.js"

//获取所有订单
function get_all_order(){
	let url='order/admin/get_order'
	return http.post(url).then(res=>{
		return res;
	})
}

//id获取订单详情
function get_one_order(id){
	let url='order/admin/get_order_one'
	return http.post(url,{id:id}).then(res=>{
		return res;
	})
}

//获取所有评价
function get_all_evaluate(){
	let url='rate/admin/get_all_rate'
	return http.get(url).then(res=>{
		return res;
	})
}

//删除评价
function del_evaluate(id){
	let url='rate/admin/del_rate?id='+id
	return http.put_show(url,{id:id}).then(res=>{
		return res;
	})
}
//删除订单
function del_order(id){
	let url='order/admin/del_order?id='
	return http.put_show(url+id).then(res=>{
		return res;
	})
}

export default{
	get_all_order,
	get_one_order,
	get_all_evaluate,
	del_evaluate,
	del_order
}