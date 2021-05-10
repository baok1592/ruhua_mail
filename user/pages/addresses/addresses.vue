<template>
	<view class="container">
		<view class="content">
			<list-cell v-for="(address, index) in addresses" :key="index" :line-left="false" @tap="choose(address)">
				<view class="address">
					<view class="info">
						<view class="user-row">
							{{ `${address.name} ${address.mobile}` }}
						</view>
						<view class="address-row">
							<view class="is-default" v-if="address.is_default">默认地址</view>
							<view class="address">{{address.province+address.city+address.detail}}</view>
						</view>
					</view>
					<image src="/static/images/common/edit.png" @tap.stop="edit(address.id)" class="edit-btn"></image>
					<image  src="/static/icon-img/delete.png" @tap.stop="deleteAddress(address.id)" class="del-btn"></image>
				</view>
			</list-cell>
		</view>
		<view class="footer">
			<button type="info" @tap="add">+添加地址</button>
		</view>
	</view>
</template>

<script>
	import listCell from '@/components/list-cell/list-cell.vue'
	import {mapState, mapMutations} from 'vuex'
	import addres from '../../api/address.js'
	
	export default {
		components: {
			listCell
		},
		data() {
			return {
				addresses:[],
				type: '',
			}
		},
		onLoad(option) {
			if(option.type) {
				this.type = option.type;
			}
		},
		onShow() {
			addres.get_all_address().then(res=>{
				this.addresses = res.data
			})
		},
		computed: {
		},
		methods: {
			...mapMutations(['SET_ADDRESS', 'SET_ORDER_TYPE']),
			show_data() {
				addres.get_all_address().then(res=>{
					this.addresses = res.data
				})
			},
			add() {
				uni.navigateTo({
					url: '/pages/addresses/add'
				})
			},
			edit(id) {
				uni.navigateTo({
					url: '/pages/addresses/add?id=' + id
				})
			},
			deleteAddress(id) {
				const _this = this;
				uni.showModal({
					title: '提示',
					content: '是否删除该地址',
					success(res) {
						if(res.confirm) {
							addres.deleteAddress(id).then(res => {
								if(res.status == 200) {
									addres.get_all_address().then(res=>{
										_this.addresses = res.data
									})
								}
							})
						}
					}
				})
				
			},
			choose(address) {
				// type 中的值表示是否从点餐页面过来
				if(this.type == 'order') {
					this.SET_ADDRESS(address)
					this.SET_ORDER_TYPE('takeout')
					addres.setDefaultAddress(address.id).then(res => {
						if(res.status == 200) {
							uni.switchTab({
								url: '/pages/index/index'
							})
						}
					})
					setTimeout(() => {
					}, 2000)
				}
			}
		}
	}
</script>

<style lang="scss" scoped>
	.content {
		height: auto;
		margin-top: 20rpx;
		padding-bottom: 170rpx;
	}
	
	.address {
		width: 100%;
		display: flex;
		align-items: center;
		
		.info {
			flex: 1;
			display: flex;
			flex-direction: column;
			margin-right: 20rpx;
			overflow: hidden;
			
			.user-row {
				font-size: $font-size-lg;
				font-weight: 500;
				margin-bottom: 10rpx;
			}
			
			.address-row {
				display: flex;
				align-items: center;
				
				.is-default {
					background-color: #faf5ef;
					font-size: 16rpx;
					color: $color-primary;
					padding: 4rpx;
					flex-shrink: 0;
					margin-right: 6rpx;
				}
				
				.address {
					font-size: $font-size-base;
					overflow: hidden;
					white-space: nowrap;
					text-overflow: ellipsis;
				}
			}
		}
		
		.edit-btn {
			width: 45rpx;
			height: 45rpx;
		}
		
		.del-btn {
			width: 70rpx;
			height: 50rpx;
		}
	}
	
	.footer {
		position: fixed;
		bottom: 0;
		width: 100%;
		z-index: 10;
		background-color: $bg-color;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 150rpx;
		padding: 0 30rpx;
		
		button {
			width: 100%;
			font-size: $font-size-extra-lg;
		}
	}
</style>
