import http from '../common/axios.js'

// 提交评论
function setComment(data) {
	let url = 'order/user/set_pj';
	return http.post(url, data).then(res => {
		return res;
	})
}

// 获取某个商品评论
function getCommentOne(id) {
	let url = 'product/get_evaluate';
	return http.get(url, {id: id}).then(res => {
		return res;
	})
}

export default {
	setComment,
	getCommentOne,
}