import http from '../common/axios.js'

// 验证token
const verifyToken = async function() {
	let url = 'index/verify_token';
	return await http.get(url).then(async res => {
		return await res;
	})
}


export default {
	verifyToken,
}