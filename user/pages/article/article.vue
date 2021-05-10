<template>
	<view class="article">
		<view class="content" v-html="content"></view>
	</view>
</template>

<script>
	import articleModel from '../../api/article.js'
	
	export default {
		data() {
			return {
				content: '',
			};
		},
		onLoad(option) {
			const _this = this;
			if(option.id) {
				articleModel.getArticleOne(option.id).then(res => {
					_this.content = res.data.content;
					_this.content = _this.content.replace(/<img /g, '<img style="width: 100%; max-width: 100%"');
				})
			}
		}
		
	}
</script>

<style lang="scss" scoped>
.article {
	padding: 10rpx;
	min-height: calc(100vh - 44px);
	display: flex;
	
	.content {
		width: 100%;
		padding: 20rpx;
		background-color: white;
	}
}
</style>
