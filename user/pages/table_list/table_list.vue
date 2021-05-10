<template>
	<view class="table-list">
		<template v-for="(item, index) in table_list">
			<view class="table">
				<text>{{item.zh_num}} 号餐桌</text>
				<button size="mini" @click="chooseTable(item.zh_num)">选择</button>
			</view>
		</template>
	</view>
</template>

<script>
	import tableModel from '@/api/table.js'
	
	export default {
		data() {
			return {
				table_list: [],
			};
		},
		onLoad() {
			this.getTableAll();
		},
		methods: {
			getTableAll() {
				const _this = this;
				tableModel.getTableAll().then(res => {
					if(res.status == 200) {
						_this.table_list = res.data;
					}
				})
			},
			chooseTable(id) {
				console.log(id)
				uni.setStorageSync('table_num', id);
				uni.navigateBack();
			}
		}
	}
</script>

<style lang="scss" scoped>
.table-list {
	
	.table {
		padding: 20rpx 30rpx;
		background-color: white;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20rpx;
		
		>button {
			background-color: $color-error;
			color: white;
		}
	}
}
</style>
