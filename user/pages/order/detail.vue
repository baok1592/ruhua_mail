<template>
	<view class="container">
		<view class="header">
		</view>
		<view class="content" v-if="Object.keys(order).length>0">
			<view class="order-box">
				<image src="/static/images/order/icon_making.png" class="status-icon" />
				<view class="text-color-primary font-size-lg font-weight-bold mb-10">
					<template v-if="order.order.state == 0">
						订单未完成
					</template>
					<template v-if="order.order.state == -1">
						订单退款中...
					</template>
					<template v-if="order.order.state == -2">
						订单退款已完成
					</template>
					<template v-if="order.order.state == 1">
						订单已完成
					</template>
				</view>
				<view class="" v-if="order.order.state == 1">
					<view class="text-color-assist font-size-sm">感谢您的支持，欢迎再次光临</view>
					<view class="text-color-assist font-size-sm mt-2">取餐码：{{order.order.yzcode}}</view>
				</view>

			</view>
			<view class="flex-fill" style="background-color: #FFFFFF !important;">
				<view class="order-info">
					<list-cell line-right bgcolor="#FFFFFF">
						<view class="">
							订单类型：{{order.order.drive_type}}<br />
						</view>
					</list-cell>
					<list-cell line-right bgcolor="#FFFFFF">

						<view class="w-100 d-flex align-items-center" v-if="order.order.drive_type == '配送'">

							<view class="flex-fill d-flex flex-column overflow-hidden">
								<view class="font-size-lg mb-10">{{ order.order.receiver_name }}</view>
								<view class="font-size-extra-sm text-color-assist text-truncate">{{ order.order.receiver_city+order.order.receiver_address }}</view>
							</view>
							<view class="d-flex align-items-center ml-20">
								<image src="/static/images/order/icon_phone.png" class="phone-icon" @tap="call(order.order.receiver_mobile)"></image>
							</view>
						</view>
						<view class="" v-if="order.order.drive_type == '店内就餐'">
							<span>桌号：{{order.order.table_num}}号桌</span>
						</view>

					</list-cell>

					<list-cell padding="0 40rpx" line-right bgcolor="#FFFFFF">
						<view class="w-100 d-flex flex-column">
							<view class="d-flex align-items-center mt-40" v-for="(item, index) in order.order_goods" :key="index">
								<view class="flex-fill d-flex flex-column">
									<view class="font-size-base mb-10">{{ item.goods_name }}</view>
									<image :src="getimg+item.pic" class="img"></image>
									<view class="font-size-extra-sm text-color-assist">
										<text v-if="item.sku_name">{{ item.sku_name }}</text>
									</view>
								</view>
								<view class="flex-shrink-0 font-weight-bold ml-40">x{{ item.number }}</view>
								<view class="flex-shrink-0 font-weight-bold ml-40">￥{{ item.price }}</view>
							</view>
							<view class="d-flex justify-content-between align-items-center mt-40 pb-30 border-dashed">
								<view>商品总价</view>
								<view>￥{{ order.order.goods_money}}</view>
							</view>
							<view class="d-flex justify-content-between align-items-center font-size-lg font-weight-bold mt-30 mb-40">
								<view>合计</view>
								<view>￥{{ order.order.order_money }}</view>
							</view>
						</view>
					</list-cell>
					<list-cell padding="30rpx 40rpx" last bgcolor="#FFFFFF" style="border-radius: 0 0 30rpx 30rpx;">
						<view class="w-100 d-flex flex-column font-size-extra-sm text-color-assist">
							<view class="mb-10">如需退款，请致电门店</view>
							<view class="mb-10">下单时间：{{ order.order.created_at }}</view>
							<view class="mb-10">订单编号：{{ order.order.order_num }}</view>
							<view class="mb-10">备注信息：{{ order.order.message }}</view>
						</view>
					</list-cell>
					<list-cell v-if="order.order.state == 0 && order.order.payment_state == 1" padding="30rpx 40rpx" last bgcolor="#FFFFFF" style="border-radius: 0 0 30rpx 30rpx;text-align: right;">
						<button type="default" size="mini" @click="prompt(2)">退款</button>
					</list-cell>
				</view>
			</view>
		</view>
		<aui-dialog ref="dialog" :title="auiDialog.title" :msg="auiDialog.msg" :btns="auiDialog.btns" :mask="auiDialog.mask"
		 :maskTapClose="auiDialog.maskTapClose" :items="auiDialog.items" :theme="auiDialog.theme" @callback="dialogCallback"></aui-dialog>
	</view>

