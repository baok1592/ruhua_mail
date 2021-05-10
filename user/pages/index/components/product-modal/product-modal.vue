<template>
	<modal :show="visible" custom padding="0" width="90%" radius="18rpx">
		<view class="header">
			<!-- <button style="font-size: 1px;" type="default" open-type="share">
				<image src="/static/images/index/menupopup_btn_share_normal.png"></image>
			</button> -->
			
			<image src="/static/images/index/round_close_btn.png" @tap="$emit('cancel')"></image>
		</view>
		<swiper :duration="1000" indicator-dots class="swiper" autoplay :interval="3000">
			<swiper-item v-for="(image, index) in bannerimgs" :key="index" class="swiper-item">
				<image :src="getimg+image" class="w-100 h-100"></image>
			</swiper-item>
		</swiper>
		<scroll-view scroll-y class="content">
			<view class="wrapper">
				<view class="title">{{productData.goods_name}}</view>
				<view class="mb-10">产品描述</view>
				<view class="mb-20">{{ productData.description}}</view>
				<view class="materials" v-if="productData.form" v-for="(item,ind) in materials.tree">
					<view class="group-name" v-if="productData.form">{{ item.k }}</view>
					<view class="values">
						<view class="value" :class="{selected: material.select}" v-for="(material, index) in item.v" :key="index" @tap="changeMaterialSelected(item.k_s, material.id)">
							{{ material.name }}
						</view>
					</view>
				</view>
			</view>
			<view>评价<span style="float: right;" @tap="rate(productData.goods_id)">查看全部</span></view>
			<view class="goods-xq">商品详情</view>
			<rich-text :nodes="productData.content"></rich-text>
		</scroll-view>
		<view class="bottom" :style="{height: !is_single ? '250rpx' : '200rpx'}">
			<view class="d-flex align-items-center">
				<view class="price-and-materials">
					<view class="price">￥{{ materials.price?materials.price:productData.price}}</view>
					<view class="materials" v-show="materials">{{materials.name}}</view>
				</view>
				<actions :number="productData.number" @add="add" @minus="minus"></actions>
			</view>
			<button type="primary" class="add-cart-btn" @tap="addToCart">加入购物车</button>
		</view>
	</modal>
</template>

