import http from '../common/axios.js'

//获取默认地址
function get_default_address() {
	let url = 'address/get_default_address'
	return http.get(url).then(res => {
		return res;
	})
}
//获取用户地址
function get_all_address() {
	let url = 'address/get_all_address'
	return http.get(url).then(res => {
		return res;
	})
}
//获取地址列表
function get_address() {
	let url = 'index/get_address'
	return http.get(url).then(res => {
		return res;
	})
}
//获取地址详情
function get_one_address(id) {
	let url = 'address/get_one_address?id='
	return http.get(url + id).then(res => {
		return res;
	})
}
//修改地址
function edit_address(data) {
	let url = 'address/edit_address'
	return http.post(url, data).then(res => {
		return res;
	})
}
//添加地址
function add_address(data) {
	let url = 'address/add_address'
	return http.post(url, data).then(res => {
		return res;
	})
}
// 删除地址
function deleteAddress(id) {
	let url = 'address/del_address';
	return http.put(url, {id: id}).then(res => {
		return res;
	})
}
// 设置默认地址
function setDefaultAddress(id) {
	let url = 'address/set_default_address';
	return http.post(url, {id: id}).then(res => {
		return res;
	})
}

export default {
	get_default_address,
	get_all_address,
	get_address,
	get_one_address,
	edit_address,
	add_address,
	deleteAddress,
	setDefaultAddress,
}
