<template>
	<view>
		<uni-transition :mode-class="['slide-bottom']" :show="!!cartNum" :styles="cartBarStyles">
			<view class="left">
				<view class="detail-action" @tap="details">
					<image src="/static/images/index/icon_shopping_bag.png" class="shopbag-btn"></image>
					<view class="badge">{{ cartNum }}</view>
				</view>
				<view class="price">￥{{ cartPrice }}</view>
			</view>
			<button type="primary" class="right" @tap="pay">结算</button>
		</uni-transition>
		<cart-popup :cart="cart" :type="type" ref="cartPopup" @add="add" @minus="minus" @clear="clear" @change="cartPopupChange"></cart-popup>
	</view>
</template>

<script>
	import uniTransition from '@/components/uni-transition/uni-transition.vue'
	import cartPopup from '../cart-popup/cart-popup.vue'
	import tokenModel from '@/api/token.js'

	export default {
		name: 'CartBar',
		components: {
			uniTransition,
			cartPopup
		},
		props: {
			cart: {
				type: Array,
				default: () => []
			},
			type: {
				type: String,
			}
		},
		computed: {
			cartNum() { //计算购物车总数
				return this.cart.reduce((acc, cur) => acc + cur.number, 0)
			},
			cartPrice() { //计算购物车总价
				//this.cart['to_money']=this.cart.reduce((acc, cur) => acc + cur.number * cur.price, 0)
				let price = this.cart.reduce((acc, cur) => acc + cur.number * cur.price, 0)
				return price.toFixed(2)*1
			}
		},
		data() {
			return {
				cartBarStyles: {
					'position': 'fixed',
					'bottom': 0,
					// #ifdef H5
					'bottom': 'var(--window-bottom)',
					// #endif
					'width': '100%',
					'z-index': '995',
					'height': '100rpx',
					'background-color': '#f0f0f1',
					'border-bottom': '2rpx solid #c8c7cc',
					'display': 'flex',
					'justify-content': 'space-between',
					'align-items': 'stretch',
				},
				shopcart: [],
				// 保存 cartPopup 开关状态
				isOpen: false,
			}
		},
		methods: {
			details() {
				if(!this.isOpen) {
					this.$refs['cartPopup'].open()
					this.isOpen = true;
				}
				else {
					this.$refs['cartPopup'].close()
					this.isOpen = false;
				}
			},
			add(product) {
				this.$emit('add', {
					...product,
					number: 1
				})
			},
			minus(product) {
				this.$emit('minus', product)
			},
			clear() {
				this.$emit('clear')
			},
			cartPopupChange (val) {
				if(!val) {
					this.isOpen = false;
				}
			},
			async verifyToken() {
				let flag = true;
				let token  = uni.getStorageSync('token')
				return tokenModel.verifyToken(token).then(async res => {
					if(res.status == 200) {
						return true;
					}
					else {
						return false;
					}
				})
			},
			async pay() {
				let flag = await this.verifyToken();
				if(!flag) {
					uni.showToast({
						title: '请登录',
						icon: 'none'
					})
					setTimeout(() => {
						uni.reLaunch({
							url: '/pages/my/my'
						})
					}, 1000)
					return;
				}
				let arr = []
				for (var i in this.cart) {
					arr.push({
						good: this.cart[i]['good']
					})
				}
				this.shopcart.push({
					cartNum: this.cartNum,
					cartPrice: this.cartPrice,
					goods: arr
				})
				// if(uni.getStorageSync('shopcart')) {
				// 	uni.removeStorageSync('shopcart');
				// }
				
				uni.setStorageSync('shopcart', this.shopcart)
				this.$emit('pay')
			}
		},
		watch: {
			cartNum(val) {
				if (!val) {
					this.$refs['cartPopup'].close()
				}
			}
		}
	};
</script>

<style lang="scss" scoped>
	.left {
		display: flex;
		align-items: center;

		.detail-action {
			height: 100%;
			border-radius: 100%;
			background-color: #ffffff;
			box-shadow: 0 10rpx 10rpx 0 rgba($color: $border-color, $alpha: 0.2);
			position: relative;
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100rpx;
			height: 100rpx;
			margin-top: -20rpx;
			margin-right: 20rpx;
			margin-left: 20rpx;

			.shopbag-btn {
				width: 70rpx;
				height: 70rpx;
			}

			.badge {
				background-color: $color-primary;
				font-size: $font-size-sm;
				color: $bg-color-white;
				line-height: 1rem;
				width: 1rem;
				text-align: center;
				border-radius: 100%;
				position: absolute;
				right: 0;
				top: 0;
			}
		}

		.price {
			font-size: $font-size-extra-lg;
			font-weight: bold;
			color: $text-color-base;
		}
	}

	.right {
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 0 70rpx;
		border-radius: 0 !important;
		font-size: $font-size-extra-lg;
	}
</style>
