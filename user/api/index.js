import orders from './orders.js'
import productList from './productList.js'
import productDetail from './product.js'
import orderDetail from './orderDetail.js'

const json = {
	orders,
	productList,
	productDetail,
	orderDetail,
}

export default (name, loading = true) => {
	if(loading) {
		uni.showLoading()
	}
	
	return new Promise(resolve => {
		setTimeout(() => {
			uni.hideLoading()
			resolve(json[name])
		}, 500)
	})
}