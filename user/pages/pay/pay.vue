<template>
	<view class="pay">

		<view class="head">
			<view class="row">
				<text v-if="countdownStr">支付剩余时间 {{countdownStr}}</text>
				<text v-else>重新提交订单</text>
			</view>
			<view class="row pricebox pt-8">
				<text class="fh">￥</text>
				<text class="txt1">{{orderInfo.order_money}}</text>
			</view>
			<view class="row pt-4" @click="doOrder">
				<text>{{orderInfo.store_name}}</text>
				<text v-if="orderInfo.store_community">（{{orderInfo.store_community}}）</text>
				<text>订单详情</text>
				<i class="hxicon-right"></i>
			</view>
		</view>
		<view class="container">
			<radio-group @change="payChange" class="list-box">
				<block v-for="(item,i) in payData" :key="i">
					<view class="flex-rl list-item">
						<view class="left">
							<view class="iconbox">
								<image class="icon-img" src="../../static/icon-img/weixin.png" mode=""></image>
							</view>

						</view>
						<view class="b-b right">
							<view class="tit-box">
								<text class="tit">{{item.name}}</text>
							</view>
							<radio :value="item.id" color="#ffc107" :checked="item.default == 1" />
						</view>
					</view>
				</block>
			</radio-group>
		</view>
		<view class="btn" @click="submitPay">
			<text>确认支付</text>
		</view>
	</view>
</template>

<script>
	import orderModel from '../../api/orderDetail.js'
	import order from '@/api/orders.js'
	export default {
		onLoad(option) {
			if (option.id) {
				this.orderID = option.id
			}
			this.show_data();
		},
		data() {
			return {
				orderID: 0,
				pay_cate: '',
				countdownStr: "00:00",
				//订单信息
				orderInfo: {},
				//默认支付方式
				payType: 1,
				// 支付方式
				payData: [{
						id: "wxpay",
						name: "微信支付",
						icon: "hxicon-weixinzhifu",
						icon_color: "#09bb07",
						default: 1,
					},
					
				],
			}
		},
		methods: {
			show_data() {
				const that = this;
				if (this.orderID) {
					orderModel.get_one_order(this.orderID).then(res => {
						that.orderInfo = res.data.order
						this.orderInfo['expiration_date'] = res.data.order.updated_at
						that.countdown();
					})
				}
			},
			payChange(event) {
				console.log(event)
				let type = event.target.value

				this.payType = type == 'wxpay' ? 1 : 2
			},
			doOrder() {
				//查看订单
				uni.showModal({
					content: '这是查看订单的事件',
					showCancel: false,
					confirmColor: "#999",
					success: function(res) {

					}
				});
			},

			//倒计时
			countdown() {
				var go_time = new Date((this.orderInfo.expiration_date).replace(/-/g, '/'));
				var now_time = new Date();
				if (!go_time.getTime()) {
					return
				}
				var alltime = go_time.getTime() + 60 * 30 * 1000 - now_time.getTime(); //剩余的时间（毫秒）
				if (alltime <= 0) {
					this.countdownStr = ""
					this.showPrompt()
					return
				}
				var haoscend = alltime % 1000; //毫秒
				//console.log(haoscend);
				var scend = parseInt((alltime / 1000) % 60)
				//console.log(scend);
				var minute = parseInt((alltime / 1000 / 60) % 60)
				// console.log(minute);
				var hour = parseInt((alltime / 1000 / 60 / 60) % 24)
				if (scend < 10) {
					scend = "0" + scend
				}
				if (minute < 10) {
					minute = "0" + minute
				}
				let str = minute + ":" + scend;
				if (hour > 0) {
					str = hour + ':' + str
				}
				this.countdownStr = str
				setTimeout(this.countdown, 1000);
			},
			//显示弹窗
			showPrompt() {
				uni.showModal({
					content: '支付超时，请重新下单',
					showCancel: false,
					confirmText: "重新下单",
					confirmColor: "#999",
					success: function(res) {
						if (res.confirm) {
							uni.switchTab({
								url: '../index/index'
							})
						}
					}
				});
			},
			//确认支付
			submitPay() {
				if (this.countdownStr == '') {
					this.showPrompt()
					return
				}
				let pay_data = {
					pay_cate: this.payType,
					id: this.orderID
				}
				// #ifdef MP-WEIXIN
				order.order_pay(pay_data).then(res => {
					if (res.status != 200) {
						uni.showToast({
							title: '支付失败',
							icon: 'none'
						})
						setTimeout(() => {
							uni.switchTab({
								url: '../order/order'
							})
						}, 1000)
						// return ;
					}
					this.wx_pay(res.data)
				})
				// #endif
				
				// #ifdef H5
				order.H5_order_pay(pay_data).then(res => {
					if (res.status != 200) {
						uni.showToast({
							title: '支付失败',
							icon: 'none'
						})
						setTimeout(() => {
							uni.switchTab({
								url: '../order/order'
							})
						}, 1000)
						// return ;
					}
					this.wxPay(res.data)
				})
				// #endif


				// #ifdef APP-PLUS

				uni.requestPayment({
					provider: this.payType,
					orderInfo: 'orderInfo', //微信、支付宝订单数据
					success: function(res) {
						console.log('success:' + JSON.stringify(res));
					},
					fail: function(err) {
						console.log('fail:' + JSON.stringify(err));
					}
				});
				//#endif

				// #ifdef MP-WEIXIN
				//微信小程序
				// uni.requestPayment({
				// 	provider: 'wxpay',
				// 	timeStamp: String(Date.now()),
				// 	nonceStr: 'A1B2C3D4E5',
				// 	package: 'prepay_id=wx20180101abcdefg',
				// 	signType: 'MD5',
				// 	paySign: '',
				// 	success: function(res) {
				// 		console.log('success:' + JSON.stringify(res));
				// 	},
				// 	fail: function(err) {
				// 		console.log('fail:' + JSON.stringify(err));
				// 	}
				// });
				// #endif

			},
			//公众号支付
			wxPay(json) {
				if (typeof WeixinJSBridge == "undefined") {
					if (document.addEventListener) {
						document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);
					} else if (document.attachEvent) {
						document.attachEvent("WeixinJSBridgeReady", jsApiCall);
						document.attachEvent("onWeixinJSBridgeReady", jsApiCall);
					}
				} else {
					this.jsApiCall(json);
				}
			},
			jsApiCall(json) {
				const that = this;
				WeixinJSBridge.invoke("getBrandWCPayRequest", json, function(res) {
					WeixinJSBridge.log('a:', res.err_msg);
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						console.log("支付成功")
					} else if (res.err_msg == "get_brand_wcpay_request:cancel") {
						console.log("取消支付")
					} else {
						console.log("支付失败")
					}
					if (this.is_kai == 1) {
						uni.navigateTo({
							url: '../invite/invite?id=' + that.pid
						})
						return
					}
					setTimeout(() => {
						uni.redirectTo({
							url: '../order/order'
						});
					}, 1000);
				});
			},
			wx_pay(data) {
				const that = this
				// console.log('wx:', data)
				uni.requestPayment({
					provider: 'wxpay',
					timeStamp: data.timeStamp,
					nonceStr: data.nonceStr,
					package: data.package,
					signType: data.signType,
					paySign: data.paySign,
					success: function(res) {
						console.log('success:' + JSON.stringify(res));
						uni.switchTab({
							url: "../order/order"
						})
					},
					fail: function(err) {
						uni.showToast({
							title: '支付失败',
							icon: 'none'
						})
						// console.log('fail:' + JSON.stringify(err));
						// uni.navigateTo({
						// 	url:'./detail?id='+that.orderID
						// })
						// uni.navigateBack();
						setTimeout(() => {
							uni.switchTab({
								url: '../order/order'
							})
						}, 1000)
					}
				});
			},
		}
	}
