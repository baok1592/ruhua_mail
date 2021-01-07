import http from "../common/axios.js"







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
	let url = 'banner/admin/del_banner?id='+id
	return http.put_show(url,id).then(res=>{
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

	get_all_ad,
	add_ad,
	del_ad,


}