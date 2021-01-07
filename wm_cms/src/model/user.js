import http from "../common/axios.js"

//获取所有用户
function get_all_user(){
	let url = 'user/admin/get_all'
	return http.get(url).then(res=>{
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



export default{
	get_all_user, 
	edit_userinfo,
	get_user_log,
	del_user,
}