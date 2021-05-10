import http from '../common/axios.js'

//小程序获取token
function get_xcx_token(data) {
	let url = 'weixin/get_xcx_token'
	return http.post(url, data).then(res => {
		return res;
	})
}
//更新用户信息
function upinfo(data) {
	let url = 'weixin/upinfo'
	return http.post(url, data).then(res => {
		return res;
	})
}
//获取用户信息
function get_info() {
	let url = 'user/info'
	return http.get(url).then(res => {
		return res;
	})
}
//验证token
function verify_token() {
	let url = 'index/verify_token'
	return http.get(url).then(res => {
		return res;
	})
}

export default {
	get_xcx_token,
	upinfo,
	get_info,
	verify_token
}
