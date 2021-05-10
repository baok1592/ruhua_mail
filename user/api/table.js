import http from '../common/axios.js'

// 获取所有餐桌
const getTableAll = () => {
	let url = 'index/get_all_zz';
	return http.get(url).then(res => {
		return res;
	})
}

export default {
	getTableAll,
}