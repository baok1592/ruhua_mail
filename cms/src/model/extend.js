import http from "../common/axios.js"

//获取所有优惠券
function get_all_coupon(){
	let url = 'coupon/admin/get_coupon'
	return http.get(url).then(res=>{
		return res;
	})
}

//删除优惠券
function del_coupon(id){
	let url = 'coupon/admin/del_coupon'
	return http.put_show(url,{id:id}).then(res=>{
		return res
	})
}

//添加优惠券
function add_coupon(data){
	let url = 'coupon/admin/add_coupon'
	return http.post_show(url,data).then(res=>{
		return res
	})
}

//获取所有广告
function get_all_ad(){
	let url = 'banner/admin/banner_all_item'
	return http.get(url).then(res=>{
		return res
	})
}

//添加广告
function add_ad(data){
	console.log(data)
	let url = 'banner/admin/add_banner'
	return http.post_show(url,data).then(res=>{
		return res
	})
}

//删除广告
function del_ad(id){
	let url = 'banner/admin/del_banner'
	return http.put_show(url,id).then(res=>{
		return res
	})
}

//获取所有满减商品
function get_all_mj(){
	let url = 'reduction/admin/get_all_reduction'
	return http.get(url).then(res=>{
		return res
	})
}

//获取所有未参加满减活动的商品
function get_all_no_mj(){
	let url = ''
	return http.get(url).then(res=>{
		return res
	})
}

//新增满减活动
function add_mj(id){
	let url = ''
	return http.post_show(url,id).then(res=>{
		return res
	})
}

//删除满减活动
function del_mj(id){
	let url = 'reduction/admin/del_reduction?id='
	return http.put_show(url,{id:id}).then(res=>{
		return res
	})
}

//id获取满减活动
function get_one_mj(id){
	let url = 'reduction/get_one_reduction'
	return http.get(url+"?id="+id).then(res=>{
		return res
	})
}

//获取所有地址
function get_all_address(){
	let url = 'index/get_address'
	return http.get(url).then(res=>{
		return res
	})
}

//添加地址
function add_address(data){
	let url = 'cms/admin/add_region'
	return http.post_show(url,data).then(res=>{
		return res
	})
}

//删除地址
function del_address(id){
	let url = '/cms/admin/del_region'
	return http.Del(url+'?id='+id).then(res=>{
		return res
	})
}

//修改地址
function edit_address(data){
	let url = '/cms/admin/edit_region'
	return http.post_show(url,data).then(res=>{
		return res
	})
}


export default{
	edit_address,
	del_address,
	add_address,
	get_all_address,
	get_one_mj,
	get_all_coupon,
	del_coupon,
	add_coupon,
	get_all_ad,
	add_ad,
	del_ad,
	get_all_mj,
	get_all_no_mj,
	del_mj,
	add_mj
}