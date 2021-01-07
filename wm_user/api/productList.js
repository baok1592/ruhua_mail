import http from '../common/axios.js'

//获取最新.推荐。最热商品
function get_one_product(type) {
	let url = 'product/get_recent?type='
	return http.get(url + type).then(res => {
		return res;
	})
}
//获取某分类商品
function get_product(id) {
	let url = 'product/get_cate_pros?id='
	return http.get(url + id).then(res => {
		return res;
	})
}

export default {
	get_one_product,
	get_product
}
