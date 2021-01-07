import http from '../common/axios.js'

//搜索
function search(name) {
	let url = 'product/search?name=' + name
	return http.get(url).then(res => {
		return res;
	})
}

export default {
	search
}
