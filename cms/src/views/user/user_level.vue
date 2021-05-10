<template>
	<div class="user_level">
		<el-container class="container">
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="2"></Nav>
			</el-aside>
			<el-main class="main">
				<template>
					<el-breadcrumb separator-class="el-icon-arrow-right">
						<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
						<el-breadcrumb-item>用户</el-breadcrumb-item>
						<el-breadcrumb-item>用户等级</el-breadcrumb-item>
					</el-breadcrumb>
					<div class="H10"></div>
					<div class="zhang" style="text-align: left;">
						<el-button style="margin-bottom: 10px;" type="primary" size="medium" @click="add_level">新增等级</el-button>
						<el-table :data="list" border style="width: 100%">
							<el-table-column type="index" label="序号" width="80"></el-table-column>
							<el-table-column prop="name_l" label="等级名称"></el-table-column>
							<el-table-column prop="discount" label="折扣"></el-table-column>
							<el-table-column prop="created_at" label="创建时间"></el-table-column>
							<el-table-column label="操作" width="300px">
								<template slot-scope="scope">
									<el-button type="primary" size="mini" @click="edit(scope.row)">修改</el-button>
									<el-button type="danger" size="mini" @click="del(scope.row.id)">删除</el-button>
								</template>
							</el-table-column>
						</el-table>
					</div>
				</template>
			</el-main>
		</el-container>
		<el-dialog title="新增等级" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
			<el-form ref="form" :model="form" label-width="80px">
				<el-form-item label="等级名称">
					<el-input placeholder="请输入等级名称..." v-model="form.name_l"></el-input>
				</el-form-item>
				<el-form-item label="折扣">
					<el-input placeholder="请输入折扣..." v-model="form.discount"></el-input>
				</el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="sub_add">确 定</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
	import Nav from './components/user_nav.vue'
	import UserModel from "../../model/user.js"
	export default {
		components: {
			Nav
		},
		data() {
			return {
				dialogVisible: false,
				form: {
					name_l: '',
					discount: '0.8',
					sort: '0'
				},
				sort: 0,
				list: [],
			}
		},
		watch: {
			dialogVisible(n, o) {
				console.log(n)
				if (!n) {
					this.form = {
						name_l: '',
						discount: '0.8',
						sort: '0'
					}
				}
			}
		},
		mounted() {
			this.get_all_level()
		},
		methods: {
			get_all_level() {
				UserModel.get_all_level().then(res => {
					this.list = res.data
				})
			},
			sub_add() {
				if (!this.form.id)
					UserModel.add_level(this.form).then(res => {
						this.dialogVisible = false
						this.get_all_level()
					})
				else {
					UserModel.editUser(this.form).then(res => {
						this.dialogVisible = false
						this.get_all_level()
					})
				}
			},
			add_level() {
				this.dialogVisible = true
			},
			del(id) {
				UserModel.del_level(id).then(res => {
					this.$message({
						message: '操作成功',
						type: 'success'
					})
					this.get_all_level()
				})
			},
			handleClose() {
				this.dialogVisible = false
			},
			edit(data) {
				this.dialogVisible = true
				this.form = data
			},

		}
	}
</script>

<style lang="less">

</style>
