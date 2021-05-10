<template>
	<view class="evaluate">
		
		<None v-if="list_empty"></None>
		<view class="comment" v-for="(item, index) of comment_list" :key="index" v-else>
			<block v-if="currentTab == 0 ">
				<view class='con'>
					<view class='con_1'>
						<view class='con_1_l'>
							<img :src='item.headpic' />
							<view class='name'>{{item.nickname}}<span></span>
								<view class='con_1_r'>{{item.create_time}}</view>
							</view>
						</view>
						<view class='con_1_r'>
							<view class="ping">
								<tui-rate :current="item.rate" @change="changedd" active="#F37B1D" :disabled="true"></tui-rate>
							</view>
						</view>
					</view>
					<view class='con_2'>
						{{item.content}}
						<view class="img">
							<block v-for="(url,index) of item.imgs" :key="index" v-if="index<9">
								<img :src="getimg + url" @click="ViewImage(item.imgs, index)"></img>
							</block>
						</view>
					</view>

					<view class="reply" v-if="item.reply_content!=null">商家回复：</br>
						<view style="margin-left: 20px;padding: 10px;">
							{{item.reply_content}}
						</view>
					</view>

				</view>
			</block>
			
			<view class='H10'></view>
		</view>
		<!-- 弹框评论 -->
		<ygc-comment ref="ygcComment" :placeholder="'发布评论'" @pubComment="pubComment"></ygc-comment>
		<view class="fixed-btn">
			<button v-if="isHasOrder" type="primary" class="submit-pl" @tap="showComment">发布评论</button>
		</view>
	</view>
</template>

<script>
	import {
		Api_url
	} from '@/common/config'
	import None from "./components/none.vue"
	import tuiTabs from "./components/tui-tabs"
	import tuiRate from "./components/rate"
	import ygcComment from './components/ygc-comment.vue'
	import productModel from '@/api/product.js'
	import commentModel from '@/api/comment.js'
	import orderModel from '@/api/orders.js'
	export default {
		data() {
			return {
				getimg: this.$getimg,
				currentTab: 0,
				navbar: [{
					name: "全部"
				}, {
					name: "有图"
				}],
				shua: true,
				list_empty: false,
				comment_list: [],
				current: 5,
				index: 5,
				img: [],
				goods_id: -1,
				order_id: -1,
				isHasOrder: true,
			};
		},
		components: {
			tuiTabs,
			tuiRate,
			None,
			ygcComment
		},
		onLoad(options) {
			if(options.goods_id) {
				this.goods_id = options.goods_id;
			}
			if(options.order_id) {
				this.order_id = options.order_id;
			}
			if(options.goods_id && !options.order_id) {
				this.isHasOrder = false;
			}
		},
		mounted() {
			this.getCommentOne();
		},
		methods: {
			show_data() {
				this.getCommentOne();
			},
			change(e) {
				this.currentTab = e.index
			},
			changedd: function(e) {
				this.index = e.index;
				this.current = e.index
				console.log(e)
			},
			ViewImage(urls, index) {
				const getimg = this.getimg;
				let arr = [];
				for(let k in urls)
				{
					arr.push(getimg + urls[k]);
				}
				
				uni.previewImage({
					urls: arr,
					current: index
				});
			},
			// 显示评论
			showComment() {
				this.$refs.ygcComment.toggleMask('show');
			},
			// 评论事件
			pubComment(data) {
				this.$refs.ygcComment.toggleMask('hide');
				const _this = this;
				let obj = data;
				obj.id = this.order_id;
				obj.goods_id = this.goods_id;
				commentModel.setComment(obj).then(res => {
					if (res.status == 200) {
						uni.showToast({
							title: '评论成功'
						})
						_this.getCommentOne();
					} else {
						uni.showToast({
							title: '评论失败',
							icon: 'none'
						})
					}
				})
			},
			// 获取某个商品评论
			getCommentOne() {
				const _this = this;
				commentModel.getCommentOne(this.goods_id).then(res => {
					if(res.status == 200) {
						_this.list_empty = false;
						_this.comment_list = res.data;
					}
					else {
						_this.list_empty = true;
					}
				})
			}
		},
	}
</script>

<style lang="less">
	.evaluate {
		background-color: #f0f0f0;
		min-height: calc(100vh - var(--status-bar-height) - 90rpx);
		font-size: 14px;
		padding-bottom: 80rpx;

		.zhpf {
			background-color: #fff;
			display: flex;
			justify-content: space-between;
			padding: 10px;
		}

		.zhpf_l {
			display: flex;
		}

		.zhpj_l_01 {
			padding: 5px 10px 0 0;
		}

		.zhpf_r {
			color: #FFB91E;
			padding-top: 5px;
		}

		.H10 {
			height: 10px;
		}

		.btn {
			padding: 0 10px 10px;
			background-color: #fff;
			display: flex;
		}

		.btn_1 {
			padding-right: 10px;
		}

		.con {
			background-color: #fff;
			padding: 10px;
		}

		.con_1 {
			display: flex;
			justify-content: space-between;
		}

		.con_1_l {
			display: flex;
			line-height: 20px;
		}

		.con_1_l img {
			height: 40px;
			width: 40px;
			border-radius: 30px;
			margin-right: 10px;
		}

		.name {
			font-size: 16px;

			span {
				padding-left: 5px;
			}
		}

		.con_1_r {
			color: #B3B3B3;
			font-size: 12px;
		}

		.ping {
			padding-top: 5px;
		}

		.con_2 {
			padding: 5px 0px 10px 50px;

			.img {
				padding-top: 8px;

				img {
					width: 24vw;
					height: 19vw;
					border-radius: 5px;
					margin: 0 2vw 10px 0;
				}
			}
		}
		
		.fixed-btn {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 100rpx;
			background-color: white;
			padding: 20rpx 40rpx;
			.submit-pl {
				width: 100%;
				height: 100%;
			}
		}
	}
</style>
