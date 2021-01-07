<template>
	<view>
		<view class="head tab-right-active">

			<!-- <view class="tab-box" v-if="tabIndex>0">
				<view class="item left" :class="{'active':tabIndex == 1}" @click="tabIndex = 1">
					<view class="tit-box">
						<text>配送</text>
					</view>
				</view>
				<view class="item right" :class="{'active':tabIndex == 2}" @click="tabIndex=2">
					<view class="tit-box">
						<text>到店自取</text>
					</view>
				</view>
			</view> -->
			<view class="container head-bottom" :class="{'selectOne': tabIndex == 1,'selectTow':tabIndex == 2}">
				<view class="tab" v-if="type=='店内就餐'">

				</view>
				<view class="tab" v-else>
					<view class="t-top" @click="choose_address">
						<view class="t-top-box">
							<block v-if="!addressData">
								<text class="txt1">选择收货地址</text>
								<i style="text-align: right;" class="hxicon-right icon1"></i>
							</block>
							<block v-else>
								<view class="" style="">
									<view class="" style="font-weight: 800;">
										{{addressData.name}}&nbsp;{{addressData.mobile}}
									</view>

									<view class="" style="text-align: right;">
										<i class="hxicon-right"></i></br>
									</view>
								</view>
								<!-- <span style="font-weight: 800;max-width: 100px;">{{addressData.name}}&nbsp; -->
								<!-- {{addressData.mobile}} -->
								<!-- </span> -->

								{{addressData.province}}{{addressData.city}}{{addressData.detail}}
							</block>
						</view>
					</view>
					<view class="t-bb"></view>
					<!-- <view class="t-bottom">
						<view class="row1">
							<view class="left">
								<text>送达时间</text>
							</view>
							<view class="right">
								<text>未选择(必选)</text>
								<i style="text-align: right;" class="hxicon-right"></i>
							</view>
						</view>
						<view class="row2">
							<text>为减少接触，封闭管理时，请在地址中更新具体去餐点</text>
						</view>
					</view> -->
				</view>
			</view>
		</view>
		<view class="b-r m-t container p12">
			<view class="store">
				<view class="name ">
					<text v-if="storeData.store_name">{{storeData.store_name}}</text>
					<text v-if="storeData.community">({{storeData.community}})</text>
				</view>
				<view class="p-bb b-b"></view>
				<view class="goods-box">
					<block v-for="(goods,i) in carts" :key="i" v-if="carts">
						<view class="goods-item">
							<view class="left">
								<image :src="getimg+ goods.good.img_id" mode="aspectFit"></image>
							</view>
							<view class="right">
								<view class="row1">
									<view class="tit">
										<text class="zk" v-if="goods.good.oldprice && Number(goods.good.price) < Number(goods.good.oldprice)">折</text>
										<text>{{goods.good.name}}</text>

									</view>
									<view class="old-price" v-if="goods.good.oldprice">
										<text class="fh">￥</text><text class="lt">{{goods.good.oldprice}}</text>
									</view>
									<view class="price">
										<text class="fh">￥</text><text>{{goods.good.price}}</text>
									</view>
								</view>
								<view class="row2">
									<text>{{goods.good.descripe}}</text>
								</view>
								<view class="row3">
									x<text>{{goods.number}}</text>
								</view>
							</view>
						</view>
					</block>
				</view>
				<view class="p-bb b-b"></view>
				<view class="flex-rl peisong">
					<view class="right">
						<text>配送费</text>
					</view>
					<view class="left">
						<text class="fh">{{send_cost ? '￥' + send_cost : '免费'}}</text>
					</view>
				</view>
				<view class="p-bb b-b"></view>
				
				<view class="p-bb b-b"></view>
				<view class="flex-rl totalbox">
					<view class="left">
						<text>优惠规则</text>
						<i class="hxicon-question"></i>
					</view>
					<view class="right">
						<view class="total">
							<text class="txt">小计</text>
							<text class="fh">￥</text>
							<text class="num">{{totalPrice}}</text>
						</view>
					</view>
				</view>

			</view>
		</view>
		<!-- <view class="b-r m-t container p12">
			<view class="privacy">
				<view class="flex-rl row1 ">
					<view class="left">
						<i class=" hxicon-cardboardfill icon1"></i>
						<text class="txt">号码保护</text>
						<i class=" hxicon-question icon2"></i>
					</view>
					<view class="right">
						<switch :checked="ysStatus" @change="privacyStatusChange" color="#ffc107" />
					</view>
				</view>
				<view class="row2">
					对商家，骑手隐藏您的真实手机号，保护您的隐私
				</view>
				<view class="row3" v-if="ysStatus">
					为保障服务质量，开启号码保护的订单通话可能会被录音
				</view>
			</view>
		</view> -->
		<view class="b-r m-t container p12 other-box">
			<view class="flex-rl row">
				<view class="left">
					<text>备注</text>
				</view>
				<view class="right">
					<!-- <text v-if="remark">{{remark}}</text>
					<text v-if="!remark">点击可填写备注</text>
					<i class="hxicon-right"></i> -->
					<input style="text-align: right;" type="text" v-model="msg" />
				</view>
			</view>
		</view>
		<view class="body-end"></view>

		<view class="foot">
			<view class="left">
				<view class="price">
					<text class="fh">￥</text>
					<text class="txt">{{totalPrice}}</text>
				</view>
				<view class="discount" v-if="coupon_price">
					<text>已优惠￥{{coupon_price+reduce}}</text>
				</view>
			</view>
			<view class="right" @click="submit">
				<text>提交订单</text>
			</view>
		</view>
	</view>
