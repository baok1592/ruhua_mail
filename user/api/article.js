import http from '../common/axios.js'

// 获取所有的公告
function getNoticeAll() {
	let url = 'article/type_article?type=3';
	return http.get(url).then(res => {
		return res;
	})
}
// 获取一个文章
function getArticleOne(id) {
	let url = 'article/get_one_article';
	return http.get(url, {id: id}).then(res => {
		return res;
	})
}
// 
function getPersonArticle(){
	let url='article/getPersonArtical'
	return http.get(url).then(res=>{
		return res;
	})
}

export default {
	getNoticeAll,
	getArticleOne,
	getPersonArticle
}