</template>

<script>
	import listCell from '@/components/list-cell/list-cell.vue'
	import orderDetail from "@/api/orderDetail.js"
	import auiDialog from '@/components/aui-dialog/aui-dialog.vue';
	import {
		aui
	} from '../../components/aui-dialog/common/aui/js/aui.js';

	export default {
		components: {
			listCell,
			auiDialog
		},
		data() {
			return {
				tui_resson: '',
				order: {},
				getimg: this.$getimg,
				auiDialog: {
					title: '',
					msg: '',
					btns: [{
						name: '确定'
					}],
					mask: true,
					maskTapClose: true,
					items: [],
					theme: 1,
				}
			}
		},
		computed: {},
		async onLoad(options) {
			const _this = this;
			/* 获取订单详情 */
			await orderDetail.get_one_order(options.id).then(res => {
				_this.order = res.data
			})

		},
		methods: {
			prompt(theme) {
				var _this = this;
				_this.auiDialog.title = '提示';
				_this.auiDialog.msg = '';
				_this.auiDialog.items = [{
						label: '退款原因',
						type: '',
						placeholder: '请输入退款原因'
					},
				];
				_this.auiDialog.btns = [{
						name: '取消'
					},
					{
						name: '确定'
					}
				];
				_this.auiDialog.theme = theme;
				_this.$refs.dialog.show();
			},
			dialogCallback(e) {
				var _this = this;
				//console.log(e);             
				if (_this.$refs.dialog.getVal().length > 0) { //prompt输入框——点击确定时弹出输入内容
				console.log('提交退款申请',)
					let resson = _this.$refs.dialog.getVal()[0].value
					_this.$api.post('order/user/tui_kuan',{
						order_id:_this.order.order.order_id,
						radio:resson,
					}).then(res=>{
						uni.showToast({
							icon:'success',
							title:'提交成功'
						})
						setTimeout(()=>{
							uni.navigateBack({
								
							})
						},2000)
					})
				}
			},
			apply_tui() {

			},
			// 拨打电话
			call(number) {
				uni.makePhoneCall({
					phoneNumber: number
				})
			},

		}
	}
</script>

<style lang="scss" scoped>
	.container {
		height: calc(100vh - 44px);
		background-color: #EAEAEA;
		padding: 0 40rpx;
		// display: flex;
		// flex-direction: column;
		overflow: auto;
	}

	.header {
		display: flex;
		justify-content: flex-end;
		align-items: center;
		padding: 20rpx 0;

		.service-btn {
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 50rem !important;
			font-size: $font-size-sm;

			image {
				width: 30rpx;
				height: 30rpx;
				margin-right: 20rpx;
			}
		}
	}

	.content {
		flex: 1;
		display: flex;
		flex-direction: column;
		overflow: hidden;

		.order-box {
			z-index: 10;
			height: 25vh;
			border-radius: 30rpx 30rpx 0 0;
			box-shadow: 0 0 2px 0 rgba($color: #333, $alpha: 0.1);
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			background-color: $bg-color-white;
			flex-shrink: 0;

			.status-icon {
				width: 100rpx;
				height: 100rpx;
				margin-bottom: 30rpx;
			}
		}
	}

	.phone-icon,
	.map-icon {
		width: 64rpx;
		height: 64rpx;
	}

	.phone-icon {
		margin-right: 40rpx;
	}

	.border-dashed {
		border-bottom: 1rpx dashed $border-color;
	}

	.order-info {
		border-radius: 0 0 30rpx 30rpx;
		box-shadow: 0 0 10rpx 0 rgba($color: #333, $alpha: 0.1);
		margin-bottom: 30rpx;
	}

	.order-invoice {
		padding: 30rpx 40rpx;
		border-radius: 30rpx;
		box-shadow: 0 0 10rpx 0 rgba($color: #333, $alpha: 0.1);
		margin-bottom: 60rpx;
		background-color: #F6F6F6;
	}

	.img {
		width: 100rpx;
		height: 80rpx;
	}

	.jump-icon {
		width: 24rpx;
		height: 48rpx;
		margin-left: 20rpx;
	}

	.mt-2 {
		margin-top: 20rpx;
	}
</style>