</template>

<script>
	import orderModel from '@/api/orderDetail.js'
	import userModel from '@/api/user.js'
	import address from '../../api/address.js'
	import usercoupon from '@/api/user_coupon.js'
	import order from '@/api/orders.js'
	import product from '@/api/product.js'
	import systemModel from '@/api/system.js'
	
	export default {
		data() {
			return {
				msg: '',
				getimg: this.$getimg,
				scrollData: {},
				//购物车缓存 Storage 名称
				shoppingCartStorageName: 'cart',
				//门店信息
				storeData: {},
				//购物车
				shopcart: [],
				//头部选项卡 参数为 0不显示选项卡,1,2
				tabIndex: 1,
				//收获地址
				addressData: null,
				//手机隐私
				ysStatus: true,

				//优惠券
				couponData: [],

				//结算价
				totalPrice: 0,
				//已优惠价
				totalYhPrice: 0,
				//商品数量
				totalNumber: 0,
				totalOldPrice: 0,
				remark: "",
				carts: [],
				couponid: 0,
				coupon_price: 0,
				type: '',
				// 总价满足条件优惠的价格
				reduce: 0,
				// 规格
				sku: {},
				send_cost: 0,
			}
		},
		onShow() {
			if (this.check_login()) {
				this.get_default_address()
			} else {
				uni.reLaunch({
					url: '../user/login/login'
				})
			}

		},
		onLoad(option) {
			let that = this
			let totalPrice = 0
			let totalNumber = 0
			this.type = option.type
			if (option.sid) {
				that.carts = uni.getStorageSync(that.shoppingCartStorageName)
				that.shopcart = uni.getStorageSync('shopcart')
				that.shopcart = Array.from(that.shopcart)
				that.totalOldPrice = that.shopcart[0].cartPrice.toFixed(2)
				that.totalPrice = that.totalOldPrice
				that.totalNumber = that.shopcart[0].cartNum
				// console.log('shopcart', that.shopcart)
			}
			
		
			
			that.storeData = uni.getStorageSync('merchant')
			that.reduce_money()
			this.getSystemConfig();
		},
		onPageScroll(e) {
			this.scrollData = e;
		},
		methods: {
			check_login() {
				let token = uni.getStorageSync('token')
				if (token) {
					return true
				}
				return false
			},
			choose_address() {
				uni.navigateTo({
					url: '../user/address/address?type=choose'
				})
			},
			get_default_address() {
				address.get_default_address().then(res => {
					this.addressData = res.data
				})
			},
			privacyStatusChange(e) {
				this.ysStatus = e.target.value
			},
			getSystemConfig() {
				const _this = this;
				systemModel.getSystemConfig(6).then(res => {
					for(let k in res.data)
					{
						if(res.data[k].key == 'shipping_dees') {
							_this.send_cost = Number(res.data[k].value);
						}
					}
				})
			},
			//提交订单
			async submit() {
				let that = this
				let goodsID = []
				for (var i in that.carts) {
					goodsID.push(that.carts[i].id)
				}
				
				let data = {
					//商品id
					goods_id: goodsID,
					//使用的优惠券 id
					coupon_id: that.couponid,
					//手机隐私
					privacy_status: that.ysStatus ? 1 : 0,
					order_from: "0",
					payment_type: 'xcx',
					pay_cate: "1",
					json: that.computeSKU(),
					total_price: that.totalPrice,
					msg: that.msg,
					drive_type: '配送',
					coupon_price: that.coupon_price,
					table_num: uni.getStorageSync('table_num')||0,
				}
				// console.log(that.carts)
				// console.log(data)
				uni.showLoading({
					title: '正在生成订单'
				});
				// console.log('data', data)
				// 向后台发送 data 进行真实合计，生成订单，并返回订单信息
				order.order_create(data).then(res => {
					uni.hideLoading()
					if(res.status == 200) {
						let orderdata = res.data
						uni.redirectTo({
							url: '../pay/pay?id=' + orderdata.id
						})
					}
					else {
						uni.showToast({
							title: '提交订单失败',
							icon: 'none'
						})
					}
					
				})
			},
			radioChange: function(evt) {
				let arr = []
				this.couponData.forEach(function(v) {
					if (v.id == evt.detail.value)
						arr = v
				})
				this.couponid = arr.coupon_id
				this.coupon_price = Number(arr.reduce)
				this.totalPrice = this.totalOldPrice - this.coupon_price
				if(this.totalPrice < 0) {
					this.totalPrice = 0;
				}
			},
			reduce_money() {
				const _this = this;
				let data = {
					json: _this.computeSKU()
				};
				product.get_order_money(data).then(res => {
					this.totalOldPrice = res.data.total_money
					this.totalPrice = this.totalOldPrice
					this.reduce = Number(res.data.reduce)
				})
			},
			// 计算规格
			computeSKU() {
				let that = this;
				// sku
				let sku = {}
				let obj_product = {};
				for (let k in that.carts) {
					const v = that.carts[k];
					let sku_key = '';
					obj_product.goods_id = v.id;
					obj_product.sku_id = v.materials_sku_id || 0;
					obj_product.price = v.materials_price;
					obj_product.num = v.number;
					if(v.is_sku) {
						let json_sku = JSON.parse(v.sku[0].json);
						let tree = json_sku.tree;
						let sku_key_temp = '';
						for(let tree_k in tree)
						{
							for(let v_key in tree[tree_k].v)
							{
								if(tree[tree_k].v[v_key].select) {
									sku_key_temp += tree[tree_k].v[v_key].id + '-';
								}
							}
						}
						sku_key = sku_key_temp.slice(0, -1);
						sku_key_temp = '';
					}
					else {
						obj_product.price = v.price;
						obj_product.is_sku = 0;
					}
					sku[sku_key+'-'+k] = obj_product;
					sku_key = '';
					obj_product = {};
				}
				// sku end
				return sku;
			}
		},

	}
