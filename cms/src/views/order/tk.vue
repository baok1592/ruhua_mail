<template>
	<div class="order_protection">
		<el-container class="container">
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="4"></Nav>
			</el-aside>
			<el-main class="main">

				<template>
					<el-breadcrumb separator-class="el-icon-arrow-right">
						<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
						<el-breadcrumb-item>退款列表</el-breadcrumb-item>
					</el-breadcrumb>
					<div class="H10"></div>
					<div class="zhang">
						<el-tabs type="border-card">
							<el-tab-pane label="待处理">
								<el-table :data="wait_data" border style="width: 100%;">
									<el-table-column type="index" label="序号" width="100">
									</el-table-column>
									<el-table-column prop="order_num" label="订单号" width="200">
									</el-table-column>
									<el-table-column prop="tui_num" label="退款单号" width="120">
									</el-table-column>
									<el-table-column prop="nickname" label="用户昵称" width="150">
									</el-table-column>
									<el-table-column prop="money" label="退款金额" width="120">
									</el-table-column>
									<el-table-column prop="message" label="商家回复" width="220">
										<template slot-scope="scope">
											<el-input v-model="scope.row.message"></el-input>
										</template>
									</el-table-column>
									<el-table-column prop="because" label="退款原因" width="220"></el-table-column>
									<el-table-column label="状态" width="120">
										<template slot-scope="scope">
											<span v-if="scope.row.status==0">退款中</span>
											<span v-else-if="scope.row.status==1">已退款</span>
											<span v-else>已驳回</span>
										</template>
									</el-table-column>
									<el-table-column prop="operation" label="操作">
										<template slot-scope="scope">
											<el-button type="primary" size="small" @click="tk(scope.row)">确认退款</el-button>
											<el-button type="danger" size="small" @click="tkbh(scope.row)">驳回申请</el-button>

										</template>
									</el-table-column>
								</el-table>
							</el-tab-pane>
							<el-tab-pane label="已处理">
								<el-table :data="done_data" border style="width: 100%;">
									<el-table-column type="index" label="序号" width="100">
									</el-table-column>
									<el-table-column prop="order_num" label="订单号" width="200">
									</el-table-column>
									<el-table-column prop="tui_num" label="退款单号" width="120">
									</el-table-column>
									<el-table-column prop="nickname" label="用户昵称" width="150">
									</el-table-column>
									<el-table-column prop="money" label="退款金额" width="120">
									</el-table-column>
									<el-table-column prop="message" label="商家回复" width="220">
										<template slot-scope="scope">
											<el-input :disabled="true" v-model="scope.row.message"></el-input>
										</template>
									</el-table-column>
									<el-table-column prop="because" label="退款原因" ></el-table-column>
									<el-table-column label="状态" >
										<template slot-scope="scope">
											<span v-if="scope.row.status==0">退款中</span>
											<span v-else-if="scope.row.status==1">已退款</span>
											<span v-else>已驳回</span>
										</template>
									</el-table-column>
									<!-- <el-table-column prop="operation" label="操作">
										<template slot-scope="scope">
											<el-button type="primary" size="small" @click="tk(scope.row)">确认退款</el-button>
											<el-button type="danger" size="small" @click="tkbh(scope.row)">驳回申请</el-button>

										</template>
									</el-table-column> -->
								</el-table>
							</el-tab-pane>
						</el-tabs>
					</div>
				</template>
			</el-main>
		</el-container>
	</div>
</template>

<script>
	import {
		Api_url
	} from "@/common/config.js"
	import Nav from './components/order_nav.vue'
	export default {
		components: {
			Nav
		},
		data() {
			return {
				wait_data: [],
				done_data: [],
				imgurl: Api_url,
				tableData: [],
				message: '',
				id: '',
				num: '',
			}
		},
		mounted() {
			// this.get_region()
			this.get_all_apply()
		},
		methods: {
			get_all_apply() {
				const that = this
				this.http.get('order/admin/get_tui_all').then(res => {
					console.log(res.data)
					for (let k in res.data) {
						let v = res.data[k]
						if (v.status == 0 || v.status == 2) {
							that.wait_data.push(v)
						} else {
							that.done_data.push(v)
						}
					}
					// this.tableData = res.data
				})
			},
			tkbh(data) {
				if (!data.message) {
					this.$message({
						type: 'warning',
						message: '请输入驳回理由!'
					});
					return
				}
				this.http.post('order/admin/tui_bohui', data).then(res => {
					this.$message({
						type: 'success',
						message: '操作成功!'
					});
					this.get_all_apply()
				})
			},
			tk(data) {
				this.$confirm('确定同意退款？', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.post_show('order/admin/tui_money', data).then(res => {
						this.get_all_apply()
						this.$message({
							type: 'success',
							message: '操作成功!'
						});
						this.message = ''
					})

				})
			},

		}
	}
</script>

<style lang="less">
	.zs-img {
		width: 60px;
		height: 60px;
		margin: 0 10px;
	}
</style>
