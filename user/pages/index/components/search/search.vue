<template>
	<uni-transition :mode-class="['slide-left']" :styles="tranStyles" :show="show">
		<view class="d-flex flex-column overflow-hidden">
			<view class="search-box">
				<view class="search-input">
					<image src="/static/images/common/search-icon.png" class="search-icon"></image>
					<input type="text" v-model="keyword" placeholder="试试搜个 泰 字" placeholder-class="placeholder">
					<image v-if="keyword" src="/static/images/common/image-delete.png" class="close-icon" @tap="clear" />
					<text class="search-btn" @tap="handleKeywordInput">搜索</text>
				</view>
				<view class="ml-30" @tap="hide">取消</view>
			</view>
			<scroll-view class="result" scroll-y>
				<template v-if="!result.length">
					<view class="section">
						<view class="header">
							<view class="title">搜索热词</view>
							<view class="subtitle">
								<!-- <image src="/static/images/common/delete.png"></image>
								<view>清除</view> -->
							</view>
						</view>
						<view class="list">
							<view class="item" v-for="(item, index) in historySearch" :key="index" @tap="handleChoose(item.name)">
								{{ item }}
							</view>
						</view>
					</view>
					<!-- <view class="section">
						<view class="header">
							<view class="title">热门推荐</view>
						</view>
						<view class="list">
							<view class="item" v-for="(item, index) in hotSearch" :key="index" @tap="handleChoose(item)">
								<view class="name">{{ item.productName }}</view>
								<image v-if="item.nameImage" :src="item.nameImage" class="name-image"></image>
							</view>
						</view>
					</view> -->
				</template>
				<template v-else>
					<view class="wrapper">
						<view class="product" v-for="(item, index) in result" :key="index" @tap="handleChoose(item, true)">
							<view class="d-flex align-items-center">
								<image :src="getimg+item.img_id" class="pro-image" />
							</view>
							<view class="text">
								<view class="pro-name">{{ item.goods_name }}</view>
								<view class="pro-name">{{ item.description }}</view>
							</view>
							<view class="pro-price">￥{{ item.price }}</view>
						</view>
					</view>
				</template>
			</scroll-view>
		</view>
		</view>
	</uni-transition>
</template>

