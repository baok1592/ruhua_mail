<template>
	<!-- 2021-01-13 18:03 -->
	<view class="container">
		<view class="header">
			<!-- 搜索栏 begin -->
			<view class="search-box">
				<view class="search-input" @tap="showSearch=true">
					<image src="/static/images/common/search-icon.png" class="search-icon"></image>
					<view>搜索</view>
				</view>
			</view>
			<!-- {{'上级码：'+sjm}}
			{{'登录用户身份码：'+sfm}} -->
			<!-- 搜索栏 end -->
			<view class="center">
				<view class="store">
					<view class="title">
						<image :src="Dining_type == '店内就餐' ? 
								'/static/images/common/star_normal.png' : 
								'/static/images/order/order_icon_address.png'"
						 class="left-icon" />
						<!-- 为了测试方便，这里使用静态店铺数据 -->
						<view class="address" @tap="replaceAddress" v-if="Dining_type == '配送'">{{ address?address:'请添加收货地址' }}</view>
						<view class="address" @tap="jumpTableList" v-else>店内就餐<text v-if="table_num">{{' 桌号：'+table_num}}</text>
						<text v-else> ：点击选择桌号</text></view>
						<image src="/static/images/common/black_arrow_right.png" class="right-icon"></image>
					</view>
					<view class="buttons">
						{{Dining_type}}
					</view>
				</view>
			</view>
			<!-- 滚动公告栏 begin -->
			<view class="notices">
				<swiper class="swiper" autoplay vertical :interval="3000" :duration="1000" circular>
					<swiper-item v-for="(notice, index) in notices" :key="index" @tap="jump_notice(notice.id)">
						<view class="swiper-item">
							<image  src="../../static/icon-img/notice.png" class="image"></image>
							<view class="content" v-html="notice.title"></view>
						</view>
					</swiper-item>
				</swiper>
				<view class="more">
					<!-- #ifdef H5 -->
					<!-- <button class="text-share" @tap="show_xia">分享</button> -->
					<!-- #endif -->
					<!-- #ifdef MP-WEIXIN -->
					<!-- <button class="text-share" open-type="share">分享</button> -->
					<!-- #endif -->
					<!-- <image src="/static/images/common/gray_arrow_down.png" class="down-icon"></image> -->
				</view>
			</view>
		</view>
		<!-- 滚动公告栏 end -->
		<view class="main">
			<!-- 左侧菜单 begin -->
			<scroll-view class="menu-bar" scroll-y scroll-with-animation>
				<view class="wrapper">
					<view class="menu-item" @tap="handleMenuSelected(category.category_id)" :class="{active: currentCategoryId == category.category_id}"
					 v-for="(category, index) in categories" :key="index">
						<image style="border-radius: 50%;height: 60px;" :src="getimg + category.category_pic" class="image" mode="widthFix"></image>
						<view class="title">{{ category.category_name }}</view>
					</view>
				</view>
			</scroll-view>
			<!-- 左侧菜单 end -->
			<!-- 右侧商品列表 begin -->
			<scroll-view class="product-section" scroll-y scroll-with-animation :scroll-top="productsScrollTop" @scroll="productsScroll">
				<view class="wrapper">
					<view id="ads">
						<!-- 广告栏1 begin -->
						<swiper class="ads1"  :indicator-dots="true" :autoplay="true" :interval="3000" :duration="1000" circular>
							<swiper-item v-for="(ad, index) in ads1" :key="index">
								<image  :src="Api_url+ad.imgs.url" class="image" mode="widthFix"></image>
							</swiper-item>
						</swiper>
						<!-- 广告栏1 end -->
					</view>
					<!-- 商品 begin -->
					<view class="products-list">
						<view class="products">
							<!-- 商品块 -->
							<view class="product" v-for="(product, key) in productList" :key="key" @tap="showProductDetailModal(product)">
								<image :src="getimg+product.img_id" mode="widthFix" class="image"></image>
								<view class="content">
									<view class="name">{{ product.name }}</view>
									<view class="labels">
										<view class="label" :style="{color: label.label_color, background: $util.hexToRgba(label.label_color, 0.2)}"
										 v-for="label in product.labels" :key="label.id">{{ label.name }}</view>
									</view>
									<view class="description">{{ product.description }}</view>
									<view class="price">
										<view>￥{{ product.price }}</view>
										<actions :materials-btn="!product.is_sku" @materials="showProductDetailModal(product)" :number="productCartNum(product)"
										 @add="handleAddToCart(product)" @minus="handleMinusFromCart(product)" />
									</view>
								</view>
							</view>
							<!-- 商品块 end -->
						</view>
					</view>
					<!-- 商品 end -->
				</view>
			</scroll-view>
			<!-- 右侧商品列表 end -->
		</view>
		<!-- 商品详情 modal begin -->
		<product-modal :product="product" :visible="productModalVisible" @cancel="closeProductDetailModal" @add-to-cart="handleAddToCartInModal" />
		<!-- 商品详情 modal end -->
		<!-- 购物车栏 begin -->
		<cart-bar :cart="cart" :type="Dining_type" @add="handleAddToCart" @minus="handleMinusFromCart" @clear="clearCart"
		 @pay="pay" />
		<!-- 购物车栏 end -->
		<search :show="showSearch" :hotSearch="hotSearch" :categories="categories" @hide="showSearch=false" @choose="showProductDetailModal"></search>
		<view class="meng" v-if="xia" @tap="show_xia">
			<view class="righ"><img src="@/static/icon-img/tou.png"></img></view>
			<view class="one">
				<view class="one-l">
					<view class="one-l-01">1</view>
					<view class="one-l-02">点 击 右 上 角 的</view>
					<view class="one-l-03">⋮</view>
				</view>
			</view>
			<view class="one">
				<view class="one-l">
					<view class="one-l-01">2</view>
					<view class="one-l-02">选 择 在 浏 览 器</view>
					<view class="one-l-03">
						<img src="@/static/icon-img/liu.png"></img>
					</view>
					<view class="one-l-02">中 打 </view>
					<view class="one-l-04">开 即 可 正 常 分 享</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import {
		mapState,
		mapMutations
	} from 'vuex'
	import Actions from './components/actions/actions.vue'
	import CartBar from './components/cartbar/cartbar.vue'
	import ProductModal from './components/product-modal/product-modal.vue'
	import cartPopup from './components/cart-popup/cart-popup.vue'
	import Search from './components/search/search.vue'
	import search_record from '../../api/Search.js'
	import category from '../../api/category.js'
	import productmode from '../../api/productList.js'
	import address from '../../api/address.js'
	import bannerModel from '../../api/banner.js'
	import noticeModel from '../../api/article.js'

	export default {
		components: {
			Actions,
			CartBar,
			ProductModal,
			cartPopup,
			Search,
		},
		data() {
			return {
				hotSearch:[],
				getimg: this.$getimg,
				categories: [{
						category_name: '推荐',
						category_id: 1001,
						level: 1,
						number: 0,
						category_pic: 'uploads/images/tj.jpg',
					},
					{
						category_name: '新品',
						category_id: 1002,
						level: 1,
						number: 0,
						category_pic: 'uploads/images/xp.jpg',
					},
					{
						category_name: '热销',
						category_id: 1003,
						level: 1,
						number: 0,
						category_pic: 'uploads/images/rx.jpg',
					},
					{
						category_name: '满减',
						category_id: 1004,
						level: 1,
						number: 0,
						category_pic: 'uploads/images/hd.jpg',
					}
				],
				cart: [],
				productList: [],
				product: {},
				currentCategoryId: 1001,
				notices: [],
				ads1: [
					// "https://go.cdn.heytea.com/storage/ad/2020/05/28/752a5519e89541bd8417614c599cf8c3.jpg",
					// "https://go.cdn.heytea.com/storage/ad/2020/05/24/38b7f686cf10449c85b0f5489d5d958e.jpg",
					// "https://go.cdn.heytea.com/storage/ad/2020/05/21/2315beb5105944e8b795c5c0084ec99f.jpg",
					// "https://go.cdn.heytea.com/storage/ad/2020/05/21/b88c6780a73249b0b0166784917a5046.jpg"
				],
				ads2: [
					// "https://go.cdn.heytea.com/storage/ad/2020/05/21/acfc6504f3074cf6b730f516adc558f6.jpg",
					// "https://go.cdn.heytea.com/storage/ad/2020/04/26/2373600789c64752b2415293877ead40.jpg",
					// "https://go.cdn.heytea.com/storage/ad/2020/04/22/515df8c726e740089ae4c55582b4ce09.jpg",
					// "https://go.cdn.heytea.com/storage/ad/2020/04/14/d0e51cb22c0a437293c0e6a879b59c7d.jpg"
				],
				productModalVisible: false,
				cartPopupShow: false,
				productsScrollTop: 0,
				showSearch: false,
				Dining_type: '配送',
				is_sku: false,
				address: '',
				Api_url: this.$getimg,
				xia: false,
				table_num: '',
				sfm:0,
				sjm:0
			}
		},
		computed: {
			productCartNum() { //计算单个饮品添加到购物车的数量
				return id => this.cart.reduce((acc, cur) => {
					if (cur.id === id) {
						return acc += cur.number
					}
					return acc
				}, 0)
			},
		},
		async onLoad(options) {
			if(options.type == 'code_order' && options.table_num){
				uni.setStorageSync('Dtype','店内用餐')
				uni.setStorageSync('table_num',options.table_num)
			}
			this.sfm = uni.getStorageSync('sfm')
			
			console.log('xxx1', options)
			// if (uni.getStorageSync('table_num')) {
			if(options && options.sfm){
				
				this.sjm = options.sfm
				console.log('sjm',options)
				uni.setStorageSync('sjm',options.sfm)
			}
			// }

			this.get_cate()
			//this.$nextTick(() => this.calcSize())
			this.show_data();
		},
		async onShow(options) {
			this.get_search_recorde()
			if(options && options.sfm){
				console.log('sjm',options)
				this.sjm = options.sfm
				uni.setStorageSync('sjm',options.sfm)
			}
			// this.show_data();
			let type = await uni.getStorageSync('Dtype')
			let tab_num = await uni.getStorageSync('table_num')
			console.log(tab_num)
			if(!tab_num && type == '店内就餐'){
				
			}else{
				this.table_num = tab_num
			}
			console.log(type, tab_num)
			this.Dining_type = type
			// if (uni.getStorageSync('table_num')) {
			// 	this.table_num = uni.getStorageSync('table_num');
			// 	// uni.removeStorageSync('table_num');
			// }
			if (this.Dining_type == '配送') {
				this.show_data()
			}else{
				this.address = tab_num
			}
			//获取地址
			// address.get_default_address().then(res => {
			// 	if (res.data) {
			// 		this.address = res.data.province + res.data.city + res.data.detail
			// 	}
			// })
		},
		methods: {
			get_cate(){
				category.get_all_category().then(res=>{
					this.categories = this.categories.concat(res.data)
				})
			},
			get_search_recorde(){
				
			},
			async show_data() {
				//获取地址
				address.get_default_address().then(res => {
					if (res.data) {
						this.address = res.data.province + res.data.city + res.data.detail
					}else{
						this.address=''
					}
				})
				//获取推荐商品
				await productmode.get_one_product('recommend').then(res => {
					let arr = []
					for (let k in res.data) {
						let v = res.data[k]
						arr.push(this.reCount(v))
					}
					this.productList = arr
				})
				//获取分类
				// await category.get_all_category().then(res => {
				// 	this.categories = this.categories.concat(res.data)
				// })
				this.currentCategoryId = this.categories.length && this.categories[0].category_id
				// this.getNoticeAll();
				// 获取广告图片
				// this.getBannerImgs();
				
				// let a = category.get_all_category()
				let b = noticeModel.getNoticeAll()
				let c = bannerModel.get_banner(2)
				Promise.all([b,c]).then(res=>{
					// this.categories = this.categories.concat(res[0].data)
					this.notices = res[0].data
					this.ads1 = res[1].data.items
				})
			},
			...mapMutations(['SET_ORDER_TYPE']),
			switchOrderType() {
				if (this.orderType === 'takein') {
					uni.navigateTo({
						url: '/pages/addresses/addresses'
					})
				} else {
					this.SET_ORDER_TYPE('takein')
				}
			},
			handleAddToCart(product) { //添加到购物车
				const index = this.cart.findIndex(item => {
					if (!product.is_sku) {
						return (item.id == product.id) && (item.materials_text == product.materials_text)
					} else {
						return item.id == product.id
					}
				})

				if (index > -1) {
					this.cart[index].number += (product.number || 1)
					return
				}

				let dat = {
					id: product.id,
					name: product.goods_name,
					price: product.price,
					good: product,
					number: product.number || 1,
					sku: product.sku || 0,
					materials_text: product.materials_text || '',
					materials_price: product.materials_price,
					materials_sku_id: product.materials_sku_id || '',
				};
				// 判断是否有 sku
				if (product.sku && product.sku[0] && product.sku[0].sku_id) {
					dat.is_sku = product.sku[0].sku_id;
				} else {
					dat.is_sku = 0;
				}
				// 判断购物车中是否已经存在该商品 id 和 规格id
				let flag = false;
				for (let k in this.cart) {
					if (this.cart[k].id == dat.id && this.cart[k].materials_sku_id == dat.materials_sku_id) {
						this.cart.splice(k, 1);
						this.cart.push(dat);
						flag = true;
					}
				}
				if (!flag) {
					this.cart.push(dat);
				}
				// console.log('cart:', this.cart)
			},
			handleMinusFromCart(product) { //从购物车减商品
				let index
				if (product.is_sku) {
					index = this.cart.findIndex(item => item.id == product.id)
				} else {
					index = this.cart.findIndex(item => (item.id == product.id) && (item.materials_text == product.materials_text))
				}
				this.cart[index].number -= 1
				if (this.cart[index].number <= 0) {
					this.cart.splice(index, 1)
				}
			},
			showProductDetailModal(product) {
				// console.log('product', product);
				this.product = product
				this.productModalVisible = true
			},
			handleAddToCartInModal(product) {
				this.handleAddToCart(product)
				this.closeProductDetailModal()
			},
			closeProductDetailModal() {
				this.productModalVisible = false
				this.product = {}
			},
			openCartDetailsPopup() {
				this.$refs['cartPopup'].open()
			},
			clearCart() {
				this.cart = [];
				uni.removeStorageSync('cart');
			},
			handleMenuSelected(id) {
				this.productsScrollTop = this.categories.find(item => item.category_id == id).top
				this.getperductlist(id)
				this.$nextTick(() => this.currentCategoryId = id)
			},
			productsScroll({
				detail
			}) {
				const {
					scrollTop
				} = detail
				let tabs = this.categories.filter(item => item.top <= scrollTop).reverse()
				if (tabs.length > 0) {
					this.currentCategoryId = tabs[0].category_id
				}
			},
			calcSize() {
				let h = 0
				let view = uni.createSelectorQuery().select('#ads')
				view.fields({
					size: true
				}, data => {
					h += Math.floor(data.height)
				}).exec()

				this.categories.forEach(item => {
					let view = uni.createSelectorQuery().select(`#products-${item.category_id}`)
					view.fields({
						size: true
					}, data => {
						item.top = h
						h += Math.floor(data.height)
						item.bottom = h
					}).exec()
				})
			},
			pay() {
				let Dtype = uni.getStorageSync('Dtype')
				if(Dtype == '配送'){
					if (this.address || this.Dining_type != '配送') {
						uni.setStorageSync('cart', this.cart)
						uni.navigateTo({
							url: '/pages/order/preview?sid=1&type=' + this.Dining_type
						})
					} else {
						uni.showToast({
							title: '请添加收货地址',
							icon: 'none'
						})
					}
				}
				if(Dtype == '店内就餐'){
					let tab_num = uni.getStorageSync('table_num')
					if(tab_num ){
						uni.setStorageSync('cart', this.cart)
						uni.navigateTo({
							url: '/pages/order/preview?sid=1&type=' + this.Dining_type
						})
					}else{
						uni.showToast({
							title: '请选择桌号',
							icon: 'none'
						})
					}
				}

			},
			//数据重组
			reCount(res) {
				let arr = []
				if (res.sku && res.sku[0]) {
					this.is_sku = true
					let json = JSON.parse(res.sku[0].json)
					res['form'] = json.tree[0].v[0]
					for (let k in json.list) {
						let v = json.list[k]
						arr.push({
							id: v.id,
							pid: v.s1 - k,
							name: v.s1_name,
							price: v.price,
							oldprice: v.price,
							select: k == 0 ? true : false
						})
					}
					res['form_child'] = arr
				}
				res['number'] = 1
				res['id'] = res.goods_id
				res['name'] = res.goods_name
				return res
			},
			getperductlist: function(val) {
				if (val == 1001) {
					productmode.get_one_product('recommend').then(res => {
						let arr = []
						for (let k in res.data) {
							let v = res.data[k]
							arr.push(this.reCount(v))
						}
						this.productList = arr
					})
				} else if (val == 1002) {
					productmode.get_one_product('new').then(res => {
						let arr = []
						for (let k in res.data) {
							let v = res.data[k]
							arr.push(this.reCount(v))
						}
						this.productList = arr
					})
				} else if (val == 1003) {
					productmode.get_one_product('hot').then(res => {
						let arr = []
						for (let k in res.data) {
							let v = res.data[k]
							arr.push(this.reCount(v))
						}
						this.productList = arr
					})
				} else if (val == 1004) {
					productmode.get_reduction_product().then(res => {
						let arr = []
						for (let k in res.data) {
							let v = res.data[k]
							arr.push(this.reCount(v))
						}
						this.productList = arr
					})
				} else {
					productmode.get_product(val).then(res => {
						let arr = []
						for (let k in res.data) {
							let v = res.data[k]
							arr.push(this.reCount(v))
						}
						this.productList = arr
					})
				}
			},
			// 获取广告图片
			getBannerImgs() {
				const _this = this;
				bannerModel.get_banner(2).then(res => {
					_this.ads1 = res.data.items;
					// _this.ads2 = res.data.items;
				})
			},
			// 更换地址
			replaceAddress() {
				uni.navigateTo({
					url: '../addresses/addresses?type=order',
				})
			},
			jumpTableList() {
				uni.navigateTo({
					url: '../table_list/table_list'
				})
			},
			// 获取公告
			getNoticeAll() {
				const _this = this;
				noticeModel.getNoticeAll().then(res => {
					_this.notices = res.data;
				})
			},
			// 点击公告跳转
			jump_notice(id) {
				uni.navigateTo({
					url: '../article/article?id=' + id
				})
			},
			show_xia() {
				// #ifdef H5
				if (this.xia) {
					this.xia = false;
				} else {
					this.xia = true;
				}
				// #endif
			}

		},
		onShareAppMessage() {
			let sfm = uni.getStorageSync('sfm')
			return {
				title: '如花外卖商城',
				path: '/pages/index/index?sfm='+sfm
			}
		}
	}
</script>

<style lang="scss">
	@import './index.scss';
	uni-page-head{
		display: none;
	}
</style>
