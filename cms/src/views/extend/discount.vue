<template>
	<div class="discount">
		<el-container>
			<el-aside  width="160px" class="not-print bg-white erbian">
				<Nav ac="2"></Nav>
			</el-aside>
			<el-main class="main">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>应用</el-breadcrumb-item>
					<el-breadcrumb-item>满减</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="zhang t_l">
					<el-button type="primary" size="small" @click="add_user">新增满减</el-button>
					<div style="height:20px;">&nbsp;</div>
					<template>
						<el-table :data="list" border style="width: 100%">
							<el-table-column type="index" label="序号" width="50px"></el-table-column>
							<el-table-column prop="name" label="活动名称"></el-table-column>

							<el-table-column prop="content" label="有效时间">
								<template slot-scope="scope">
									{{scope.row.start_time}}至{{scope.row.end_time}}
								</template>
							</el-table-column>
							<!-- <el-table-column prop="label" label="活动标签">
								<template slot-scope="scope">
									<el-tag type="danger" effect="dark" >{{scope.row.label}}</el-tag>
								</template>
								
							</el-table-column> -->

							<el-table-column prop="operation" label="操作" width="300px">
								<template slot-scope="scope">
									<el-button @click="edit(scope.row.id)" type="success" size="small">修改</el-button>

									<el-button style="margin-left: 10px" type="danger" size="small" slot="reference" @click="del(scope.row.id)">删除</el-button>
								</template>
							</el-table-column><strong></strong>
						</el-table>
					</template>

				</div>
				<el-pagination style="margin-top: 50px;" background layout="prev, pager, next" :total="total" :page-size="size"
					@current-change="jump_page">
				</el-pagination>
			</el-main>
				
		</el-container>
	</div>

</template>

<script>
	import extendModel from "../../model/extend.js"
	import {
		Loading
	} from 'element-ui';
	import {
		Api_url
	} from "@/common/config";

	import Nav from './components/extend_nav.vue'
	export default {
		data() {
			return {
				dialogImageUrl: '',
				dialogVisiblea: false,
				tab_nav: false,
				dialogVisible: false,
				dialogVisibleadd: false,
				dialogFormVisible: false,
				oid: 0,
				form: {
					id: '',
					goods_name: '',
					content: '',
					img_id: [],
					stock: '',
					points: ''
				},
				form_pro: {
					goods_name: '',
					content: '',
					img_id: [],
					stock: '',
					points: ''
				},
				formLabelWidth: '120px',
				list: [],
				all: '',
				size: 10,
				total: 0,
				options: [],
				value: '',
				typeList: [],
				upfile_banner_list: [],
				upfile_url: Api_url + 'com/up_img?back=id',
				upfile_head: {
					token: localStorage.getItem("token")
				},
				upfile_list: [], //上传文件列表
			}
		},
		components: {
			Nav
		},
		mounted() {
			this._load()
			// this.getCompany();
		},
		methods: {
			_load() {
				extendModel.get_all_mj().then(res=>{
					this.list = res.data
					this.total = this.list.length
				})
			},
			handleRemove(file, fileList) {
				console.log(file, fileList);
			},
			handlePictureCardPreview(file) {
				this.dialogImageUrl = file.url;
				this.dialogVisible = true;
			},
			onSubmit() {
				this.http.post_show('admin/add_goods', this.form_pro).then(() => {
					this.$message({
						type: 'success',
						message: '添加成功!'
					});
					this.form = {}
					this.upfile_banner_list = []
					this.form_pro = {
							goods_name: '',
							content: '',
							img_id: [],
							stock: '',
							points: ''
						},
						this.dialogVisibleadd = false
					this.getCompany()
				})

			},
			res_banner_imgs(res) {

				console.log('res:', res)
				this.form_pro.img_id.push(res);
				// if (this.form_pro.img_id.length < 1) {
				// 	this.form_pro.img_id = res;
				// } else {
				// 	this.form_pro.img_id = this.form_pro.img_id + "," + res;
				// }
				console.log('xx:', this.form_pro.img_id)

			},
			add_user() {
				this.$router.push({
					path: '/extend/adddiscount'
				})
			},
			edit(id) {
				this.$router.push({
					path: '/extend/editdiscount',
					query:{
						id:id
					}
				})
			},
			sub_edit() {

				this.$confirm('确定修改?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.post_show('admin/edit_goods', this.form).then(() => {
						this.$message({
							type: 'success',
							message: '修改成功!'
						});
						this.dialogVisible = false
						this.clear_data()
						this.getCompany()
					})

				}).catch(() => {
					this.$message({
						type: 'info',
						message: '已取消删除'
					});
				});
				
				this.http.post_show('admin/edit_goods', this.form).then(() => {
					this.clear_data()
					this.getCompany()
				})
			},
			jump_page(e) {
				const that = this;
				let start = (e - 1) * that.size;
				let end = e * that.size;
				console.log(start, end)
				this.list = this.all.slice(start, end);
			},
			sub() {
				
			},
			//删除商品
			del(id) {
				var that = this;
				this.$confirm('是否删除?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					extendModel.del_mj(id).then(res=>{
						that.$message({
							showClose: true,
							message: '删除成功',
							type: 'success'
						});
						this._load()
						// that.list.splice(index, 1);
					});
				})
			},
			close_fun(done) {
				this.clear_data()
				done(); //官方实例用法
			},

			clear_data() {
				this.dialogFormVisible = false
			},
		},

	}
</script>

<style lang="less">
	.discount {

		.el-table__row {
			line-height: 40px !important;

			img {
				width: 80px !important;
				height: 80px !important;
			}
		}

		.article {
			line-height: 30px;
			background-color: #fff;
			padding: 15px;
			text-align: left;
		}

		.list-head {
			padding-bottom: 10px
		}

		.el-form-item__content {
			display: flex;
			justify-content: flex-start;
		}
	}
</style>