<script>
	import Modal from '@/components/modal/modal.vue'
	import Actions from '../actions/actions.vue'
	import product from '@/api/product.js'

	export default {
		name: 'ProductModal',
		components: {
			Modal,
			Actions
		},
		props: {
			visible: {
				type: Boolean,
				default: false
			},
			product: {
				type: Object
			}
		},
		data() {
			return {
				getimg: this.$getimg,
				bannerimgs: [],
				is_single: true,
				materials: [],
				productData: {},
				sku_id: -1,
			}
		},
		watch: {
			product: function(val) {
				this.materials = []
				this.productData = val
				if (val.bannerimgs) {
					this.bannerimgs = val.bannerimgs.split(',');
				}
				if (val.sku && val.sku.length) {
					this.sku_id = val.sku[0].sku_id;
					this.materials = JSON.parse(val.sku[0].json);
					for(let k in this.materials.tree)
					{
						for(let key in this.materials.tree[k].v)
						{
							if(key == 0) {
								this.materials.tree[k].v[key].select = true;
							}
							else {
								this.materials.tree[k].v[key].select = false;
							}
						}
					}
					// this.materials.price = Number(this.materials.list[0].price);
					// this.materials.sku_id = 1;
					this.calcSpecification();
				}
				// console.log('val', val)
				// console.log(this.materials)
			},
			
		},
		methods: {
			share(){
				
			},
			changeMaterialSelected(ks_name, id) {
				// console.log(':::', ks_name, id)
				// ks_name 表示选择的规格名，id 表示选择规格下的哪一项
				let tree = this.materials.tree;
				for(let k in tree) {
					if(tree[k].k_s == ks_name) {
						for(let key in tree[k].v) {
							if(tree[k].v[key].id == id) {
								tree[k].v[key].select = true;
							}
							else {
								tree[k].v[key].select = false;
							}
						}
					}
				}
				this.materials.tree = [];
				for(let k in tree) {
					this.materials.tree.push(tree[k]);
				}
				this.calcSpecification();
				this.productData.number = 1
				// console.log(this.materials)
			},
			
			// 计算所选规格的价格和所属的 list 中的 id
			calcSpecification() {
				let json_sku = this.materials;
				let tree = json_sku.tree;
				let list = json_sku.list;
				let id_list = [];
				let materials_text = '';
				let materials_key = '';
				for(let tree_k in tree)
				{
					for(let v_key in tree[tree_k].v)
					{
						if(tree[tree_k].v[v_key].select) {
							materials_text += ' ' + tree[tree_k].v[v_key].name;
							materials_key += '-' + tree[tree_k].v[v_key].id;
							id_list.push(tree[tree_k].v[v_key].id);
						}
					}
				}
				let list_v = {};
				for(let k in list)
				{
					// 用来标识是否是该规格
					let flag = true;
					list_v = list[k];
					for(let i = 0; i < id_list.length; i++)
					{
						if(id_list[i] != list[k]['s' + (i + 1)]) {
							flag = false;
							break;
						}
					}
					if(flag) {
						break;
					}
					list_v = {};
				}
				if(list_v.id) {
					this.materials.price = Number(list_v.price);
					this.materials.sku_id = list_v.id;
					this.productData.materials_text = materials_text;
					this.productData.materials_key = materials_key;
				}
				id_list = [];
				materials_text = '';
				materials_key = '';
				list_v = {};
			},
			
			add() {
				this.productData.number += 1
				// 使用 $set 未解决数据不渲染问题
				// this.$set(this.productData, 'number', this.productData.number+1);
				this.$forceUpdate();
			},
			minus() {
				if (this.productData.number == 1) {
					return
				}
				this.productData.number -= 1
				this.$forceUpdate();
			},
			addToCart() {
				const product = {
					...this.productData,
					'materials_price': this.materials.price,
					'materials_sku_id': this.materials.sku_id,
				}
				product.price = this.materials.price ? this.materials.price : this.productData.price
				//---------
				if(product.sku && product.sku[0] && product.sku[0].json) {
					product.sku[0].json = JSON.stringify(this.materials);
				}
				//---------
				// console.log(product)
				this.$emit('add-to-cart', product)
			},
			//数据重组
			reCount(res) {
				console.log('reCount')
				let arr = []
				if (res.sku && res.sku[0] && res.sku[0].json.tree.length > 0) {
					this.is_sku = true
					res['form'] = res.sku[0].json.tree[0].v[0]
					for (let k in res.sku[0].json.list) {
						let v = res.sku[0].json.list[k]
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
				if (res.reduction) {
					if (res.sku && res.sku[0] && res.sku[0].json.tree.length > 0) {
						for (let k in arr) {
							let v = arr[k]
							if (v.price > res.reduction.full) {
								v.price = (v.price * 10000 - res.reduction.reduce * 10000) / 10000
							}
						}
					} else {
						if (res.price > res.reduction.full) {
							res.price = (res.price * 10000 - res.reduction.reduce * 10000) / 10000
						}

					}

				}
				res['number'] = 0
				res['id'] = res.goods_id
				res['name'] = res.goods_name

				return res
			},
			rate(id) {
				uni.navigateTo({
					url: '/pages/rate/rate?goods_id=' + id
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
	.header {
		padding: 20rpx 30rpx;
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		display: flex;
		justify-content: flex-end;
		z-index: 11;

		image {
			width: 60rpx;
			height: 60rpx;
			margin-left: 20rpx;
			&:first-child {
				margin-left: 0;
			}
		}
	}

	.swiper {
		height: 426rpx;
	}

	.content {
		// border: 2rpx solid red;
		display: flex;
		flex-direction: column;
		font-size: $font-size-sm;
		color: $text-color-assist;
		min-height: 1vh;
		padding: 30rpx 30rpx 10rpx;
		max-height: calc(100vh - 100rpx - 426rpx - 250rpx);
		overflow-y: scroll;

		.goods-xq {
			margin-bottom: 10rpx;
		}

		.wrapper {
			width: 100%;
			height: 100%;
			overflow: hidden;
			// padding: 30rpx 30rpx 20rpx;
		}

		.title {
			font-size: $font-size-extra-lg;
			color: $text-color-base;
			font-weight: bold;
			margin-bottom: 10rpx;
		}

		.labels {
			display: flex;
			font-size: 20rpx;
			margin-bottom: 10rpx;
			overflow: hidden;
			flex-wrap: wrap;

			.label {
				max-width: 40%;
				padding: 6rpx 10rpx;
				margin-right: 10rpx;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}
		}

		.materials {
			width: 80%;
			margin-bottom: 20rpx;
			margin-top: 10rpx;

			.group-name {
				padding: 10rpx 0;
			}

			.values {
				display: flex;
				flex-wrap: wrap;
				overflow: hidden;

				.value {
					background-color: #f5f5f7;
					color: $font-size-base;
					padding: 10rpx 20rpx;
					overflow: hidden;
					text-overflow: ellipsis;
					white-space: nowrap;
					margin-right: 20rpx;
					margin-bottom: 20rpx;
					border-radius: $border-radius-lg;

					&.selected {
						background-color: $color-primary;
						color: $bg-color-white;
					}
				}
			}
		}
	}

	.bottom {
		padding: 20rpx 40rpx;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		border-top: 1rpx solid rgba($color: $border-color, $alpha: 0.3);
		background-color: $bg-color-white;
		position: relative;
		z-index: 11;

		.price-and-materials {
			flex: 1;
			display: flex;
			flex-direction: column;
			overflow: hidden;
			margin-right: 10rpx;

			.price {
				color: $color-primary;
				font-size: $font-size-extra-lg;
				font-weight: bold;
			}

			.materials {
				font-size: $font-size-sm;
				color: $text-color-assist;
				display: -webkit-box;
				-webkit-box-orient: vertical;
				-webkit-line-clamp: 2;
				overflow: hidden;
			}
		}

		.add-cart-btn {
			margin-top: 20rpx;
			font-size: $font-size-lg;
			border-radius: $border-radius-base;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 90rpx;
		}
	}
</style>
