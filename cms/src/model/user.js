import http from "../common/axios.js"

//获取所有用户
function get_all_user(){
	let url = 'user/admin/get_all'
	return http.get(url).then(res=>{
		return res
	})
}

//获取所有用户等级
function get_all_level(){
	let url = 'level/admin/get_all_level'
	return http.get(url).then(res=>{
		return res
	})
}

//添加用户等级
function add_level(data){
	let url = 'level/admin/add_level'
	return http.post_show(url,data).then(res=>{
		return res
	})
}

//删除用户等级 level/admin/del_level?id=1
function del_level(id){
	let url = 'level/admin/del_level'
	return http.put_show(url+"?id="+id).then(res=>{
		return res
	})
}
//修改用户信息
function edit_userinfo(data){
	let url = 'user/admin/edit_user'
	return http.post_show(url,data).then(res=>{
		return res
	})
}
//获取用户日志
// cms/admin/get _one_ user?id=15
function get_user_log(id){
	let url = 'user/admin/get_one_user'
	return http.get(url+'?id='+id).then(res=>{
		return res
	})
}
// 删除用户
function del_user(id){
	let url = 'user/admin/del_user?id='
	return http.Del(url+id).then(res=>{
		return res
	})
}

// 修改用户等级
const editUser = function (data) {
	let url = 'level/admin/edit_level';
	return http.post_show(url, data).then(res => {
		return res;
	})
}

export default{
	del_level,
	get_all_user,
	get_all_level,
	add_level,
	edit_userinfo,
	get_user_log,
	del_user,
	editUser
}