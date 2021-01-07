import http from "../common/axios.js"

//采集商品
function get_pro_buy_web(web){
	let url='product/copy/get_info'
	return http.post_show(url,web).then(res=>{
		return res;
	})
}
// 新增商品
function add_pro(data){
	let url='product/admin/add_product'
	return http.post_show(url,data).then(res=>{
		return res;
	})
}
//获取所有商品
function get_all_pro(){
	let url='product/admin/all_goods_info'
	//let url='product/get_products'
	return http.get(url).then(res=>{
		return res;
	})
}

//删除商品
function del_pro(id){
	let url='product/admin/del_product?id='+id
	return http.put_show(url).then(res=>{
		return res;
	})
}
//id获取商品
function get_pro_byID(id){
	let url='product/get_product'
	return http.get(url+"?id="+id).then(res=>{
		return res;
	})
}
//修改商品
function edit_pro(data){
	let url='product/admin/edit_product '
	return http.post_show(url,data).then(res=>{
		return res;
	})
}





export default{
	get_pro_buy_web,
	get_all_pro,
	del_pro,
	add_pro,
	get_pro_byID,
	edit_pro
}