import http from '../common/axios.js'

//获取所有分类
function get_all_category(){
		let url='category/all_category'
		return http.get(url).then(res=>{
			return res;
		})
	}
export default {
	get_all_category,
	}