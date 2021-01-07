<template>
	<div>
		<el-row>
			<transition appear appear-active-class="animated fadeInLeft">
				<div class="set">
					<el-tabs v-model="activeName" @tab-click="get_tab_name">
						<el-tab-pane label="基础设置" name="1">
							<set-a :datas="abc"></set-a>
						</el-tab-pane>

						<el-tab-pane label="微信" name="2">
							<set-d :list="list" :type="type" @submit="onSubmit"></set-d>
						</el-tab-pane>

						<el-tab-pane label="飞鹅打印机" name="3">
							<set-d :list="list" :type="type" @submit="onSubmit"></set-d>
						</el-tab-pane>
						<el-tab-pane label="短信" name="4">
							<set-d :list="list" :type="type" @submit="onSubmit"></set-d>
						</el-tab-pane>

						<el-tab-pane label="其他" name="5">
							<set-d :list="list" :type="type" @submit="onSubmit"></set-d>
						</el-tab-pane>

						<el-tab-pane label="商家信息" name="6">
							<set-d :list="list" :type="type" @submit="onSubmit"></set-d>
						</el-tab-pane>
					</el-tabs>
				</div>
			</transition>
		</el-row>

	</div>

</template>

<script>
	import SetA from './Set-a.vue'
	import SetD from './Set-d.vue'
	export default {
		name: 'Set',
		data() {
			return {
				activeName: '1',
				abc: [],
				auth: false,
				list: [],
				type: ''
			}
		},
		components: {
			SetA,
			SetD,
		},
		methods: {
			get_tab_name(e) {
				console.log(e)
				this.type = e.name
				if (e.name != '1') {
					this.post_config(e.name)
				}

			},
			check_auth(name) {
				const auth = localStorage.getItem("oauth");
				if (auth.indexOf(name) < 0) {
					this.$message({
						message: '无权限',
						type: 'none'
					});
				} else {
					this.auth = true
				}
			},
			onSubmit(data) {
				var that = this;
				this.http.post_show('cms/edit_config', data).then((res) => {
					that.$message({
						showClose: true,
						message: '添加成功',
						type: 'success'
					});
				});
			},
			post_config(type) {
				var that = this;
				this.http.get("cms/get_config?type="+type)
					.then((res) => {
						that.list = res.data; //收藏返回的是商品和店铺   
					})
			}
		},
		mounted() {
			// this.post_config();
			// this.check_auth('site_set')
		}
	}
</script>

<style lang="less" scoped="">
	.set {
		line-height: 30px;
		background-color: #fff;
		padding: 15px;
		text-align: left;
	}
</style>
