<template>
	<div class="order_protection">
		<el-container class="container">
			<el-aside  width="160px" class="not-print bg-white erbian">
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
						<el-table :data="tableData" border style="width: 100%;">
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
									<spqn v-if="scope.row.status==0">退款中</spqn>
									<spqn v-else-if="scope.row.status==1">已退款</spqn>
									<spqn v-else>已驳回</spqn>
								</template>
							</el-table-column>
							<el-table-column prop="operation" label="操作" >
								<template slot-scope="scope">
									<el-button type="danger" size="small" @click="tk(scope.row)">退款</el-button>
									<el-button type="danger" size="small" @click="tkbh(scope.row)">退款驳回</el-button>
									
								</template>
							</el-table-column>
						</el-table>
					</div>
				</template> 
			</el-main>
		</el-container>
	</div>
</template>

<script>
	import {Api_url} from "@/common/config.js"
	import Nav from './components/order_nav.vue'
	export default{
		components:{
			Nav
		},
		data(){
			return{
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
				this.http.get('order/admin/get_tui_all').then(res => {
					console.log(res.data)
					this.tableData=res.data
				})
			},
			tkbh(data){
				this.http.post('order/admin/tui_bohui',data).then(res=>{
					if(res.status==200){
						this.$message({
							type: 'success',
							message: '操作成功!'
						});
						this.get_all_apply()
					}else{
						this.$message({
							type: 'waring',
							message: res.msg
						});
					}
				
				})
			},
			tk(data) {
					this.http.post_show('order/admin/tui_money',data).then(res => {
						if(res.status==200){
							this.get_all_apply()
							this.$message({
								type: 'success',
								message: '操作成功!'
							});
							this.message = ''
						}else{
							this.$message({
								type: 'waring',
								message: res.msg
							});
						}
						
					})
				// })
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
