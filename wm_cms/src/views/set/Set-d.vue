<template>
	<div class="">
		<el-form ref="form" label-width="200px">

			<el-form-item v-for="(item,index) in list" :label="item.desc" style='width: 70%'>

				<template v-if="item.switch == 1">
					<el-switch v-model="item.switch" active-color="#13ce66" inactive-color="#ff4949"></el-switch>
				</template>
				<template v-else-if="item.key == 'drive_type'">
					<el-radio-group v-model="item.value">
						<el-radio label="0">配送</el-radio>
						<el-radio label="1">店内就餐</el-radio>
						<el-radio label="2">配送+店内</el-radio>
					</el-radio-group>
				</template>
				<template v-else>
					<el-input v-model="item.value"></el-input>
				</template>
			</el-form-item>
			<el-form-item style='width: 80%'>
				<el-button type="primary" @click="onSubmit">提交修改</el-button>

			</el-form-item>
		</el-form>
	</div>
</template>

<script>
	export default {
		name: 'Set-d',
		data() {
			return {
				
			}
		},
		props: ['list'],
		methods: {
			onSubmit() {
				this.$emit("submit", this.list)
			},
			//vue生命函数
			mounted() {
				this.post_config();
			}
		},
	}
</script>

<style lang="less">
	.el-form-item {
		margin-bottom: 12px !important;
	}
</style>
