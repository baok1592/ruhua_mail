import http from '../common/axios.js'

//获取所有分类
function get_banner(id) {
	let url = 'banner/get_banner?id='
	return http.get(url + id).then(res => {
		return res;
	})
}

function get_banner_content() {
	let url = 'get_banner_content'
	return http.get(url).then(res => {
		return res;
	})
}
export default {
	get_banner,
	get_banner_content
}