<script>
	import uniTransition from '@/components/uni-transition/uni-transition.vue'
	import search from '@/api/Search.js'
	export default {
		name: 'Search',
		components: {
			uniTransition
		},
		props: {
			show: {
				type: Boolean,
				default: false
			},
			categories: {
				type: Array,
				default: () => []
			},
			hotSearch: {
				type: Array,
				default: () => []
			}
		},
		data() {
			return {
				tranStyles: {
					width: '100%',
					position: 'absolute',
					top: 0,
					left: 0,
					bottom: 0,
					backgroundColor: '#fff',
					zIndex: 998
				},
				// hotSearch: [],
				historySearch: [],
				keyword: '',
				result: [],
				getimg: this.$getimg,
			}
		},
		async created() {

			// const _this = this;
			// this.hotSearch = await search.search_record('hotSearch')
			// this.getSearchWord();
		},
		methods: {
			hide() {
				this.keyword = ''
				this.result = []
				this.$emit('hide')
			},
			handleChoose(item, isSearch = false) {
				const _this = this;

				if (isSearch) {
					this.hide()
					item = this.reCount(item)
					this.$emit('choose', item)
					return
				}
				this.keyword = item;
				search.search(item).then(res => {
					if (res.status == 200 && res.data.length > 1) {
						res.data.forEach(item => {
							_this.result.push(item);
						})
					} else {
						uni.showToast({
							title: '暂无该商品',
							icon: 'none'
						})
					}
					this.getSearchWord();

				})

			},
			handleKeywordInput() {
				uni.showLoading()
				const _this = this;
				this.result = []
				search.search(this.keyword).then(res => {
					this.set_history(this.keyword)
					this.keyword = ''
					uni.hideLoading();
					setTimeout(() => {
						_this.result = res.data
					}, 500)
				})
			},
			set_history(item) {
				let arr = this.historySearch
				let array = []
				let his = uni.getStorageSync('historySearch')
				if (his) {
					this.historySearch = his
				}
				if (this.historySearch.length > 0) {
					for (let k in this.historySearch) {
						let v = this.historySearch[k]
						if (v.indexOf(item) === -1) {
							this.historySearch.push(item)
						}
						// uni.setStorageSync('historySearch', this.historySearch)
					}
					
					for (var i = 0; i < arr.length; i++) {
						if (array.indexOf(arr[i]) === -1) {
							array.push(arr[i])
						}
					}
					this.historySearch = arr
					uni.setStorageSync('historySearch', array)
				} else {
					this.historySearch.push(item)
					uni.setStorageSync('historySearch', this.historySearch)
				}
			},
			clear() {
				this.keyword = ''
				this.result = []
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
			// 获取热搜
			getSearchWord() {
				this.historySearch = uni.getStorageSync('historySearch')
				// search.search_record().then(res=>{
				// 	this.historySearch = res.data
				// })
			},
		}
	}
</script>

<style lang="scss" scoped>
	.search-box {
		height: 100rpx;
		padding: 20rpx 30rpx;
		display: flex;
		align-items: center;
		border-bottom: 1rpx solid rgba($color: $border-color, $alpha: 0.6);

		.search-input {
			flex: 1;
			height: 60rpx;
			padding: 10rpx 20rpx;
			background-color: #f7f7f7;
			font-size: $font-size-base;
			border-radius: 50rem !important;
			display: flex;
			align-items: center;

			.search-icon {
				width: 30rpx;
				height: 30rpx;
				margin-right: 10rpx;
			}

			input {
				flex: 1;
			}

			.close-icon {
				width: 30rpx;
				height: 30rpx;
				margin-left: 20rpx;
			}

			.search-btn {
				display: inline-block;
				margin-left: 10rpx;
				background-color: white;
				padding: 6rpx 15rpx;
				border-radius: 50rem !important;
				box-shadow: 0 0 10rpx #ddd;

				&:active {
					background-color: #eee;
				}
			}
		}
	}

	.section {
		padding: 30rpx;

		.header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 20rpx;

			.title {
				font-size: $font-size-medium;
				color: $text-color-base;
			}

			.subtitle {
				display: flex;
				align-items: center;
				font-size: $font-size-sm;
				color: $text-color-assist;

				image {
					width: 40rpx;
					height: 40rpx;
				}
			}
		}

		.list {
			display: flex;
			flex-wrap: wrap;

			.item {
				background-color: #f5f5f7;
				padding: 10rpx 20rpx;
				font-size: $font-size-sm;
				color: $text-color-grey;
				border-radius: 50rem !important;
				margin-right: 20rpx;
				margin-bottom: 20rpx;
				display: flex;
				align-items: center;
				justify-content: center;

				.name-image {
					width: 30rpx;
					height: 30rpx;
				}
			}
		}
	}

	.result {
		height: calc(100vh - 120rpx);
		/* #ifdef H5 */
		height: calc(100vh - 120rpx - 100rpx);
		/* #endif */
		overflow: hidden;

		.product {
			padding: 20rpx;
			display: flex;
			align-items: center;
			justify-content: space-between;
			font-size: $font-size-base;

			.pro-image {
				width: 144rpx;
				height: 108rpx;
				margin-right: 30rpx;
				flex-shrink: 0;
			}

			.text {
				width: 100%;
				max-width: 100%;
				overflow: hidden;
				height: 90rpx;
				display: flex;
				flex-direction: column;
				justify-content: space-between;

				.pro-name {
					width: 100%;
					overflow: hidden;
					white-space: nowrap;
					text-overflow: ellipsis;
				}
			}

			.pro-price {
				flex-shrink: 0;
				font-weight: 500 !important;
			}
		}

		.wrapper {
			padding: 0 30rpx 30rpx 0;
			padding-bottom: 100rpx;
		}
	}
</style>
