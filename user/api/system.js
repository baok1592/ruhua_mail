import http from '../common/axios.js'

// 获取系统配置
const getSystemConfig = function(type) {
	let url = 'cms/get_config';
	return http.get(url, {type: type}).then(res => {
		return res;
	})
}


export default {
	getSystemConfig,
}