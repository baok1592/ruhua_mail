<template>
	<div class="user_list">
		<el-container class="container">
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="1"></Nav>
			</el-aside>
			<el-main class="main">
				<template>
					<el-breadcrumb separator-class="el-icon-arrow-right">
						<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
						<el-breadcrumb-item>用户</el-breadcrumb-item>
						<el-breadcrumb-item>用户列表</el-breadcrumb-item>
					</el-breadcrumb>
					<div class="H10"></div>
					<div class="zhang">
						<el-collapse v-model="activeNames" @change="handleChange">
							<el-collapse-item title="会员搜索" name="1">
								<div class="user_sear">
									<div class="sear_01">
										<div class="sear_01_01">
											<div class="sear_01_01_1">昵称：</div>
											<el-input v-model="nickname" size="small" placeholder="请输入昵称" @keyup.enter.native="search(nickname)"></el-input>
											<div style="margin-left: 20px;">
												<el-button type="success" size="small" @click="search(nickname)"><i class="el-icon-search"></i>搜索</el-button>
											</div>
											<div style="margin-left: 20px;">
												<el-button type="primary" size="small" @click="reset">重置</el-button>
											</div>

										</div>
									</div>
									<div class="sear_01"> 
									</div> 
								</div>
							</el-collapse-item>
						</el-collapse>

						<div class="article">
							<div style="height:20px;">&nbsp;</div>
							<template>
								<el-table :data="list" border style="width: 100%">
									<el-table-column type="index" label="序号" width="50px"></el-table-column>
									<!-- <el-table-column prop="id" label="ID"></el-table-column> -->
									<el-table-column prop="nickname" label="昵称"></el-table-column>
									
									<el-table-column prop="points" label="积分">
										<template slot-scope="scope">
											<el-button type="text" @click="edit_info('point',scope.row,scope.$index)">{{scope.row.points?scope.row.points:0}}</el-button>
										</template>
									</el-table-column>
									<el-table-column label="余额">
										<template slot-scope="scope">
											<el-button type="text" @click="edit_info('money',scope.row,scope.$index)">{{scope.row.money?scope.row.money:0}}</el-button>
										</template>

									</el-table-column>
									<el-table-column label="会员等级">
										<template slot-scope="scope">
											<el-button type="text" @click="edit_info('level',scope.row,scope.$index)">{{scope.row.level?scope.row.level.name_l:'暂无'}}</el-button>
										</template>
									</el-table-column>
									<el-table-column prop="created_at" label="创建时间"></el-table-column>
									<el-table-column prop="operation" label="操作" width="300px">
										<template slot-scope="scope">
											<el-button type="primary" size="mini" @click="user_detail(scope.row.id)">查看</el-button>
											<el-button type="danger" size="mini" @click="del_user(scope.row.id)">删除</el-button>
										</template>
									</el-table-column><strong></strong>
								</el-table>
							</template>
						</div>
						<el-pagination style="margin-top: 50px;" background layout="prev, pager, next" :total="total" :page-size="size"
						 @current-change="jump_page">
						</el-pagination>
					</div>
				</template>
			</el-main>
		</el-container>
		<el-dialog title="修改" :visible.sync="edit_dialog" width="30%" :before-close="handleClose">
			<el-form ref="form" :model="form" label-width="80px">
				<template v-if="dialog_type == 'point'">
					<span>请输入'+&nbsp;或&nbsp;-'&nbsp;+积分&nbsp;如：+100</span>
					<el-form-item label="积分">
						<el-input v-model="form.points"></el-input>
					</el-form-item>
				</template>
				<template v-if="dialog_type == 'money'">
					<span>请输入'+&nbsp;或&nbsp;-'&nbsp;+金额&nbsp;如：+100</span>
					<el-form-item label="余额">
						<el-input v-model="form.money"></el-input>
					</el-form-item>
				</template>
				<el-form-item label="等级" v-if="dialog_type == 'level'">
					<el-select v-model="form.level_id" placeholder="请选择">
						<el-option v-for="item in level_list" :key="item.id" :label="item.name_l" :value="item.id?item.id:'暂无等级'">
						</el-option>
					</el-select>
				</el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="edit_dialog = false">取 消</el-button>
				<el-button type="primary" @click="sub_edit">确 定</el-button>
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
				edit_dialog: false,
				form: {
					id: '',
					money: "",
					level_id: "",
					points: ''
				},
				activeNames: ['1'],
				level_list: [],
				nickname: '',
				dialogImageUrl: '',
				oid: 0,
				list: [],
				all: '',
				size: 10,
				total: 0,
				dialog_type: '', //弹窗类型
				user_form: {},

				data: [{
						time: '2020-07-22',
						type: "money",
						value: "+100"
					},
					{
						time: '2020-07-23',
						type: "points",
						value: "-50"
					},
					{
						time: '2020-07-24',
						type: "level",
						value: "11"
					},
				]
			}
		},
		watch: {
			edit_dialog(n, o) {
				if (!n) {
					this.form = {
						id: '',
						money: "",
						level_id: "",
						points: ''
					}
				}
			}
		},
		mounted() {
			this._load();
			this.get_all_level()
		},
		methods: {
			_load() {
				UserModel.get_all_user().then(res => {
					this.all = res.data
					this.total = res.data.length
					this.list = res.data.slice(0, this.size)
				})
			},
			user_detail(id) {
				this.$router.push({
					path: '/user/user_detail',
					query: {
						id: id
					}
				})
			},
			get_all_level() {
				UserModel.get_all_level().then(res => {
					this.level_list = res.data
				})
			},
			//提交修改
			sub_edit() {
				console.log(this.form, this.user_form)
				if (this.form.points.indexOf("-") >= 0) {
					let points = this.form.points.split('-')
					if (points[1] * 1 > this.user_form.points) {
						this.$message({
							message: '扣除的积分不能大于用户原有积分',
							type: 'warning'
						})
						return
					}

				}
				if (this.form.money.indexOf("-") >= 0) {
					let money = this.form.money.split('-')
					if (money[1] * 1 > this.user_form.money) {
						this.$message({
							message: '扣除的金额不能大于用户原有金额',
							type: 'warning'
						})
						return
					}

				}
				UserModel.edit_userinfo(this.form).then(res => {
					this.edit_dialog = false
					this._load()
				})
			},
			handleClose() {
				this.edit_dialog = false
			},
			del_user(id) {
				const that = this
				this.$confirm('确定删除该用户', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					UserModel.del_user(id).then(res => {
						this.$message({
							type: 'success',
							message: '删除成功!'
						});
						that._load()
					})

				})
			},
			//点击修改
			edit_info(type, item, index) {
				console.log(type, item, index)
				this.edit_dialog = true
				this.dialog_type = type
				this.form = {
					id: item.id,
					money: item.money + '',
					level_id: item.level_id,
					points: item.points + ''
				}
				this.user_form = {
					id: this.list[index].id,
					money: this.list[index].money,
					level_id: this.list[index].level_id,
					points: this.list[index].points
				}
			},

			reset() {
				this._load()
			},
			search(key) {
				const that = this
				that.list = []
				for (let k in that.all) {
					let v = that.all[k]
					if (v.nickname.indexOf(key) >= 0) {
						that.list.push(v)
					}
				}
				that.total = this.list.length;
				that.list = that.list.slice(0, that.size);
				this.nickname = []
			},
			handleChange() {

			},
			handleRemove(file, fileList) {
				console.log(file, fileList);
			},
			handlePictureCardPreview(file) {
				this.dialogImageUrl = file.url;
				this.dialogVisible = true;
			},
			jump_page(e) {
				const that = this;
				let start = (e - 1) * that.size;
				let end = e * that.size;
				console.log(start, end)
				this.list = this.all.slice(start, end);
			},
			del(id) {
				var that = this;
				this.$confirm('是否删除?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {

				})
			},

		},
	}
</script>

<style lang="less">
	.user_sear {
		line-height: 40px;
		text-align: left;
		color: #6B6B6B;
		font-size: 14px;
		padding: 15px 15px;
		border-top: 1px solid #F0F0F0;

		.sear_01 {
			display: flex;
			margin-bottom: 0px;

			.sear_01_01 {
				display: flex;
				margin-right: 30px;

				.sear_01_01_1 {
					flex-shrink: 0;
				}

				.el-input__inner {
					width: 200px;
				}
			}
		}

		.sea_02_02_r_2_1 {
			background-color: #008DE1;
			color: #fff;
			padding: 0 10px;
			margin-right: 10px;
			border-radius: 3px;
			width: 45px;
		}
	}
</style>
