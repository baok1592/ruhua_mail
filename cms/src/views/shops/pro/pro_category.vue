<template>
	<div class="pro_category">
		<el-container class="container">
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="2"></Nav>
			</el-aside>
			<el-main class="main">
				<template>
					<el-breadcrumb separator-class="el-icon-arrow-right">
						<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
						<el-breadcrumb-item>商家</el-breadcrumb-item>
						<el-breadcrumb-item>商品分类</el-breadcrumb-item>
					</el-breadcrumb>
					<div class="H10"></div>
					<div class="zhang">
						<div class="category">
							<!-- 弹窗--新增分类 -->
							<AddCategory @up_parent="up_list" :list="category_top"></AddCategory>

							<!-- 弹窗--修改分类 -->
							<el-dialog title="" :visible.sync="editbox" width="35%" center>
								<el-form :model="editform">
									<el-form-item label="商品分类名称" :label-width="formLabelWidth" style='width: 80%'>
										<el-input v-model="editform.category_name" auto-complete="off"></el-input>
									</el-form-item>
								</el-form>
								<div slot="footer" class="dialog-footer" style='text-align: center'>
									<el-button @click="editbox = false">取 消</el-button>
									<el-button type="primary" @click="onSubmit(editindex)">确 定</el-button>
								</div>
							</el-dialog>
							
							<template>
								<el-table :data="category" border style="width: 100%" :default-sort="{prop: 'sort', order: 'descending'}">
									<!-- <el-table-column prop="sort" label="排序" width="100" sortable>
										<template slot-scope="scope">
											<el-input v-model="scope.row.sort"></el-input>
										</template>
									</el-table-column> -->
									<el-table-column type="index" label="序号" width="80">
									</el-table-column>
									<el-table-column prop="name" label="分类名字">
										<template slot-scope="scope">
											{{scope.row.name}}
											<!-- <span v-if="scope.row.line">&emsp;&emsp;|——</span>{{scope.row.name}} -->
										</template>
									</el-table-column>
									<el-table-column prop="level" label="操作">
										<template slot-scope="scope">
											<!-- <el-button type="success" size="small" @click="onedit(scope.row.id)">修改</el-button> -->
											<el-button type="danger" size="small" @click="del(scope.row.id,scope.$index)">删除</el-button>
										</template>
									</el-table-column>
								</el-table>
							</template>
							<!-- <div class="sort_btn">
								<el-button type="success" size="small" @click="sort_sub">提交排序</el-button>
							</div> -->
						</div>
					</div>
				</template>
			</el-main>
		</el-container>
		<Pic ref="child" :drawer="drawer" :father_fun="get_img" :length="length" :iscg="is_cg"></Pic>
	</div>
</template>

<script>
	import categoryModel from '@/api/category'
	import {
		Loading
	} from 'element-ui';
	import AddCategory from '@/components/AddCategory.vue'
	import {
		Api_url
	} from '@/common/config.js'
	import Nav from '../components/shop_nav.vue'
	import Pic from '../../PicList.vue'
	export default {
		components: {
			Nav,
			Pic,
			AddCategory
		},
		data() {
			return {
				is_cg: 0,
				length: 1,
				drawer: false,
				getimg: this.$getimg,
				img_list: [],
				input: '',
				category: [],
				category_top: [],
				dialogTableVisible: false,
				editbox: false, //修改的box
				editform: {
					category_name: '',
					short_name: '',
					pid: '',
					category_pic: [],
					imgs: []
				},
				formLabelWidth: '120px',
				editindex: 0,
				upfile_url: Api_url + '/admin/upload/img',
				upfile_data: {
					use: 'category'
				},
				upfile_head: {
					token: localStorage.getItem("token")
				}
			};
		},
		mounted() {
			this.getCategory()
		},
		methods: {
			getCategory() {
				var that = this;
				var arr = [];
				this.http.get('/cate/get_category_all').then(res => {
					for (var i = 0; i < res.data.length; i++) {
						if (res.data[i].level == 1) {
							arr.push(res.data[i]);
						}
						if (res.data[i].level == 2) {
							res.data[i].line = true;
						} else {
							res.data[i].line = false;
						}
					}
					that.category = res.data;
					console.log(res.data)
					that.category_top = arr;
				})
				
			},


			to_choose_img() {
				this.drawer = !this.drawer
			},
			is_show() {
				this.drawer = !this.drawer
			},
			get_img(e) {
				// this.img_list = e
				// for (let v in e) {
				// 	this.editform.category_pic = e[v].id
				// 	this.editform.imgs = e[v].url
				// }
				// console.log(this.form.img_id)



				this.drawer = false
				for (let k in e) {
					const v = e[k]
					this.img_list.push(v)
					this.editform.category_pic = v.id
					this.editform.imgs = v.url
				}
				this.length = 6 - this.img_list.length
				console.log('get_img_end:', e, this.img_list)



			},
			delimg(index) {
				// this.img_list.splice(index, 1)
				this.editform.imgs = ''
			},


			//删除分类
			del(id, index) {
				var that = this;
				this.$confirm('是否删除?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.Del('cate/del_category', {
						id: id
					}).then((res) => {
						if (res.data == 1) {
							that.$message({
								showClose: true,
								message: res.msg,
								type: 'success'
							});
						} else {
							that.$message({
								showClose: true,
								message: res.msg,
								type: 'warning'
							});
						}

						this.getCategory()
					})
				})
			},
			//修改分类
			onedit(id) {
				console.log(id)

				// this.editform = this.category[index];
				const that = this
				for (let k in that.category) {
					let v = that.category[k]
					if (v.id == id) {
						that.editform = v
					}
				}
				console.log(this.editform)
				// this.editindex = index;
				this.editbox = true;
			},
			//新增分类成功后
			up_list() {
				this.getCategory();
			},
			//提交排序
			sort_sub() {
				let obj = {}
				const that = this
				for (let value of that.category) {
					obj[value.category_id] = value.sort
				}
				this.http.post_show('category/admin/set_sort', obj)
					.then((res) => {
						this.$message({
							message: '操作成功',
							type: 'success'
						})
					})
			},
			//更新分类
			onSubmit(index) {
				const that = this;
				this.http.post_show('category/admin/edit_category', {
					form: that.editform
				}).then((res) => {
					this.$message({
						message: '修改成功',
						type: 'success'
					})
					// console.log(res.data);
					that.editbox = false;
					// this.category.splice(index, 1, res.data);
					this.getCategory()
				});
			},
			//是否隐藏
			onswitch(id) {
				var that = this;
				this.http.put_show('/cms/update', {
						id: id,
						db: 'category',
						field: 'is_visible'
					})
					.then((res) => {
						console.log(res);
					});
			},
			up_ok(res) {
				if (res.code == 201) {
					this.editform.category_pic = res.id;
				}
			},

		},

	}
</script>

<style lang="less">
	.pro_category {
		.category {
			line-height: 30px;
			text-align: left;
			background-color: #fff;
		}

		.sort_btn {
			margin-top: 20px;
			;
		}

		.btn {
			margin-bottom: 6px;
		}

		.picA {
			width: 148px;
			height: 148px;
			background-color: #FBFDFF;
			border: 1px dashed #C0CCDA;
			border-radius: 6px;
			box-sizing: border-box;
			vertical-align: top;
			text-align: center;
			margin: 6px;


			img {
				width: 144px;
				height: 144px;
				border: 1px solid #BFBFBF;
				border-radius: 3px;
			}
		}
	}
</style>
