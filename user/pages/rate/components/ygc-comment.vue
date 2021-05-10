<template>
	<view class="mask" :class="maskState===0 ? 'none' : maskState===1 ? 'show' : ''" @click="toggleMask">
		<view class="mask-content"  @click.stop.prevent="stopPrevent">
			<view class="mask-content-topbar">
				<view class="left" @click="toggleMask">取消</view>
				<view class="right" @click="pubComment">发布</view>
			</view>
			<view class="mask-content-topbar mask-content-topbar_flex_end">
				最多上传3张图片
			</view>
			<view class="mask-content-topbar">
				<tui-rate :current="rate" @change="changedd" active="#F37B1D" :disabled="false"></tui-rate>
				<image class="icon-img" src="../../../static/icon-img/uploadImg.png" mode="" @tap="chooseImg" v-if="images.length < 3"></image>
			</view>
			<view class="mask-content-input">
				<textarea class="textarea"
					v-model="content"
					:placeholder="placeholder"
					:cursor-spacing = "100"
					:show-confirm-bar = "false"
					:focus="focus"
					maxlength="140">
				</textarea>
			</view>
			<view class="mask-content-topbar mask-content-topbar_w100">
				<view class="imgs" v-for="(item,index) in images">
					<image class="img" :src="item" mode=""></image>
					<image class="icon-warn" src="@/static/icon-img/warn.png" mode="" @tap="removeImg(index)"></image>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import tuiRate from "../components/rate"
	
	export default {
		name: "ygcComment",
		//属性
		props: {
			placeholder: {
				type: String
			}
		},
		components: {
			tuiRate
		},
		data() {
			return {
				api: this.$getimg,
				maskState: 0,
				content: '',
				focus: false,
				rate: 5,
				images: [],
				img_id: [],
				// 最高能上传图片个数
				img_len: 3,
			};
		},
		created() {
		},
		methods: {
			stopPrevent(){
			},
			changedd: function(e) {
				this.rate = e.index;
			},
			chooseImg() {
				const _this = this;
				uni.chooseImage({
					count: 3,
				    success: (res) => {
						for(let k in res.tempFilePaths)
						{
							_this.images.push(res.tempFilePaths[k]);
						}
						if(_this.images.length > _this.img_len) {
							_this.images.splice(_this.img_len, _this.images.length - _this.img_len)
						}
				    }
				});
			},
			async uploadImg(index) {
				const _this = this;
				await uni.uploadFile({
					url: _this.api + 'img_category/upload/img',
					filePath: _this.images[index],
					name: 'img',
					formData: {
						cid: 0,
					},
					success(res) {
						let dat = JSON.parse(res.data)
						_this.img_id.push(dat.data.id);
					},
					fail(err) {
						console.log(err)
					}
				})
			},
			removeImg(index) {
				this.images.splice(index, 1);
			},
			toggleMask(type){
				let timer = type === 'show' ? 10 : 300;
				let	state = type === 'show' ? 1 : 0;
				// this.maskState = 2;
				setTimeout(()=>{
					this.maskState = state;
					// #ifdef APP-PLUS
					// 安卓app软键盘自动弹出有点问题，暂时还没有很好的解决方案，所以就禁止安卓app软键盘自动弹出，如果哪位朋友有好的解决方案可以在评论里告诉大家参考一下
					if (uni.getSystemInfoSync().platform == "ios") {
						this.focus = this.maskState ? true : false;
					}
					// #endif
					// #ifndef APP-PLUS
					this.focus = this.maskState ? true : false;
					// #endif
				}, timer)
			},
			async pubComment() {
				const _this = this;
				_this.img_id = [];
				// 上传图片
				for(let k in _this.images)
				{
					await this.uploadImg(k);
				}
				
				let dat = {
					content: _this.content,
					rate: _this.rate,
					imgs: _this.img_id,
				};
				setTimeout(() => {
					_this.$emit('pubComment', dat);
				}, 500)
				// wx.showLoading();
			}
		}
	}
</script>

<style lang="scss" scoped>
	$font-color-base: #606266;
	$base-color: #5A9BEC;
	.mask{
		display: flex;
		align-items: flex-end;
		position: fixed;
		left: 0;
		top: var(--window-top);
		bottom: 0;
		width: 100%;
		background: rgba(0,0,0,0);
		z-index: 9995;
		transition: .3s;
		-webkit-transition: .3s; 
		.mask-content{
			width: 100%;
			background: #FFFFFF;
			transform: translateY(100%);
			transition: .3s;//底部弹出的持续时间
			-webkit-transition: .3s;//底部弹出的持续时间 
			// overflow-y:scroll;
			display: flex;
			flex-direction: column;
			.mask-content-topbar{
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				padding: 20upx 30upx 10upx;
				font-size: 32upx;
				&_flex_end {
					justify-content: flex-end;
					color: #777;
				}
				&_w100 {
					justify-content: start;
					.imgs {
						width: 200rpx;
						height: 200rpx;
						position: relative;
						margin-right: 20rpx;
						.img {
							width: 100%;
							height: 100%;
							border-radius: 10rpx;
						}
						.icon-warn {
							position: absolute;
							top: -8rpx;
							left: -8rpx;
							width: 30rpx;
							height: 30rpx;
							background-color: white;
							border-radius: 50%;
						}
					}
				}
				.left{
					padding: 10upx 0upx;
					color: $font-color-base;
				}
				.right{
					padding: 10upx 100upx;
					border-radius: 6upx;
					color: #FFFFFF;
					font-weight: 500;
					background-color: $base-color;
				}
				.icon-img {
					width: 70rpx;
					height: 70rpx;
				}
			}
			.mask-content-input{
				width: 718upx;//如果textarea的宽带有问题可以把width改为100%试试
				// width: 100%;
				padding: 10upx 16upx 20upx;
				.textarea {
					height: 100px;
					width: 686upx;//如果textarea的宽带有问题可以把width改为100%试试
					// width: 100%;
					padding: 16upx;
					border:2upx solid #d5d5d6;
					border-radius: 8upx;
				}
			}
		}
		&.none{
			display: none;
		}
		&.show{
			background: rgba(0,0,0,.4);
			.mask-content{
				transform: translateY(0);
			}
		}
	}

</style>