</script>

<style lang="scss">
	page {
		background-color: #f1f1f1;
	}

	.pay {
		.pt-8 {
			margin-top: 8px;
		}

		.pt-4 {
			margin-top: 4px;
		}

		.flex-rl {
			display: flex;
			flex-direction: row;
			justify-content: space-between;
		}

		.pay-back {
			width: 100%;
			text-align: center;
			max-height: 44px;
		}

		.pay-tit {
			margin: 0 auto;
			font-size: 16px;
		}

		.head {
			display: flex;
			flex-direction: column;
			justify-content: center;
			padding: 30px 15px;

			.row {
				display: flex;
				flex-direction: row;
				justify-content: center;
				font-size: 12px;
				color: #888;

				.fh {
					font-size: 16px;
					font-weight: bold;
					color: #000;
				}

				.txt1 {
					font-size: 34px;
					font-weight: bold;
					color: #000;
				}

				[class*="hxicon-"] {
					position: relative;
					top: 3px;
					margin-left: 3px;
				}
			}

			.pricebox {
				display: flex;
				flex-direction: row;
				align-items: baseline;
			}

		}

		.container {
			// margin: 15px;
			width: 95%;
			border-radius: 10px;
			background-color: #fff;
			overflow: hidden;
			padding: 0 8px 0 14px;
			margin: 0 auto;

			.list-box {
				display: flex;
				flex-direction: column;

				.list-item {
					display: flex;
					flex-direction: row;

					align-items: center;
					height: 50px;


					.left {
						display: flex;
						flex-direction: row;
						align-items: center;

						.iconbox {
							display: flex;
							flex-direction: row;
							justify-content: center;
							align-items: center;
							height: 24px;
							width: 24px;
							border-radius: 4px;

							[class*="hxicon-"] {
								font-size: 22px;
								color: #fff;
							}

							.icon-img {
								width: 45rpx;
								height: 45rpx;
							}

						}


					}

					.right {
						display: flex;
						flex-direction: row;
						align-items: center;
						flex: 1;
						height: 100%;

						.tit-box {
							flex: 1;

							.tit {
								font-size: 16px;
								color: #333;
								margin-left: 6px;
							}
						}

					}
				}
			}
		}

		.btn {
			position: fixed;
			display: flex;
			flex-direction: row;
			justify-content: center;
			align-items: center;
			border-radius: 10px;
			overflow: hidden;
			bottom: 15px;
			left: 15px;
			right: 15px;
			height: 45px;
			font-size: 16px;
			font-weight: bold;
			color: #333;
			background: linear-gradient(45deg, #ffd900, #ffc107);
		}
	}
</style>
