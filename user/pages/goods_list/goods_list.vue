<template>
	<view class="goods-list">
		<!-- 订单中的商品 -->
		<view class="goods-panel" v-for="(item,index) in goods" :key="index">
			<view class="left">
				<image class="img" :src="getimg + item.pic" mode=""></image>
			</view>
			<view class="right">
				<view class="goods_name">{{item.goods_name}}</view>
				<button class="btn" type="primary" size="mini" @tap="jump(item.goods_id)">评论</button>
			</view>
		</view>
		<!-- 订单中的商品 end -->
	</view>
</template>

<script>
	import {
		Api_url
	} from '@/common/config'
	import orderModel from '@/api/orders.js'
	
	export default {
		data() {
			return {
				getimg: this.$getimg,
				order_id: -1,
				goods: [],
			}
		},
		onLoad(option) {
			if(option.order_id) {
				this.order_id = option.order_id;
				this.getOrderInfo();
			}
		},
		methods: {
			show_data() {
				this.getOrderInfo();
			},
			// 获取订单信息
			getOrderInfo() {
				const _this = this;
				orderModel.getOrderInfo(_this.order_id).then(res => {
					this.goods = res.data.order_goods;
				})
			},
			// 跳转评论页面
			jump(id) {
				uni.navigateTo({
					url: '../rate/rate?goods_id=' + id + '&order_id=' + this.order_id,
				})
			},
		}
	}
</script>

<style lang="scss" scoped>
.goods-list {
	width: 100%;
	padding: 20rpx;
	
	.goods-panel {
		width: 100%;
		display: flex;
		align-items: center;
		background-color: white;
		padding: 30rpx;
		overflow: hidden;
		margin-bottom: 30rpx;
		
		.left {
			flex-shrink: 0;
			margin-right: 40rpx;
			
			.img {
				width: 100rpx;
				height: 100rpx;
			}
		}
		
		.right {
			width: 100%;
			display: flex;
			flex-direction: column;
			
			.goods_name {
				width: 500upx;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
			}
			
			.btn {
				margin-top: 20rpx;
				width: 130rpx;
				align-self: flex-end;
			}
		}
	}
}
</style>
