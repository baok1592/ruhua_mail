import http from '@/common/axios'

// 搜索
function searchOrder(data) {
	let url = 'order/admin/get_order';
	return http.post(url, data).then(res => {
		return res;
	})
}

export default {
	searchOrder,
}