</script>

<style lang="scss">
	.b-r {
		border-radius: 6px;
	}

	.m-t {
		margin-top: 6px;
	}

	.p-bb {
		margin: 16px 0;
		height: 1px;
		//background:  #E4E7ED;
	}

	.flex-rl {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
	}

	.container {
		// margin-left: 12px;
		margin-right: 12px;
		background-color: #ffffff;
	}

	.p12 {
		padding: 12px;
	}

	.head {
		background: linear-gradient(to bottom, #ffc107, #f1f1f1);

		padding-top: 20px;

		.tab-box {
			position: relative;
			height: 40px;
			margin: 0 12px;

			.item {
				position: absolute;
				top: 0;
				bottom: 0;
				height: 40px;
				text-align: center;
				font-size: 14px;

				width: 50%;

				.tit-box {
					position: relative;
					height: 36px;
					line-height: 36px;
					border-top-left-radius: 6px;
					border-top-right-radius: 6px;
					background-color: rgba(#ffffff, .6);
					width: 100%;
				}
			}

			.item:first-child {
				display: flex;
				flex-direction: row;
				justify-content: flex-start;
				align-items: flex-end;
				left: 0;
			}

			.item:last-child {
				display: flex;
				flex-direction: row;
				justify-content: flex-end;
				align-items: flex-end;
				right: 0;
			}

			.active {
				height: 40px;
				width: 51%;
				font-weight: bold;

				.tit-box {
					height: 40px;
					line-height: 40px;
					background-color: rgba(#ffffff, 1);
				}

			}

			.left .tit-box {
				margin-left: 12px;
				margin-right: -12px;
				padding-right: 12px;
			}

			.right .tit-box {
				flex-shrink: 0;
				margin-right: 12px;
				margin-left: -12px;
				padding-left: 12px;
			}

			.left.active .tit-box {
				margin: 0;
			}

			.right.active .tit-box {
				margin: 0;
			}

			.left.active .tit-box:after {
				content: '';
				position: absolute;
				right: -12px;
				bottom: 0;
				border-top: 12px solid transparent;
				border-right: 12px solid transparent;
				border-bottom: 36px solid #ffffff;
			}

			.right.active .tit-box:after {
				content: '';
				position: absolute;
				left: -12px;
				bottom: 0;
				border-top: 12px solid transparent;
				border-left: 12px solid transparent;
				border-bottom: 36px solid #ffffff;
			}
		}

		.head-bottom {
			overflow: hidden;
			background: #ffffff;
			border-top-left-radius: 6px;
			border-top-right-radius: 6px;
			border-bottom-left-radius: 6px;
			border-bottom-right-radius: 6px;

			.tab {

				.t-top {

					&-box {
						margin: 0;
						padding: 12px;

						.txt1 {
							font-size: 18px;
							color: #888;
						}

						.icon1 {
							margin-left: 8px;
							color: #bbb;
						}
					}

					&-box:active {
						background-color: #f5f5f5;
					}
				}

				.t-bb {
					margin: 0 12px;
					height: 0.5px;
					background-color: #E4E7ED;
				}

				.t-bottom {
					padding: 12px;

					.row1 {
						display: flex;
						flex-direction: row;
						justify-content: space-between;

						//padding: 12px 0 0;
						.left {
							font-size: 14px;
							font-weight: bold;
						}

						.right {
							font-size: 14px;
							color: #ff9800;

							i {
								margin-left: 8px;
								color: #bbb;
							}
						}
					}

					.row2 {
						margin-top: 6px;
						font-size: 12px;
						color: #ff9800;
					}
				}
			}
		}

		.head-bottom.selectOne {
			border-top-left-radius: 0;
			border-top-right-radius: px;
		}

		.head-bottom.selectTow {
			border-top-left-radius: 6px;
			border-top-right-radius: 0;
		}
	}

	.store {
		display: flex;
		flex-direction: column;

		.name {
			padding: 4px 0 0px;
			font-size: 14px;
		}

		.goods-box {
			.goods-item {
				margin-top: 20px;
				display: flex;
				flex-direction: row;

				.left {
					width: 60px;
					height: 60px;

					image {
						border-radius: 4px;
						overflow: hidden;
						width: 100%;
						height: 100%;
						background-color: #f1f1f1;
					}
				}

				.right {
					display: flex;
					flex-direction: column;
					justify-content: space-between;
					flex: 1;
					padding-left: 14px;

					.row1 {
						display: flex;
						flex-direction: row;
						justify-content: space-between;

						.tit {
							font-size: 14px;
							color: #333333;
							font-weight: bold;
							flex: 1;
							flex-wrap: wrap;

							.zk {
								padding: 1px 3px;
								font-size: 10px;
								margin-right: 8px;
								border-radius: 4px;
								background-color: #F9221D;
								color: #ffffff;
							}
						}

						.old-price {
							padding-left: 12px;
							font-size: 14px;
							color: #888888;
							font-weight: bold;

							.lt {
								text-decoration: line-through;
							}

							.fh {
								font-size: 10px;
							}
						}

						.price {
							font-size: 16px;
							padding-left: 12px;
							color: #333333;
							font-weight: bold;

							.fh {
								font-size: 10px;
							}
						}
					}

					.row2 {}

					.row3 {
						font-size: 10px;
						color: #888888;
					}
				}
			}

			.goods-item:first-child {
				margin: 0;
			}
		}

		.peisong {
			.right {
				font-size: 14px;
				font-weight: bold;
			}

			.left {
				font-size: 16px;
				font-weight: bold;

				.fh {
					font-size: 10px;
				}
			}
		}

		.zhekou-box {
			.zhekou {
				display: flex;
				flex-direction: column;
				margin-top: 12px;

				.row1 {
					align-items: center;

					.left {
						display: flex;
						flex-direction: row;
						align-items: center;
						height: 20px;
						line-height: 20px;

						i {
							font-size: 16px;
							color: #ff5722;
						}

						.tit {
							font-weight: bold;
							margin-left: 6px;
							font-size: 14px;
							color: #333;
						}
					}

					.right {
						.tag1 {
							font-weight: bold;
							font-size: 14px;
							color: #ff5722;
						}
					}
				}

				.row2 {

					height: 20px;
					line-height: 20px;
					font-size: 12px;
					color: #888;
				}

			}

			.zhekou:first-child {
				margin: 0;
			}
		}

		.totalbox {
			align-items: flex-end;

			.left {
				display: flex;
				flex-direction: row;
				align-items: center;
				font-size: 14px;
				color: #888;

				[class*="hxicon-"] {
					color: #aaa;
					margin-left: 4px;
					font-size: 16px;
				}
			}

			.right {
				display: flex;
				flex-direction: row;
				align-items: flex-end;

				.yh {
					color: #ff5722;

					.txt {

						color: #000;
						font-size: 15px;
					}

					.fh {
						font-weight: bold;
						margin-left: 3px;
						font-size: 13px;
					}

					.num {
						font-weight: bold;
						font-size: 18px;
					}
				}

				.total {
					margin-left: 16px;
					color: #333;

					.txt {
						font-size: 15px;
					}

					.fh {
						margin-left: 3px;
						font-size: 12px;
						font-weight: bold;
					}

					.num {
						font-weight: 900;
						font-size: 22px;
					}
				}
			}
		}
	}

	.privacy {
		display: flex;
		flex-direction: column;

		.row1 {
			align-items: flex-end;

			.left {
				display: flex;
				flex-direction: row;
				align-items: center;

				.icon1 {
					color: #444;
					font-size: 24px;
				}

				.icon2 {
					color: #aaa;
					margin-left: 6px;
					font-size: 16px;
				}

				.txt {
					color: #333;
					margin-left: 6px;
					font-weight: bold;
					font-size: 14px;
				}
			}

			.right {}
		}

		.row2 {
			margin-top: 4px;
			color: #888;
			font-size: 12px;
		}

		.row3 {
			margin-top: 8px;
			font-size: 12px;
			color: #ff9800;
		}
	}

	.other-box {
		display: flex;
		flex-direction: column;

		.row {
			align-items: center;

			.left {
				font-size: 14px;
				color: #333;
				font-weight: bold;
				flex: 1;
			}

			.right {
				display: flex;
				flex-direction: column;
				justify-content: flex-end;
				align-items: center;
				// flex-wrap: wrap;
				width: 60%;
				font-size: 14px;
				display: flex;
				flex-direction: row;
				color: #aaa;

				[class*="hxicon-"] {
					position: relative;
					top: 2px;
					font-size: 14px;
				}
			}
		}
	}

	.body-end {
		height: 100px;
	}

	.foot {
		z-index: 11;
		position: fixed;
		display: flex;
		flex-direction: row;
		border-radius: 50px;
		overflow: hidden;
		bottom: 12px;
		left: 12px;
		right: 12px;
		height: 50px;

		.left {
			padding: 0 18px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			background-color: #222222;
			flex: 1;

			.price {
				display: flex;
				flex-direction: row;
				align-items: baseline;
				color: #fff;
				height: 25px;
				line-height: 25px;

				.fh {
					font-weight: bold;
					font-size: 12px;
				}

				.txt {

					font-size: 22px;
					font-weight: bold;
				}
			}

			.discount {
				margin-left: 2px;
				font-size: 10px;
				color: #bbb;
			}
		}

		.right {
			display: flex;
			align-items: center;
			color: #222;
			font-weight: bold;
			font-size: 16px;
			padding-left: 15px;
			padding-right: 15px;
			transition: all 0.3s;
			background: linear-gradient(45deg, #FFEB3B, #FFC107);
		}

		.right:active {
			background: linear-gradient(45deg, #e0ce31, #e4ad06);
		}
	}
</style>
