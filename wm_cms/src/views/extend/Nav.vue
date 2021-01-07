<template>
	<div id="ad">
		<el-container>
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="8"></Nav>
			</el-aside>
			<el-main style="background-color: #F3F3F3;">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>导航</el-breadcrumb-item>
				</el-breadcrumb>
				<transition appear appear-active-class="animated fadeInLeft">
					<div class="list">
						<div class="list-head">
							<el-row style="display: flex;">
								<el-button type="primary" size='small' @click="create_ad">添加导航</el-button>
								<el-button type="warning" size='small' @click='sort_sub'>更新排序</el-button>

								<el-dialog title="" :visible.sync="dialogFormVisible" width="45%" center>
									<el-form :model="form">
										<el-form-item label="导航名称" :label-width="formLabelWidth">
											<el-input v-model="form.nav_name" auto-complete="off"></el-input>
										</el-form-item>
										<el-form-item label="跳转到" :label-width="formLabelWidth">
											<el-input v-model="form.url" auto-complete="off"></el-input>
										</el-form-item>
										<el-form-item label="广告图片" :label-width="formLabelWidth">
											<template v-if="img_list.length > 0">
												<div style="display: flex; width:530px ; flex-wrap: wrap;">
													<template v-for="(item,index) of img_list">
														<i class="el-icon-circle-close" @click="delimg(index)"></i>
														<div class="picA" v-if="img_list.length > 0">
															<img class="img" :src="getimg + item.url">
														</div>
													</template>
												</div>
											</template>
											<div class="picA" style="margin-left: 19px;" @click="choose_pic" v-if="img_list.length < 1">
												<i class="el-icon-plus" style="margin-top: 45%; height: 28px; width: 28px;"></i>
											</div>
											<div style="margin-left:19px;fontSize:12px;marginTop:-10px;color:rgb(192,196,204);">建议上传的广告图大小：784*264</div>
										</el-form-item>
									</el-form>
									<div slot="footer" class="dialog-footer">
										<el-button type="primary" v-if="eid<1" @click="sub">立即创建</el-button>
										<el-button v-else type="success" @click="subEdit">提交修改</el-button>
									</div>
								</el-dialog>
							</el-row>
						</div>
						<template>
							<el-table :data="list" border style="width: 100%">
								<el-table-column prop="sort" label="排序" width="100" sortable>
									<template slot-scope="scope">
										<el-input v-model="scope.row.sort"></el-input>
									</template>
								</el-table-column>
								<el-table-column prop="nav_name" label="导航名称名称" width="220"></el-table-column>
								<el-table-column prop="imgs.url" label="缩略图" width="280">
									<template slot-scope="scope">
										<img :src="getimg+scope.row.imgs.url" with="140" height="70" />
									</template>
								</el-table-column>
								<el-table-column prop="url" label="跳转到" width="280">
								</el-table-column>
								<el-table-column prop="operation" label="操作">
									<template slot-scope="scope">
										<el-button type="success" size="small" @click="on_edit(scope.row)">编辑</el-button>
										<el-button style="margin-left: 10px" type="danger" size="small" slot="reference" @click="del(scope.row.id,scope.$index)">删除</el-button>
									</template>
								</el-table-column>
							</el-table>
						</template>
					</div>
				</transition>
			</el-main>
		</el-container>
		<Pic :drawer="drawer" :father_fun="get_img" :length="length"></Pic>
	</div>
</template>

<script>
	import extendModel from "../../model/extend.js"
	import Pic from '../PicList.vue'
	import {
		Loading
	} from 'element-ui';
	import {
		Api_url
	} from '@/common/config'
	import Nav from './components/extend_nav.vue'
	import Header from "@/components/header.vue";
	export default {
		name: 'Ad',
		data() {
			return {
				is_goods: '',
				eid: '',
				type_list: [],
				length: 1,
				drawer: false,
				getimg: this.$getimg,
				img_list: [],
				dialogFormVisible: false,
				form: {
					nav_name:'',
					url:'',
					img_id:0,
				},
				formLabelWidth: '120px',
				input: '',
				banners: '',
				upfile_url: Api_url + 'admin/upload/img',
				upfile_data: {
					use: 'AD'
				},
				options: [{
						value: '',
						label: '不跳转'
					},
					{
						value: 'goods',
						label: '商品'
					},
					{
						value: 'article',
						label: '文章'
					}
				],
				upfile_head: {
					token: localStorage.getItem("token")
				},
				upfile_list: [], //上传文件列表
				list: [],
				article: "",
				goods: ""
			}
		},
		components: {
			Nav,
			Pic
		},
		computed: {

		},
		watch: {
			dialogFormVisible(n, o) {
				if (!n) {
					this.img_list = []
				}
			}
		},
		methods: {
			choose(e) { //点击选择的商品或文章
				console.log(e)
			},
			is_change(e) {
				console.log(e)
				if (e == 'article') {
					this.type_list = this.article
					this.is_goods = 0
				}
				if (e == 'goods') {
					this.type_list = this.goods
					this.is_goods = 1
				}
			},
			//获取广告位
			_load() {
				var that = this;
				this.http.get('nav/get_nav')
					.then((res) => {
						console.log(res.data);
						var res_code = res.status.toString();
						if (res_code.charAt(0) == 2) {
							that.list = res.data;
						}
					});
			},
			choose_pic() {
				this.length = 6 - this.img_list.length
				this.drawer = true
			},
			get_img(e) {
				this.drawer = false
				for (let k in e) {
					const v = e[k]
					this.img_list.push(v)
					this.form.img_id = v.id
				}
				this.length = 6 - this.img_list.length
			},
			is_show() {
				this.drawer = !this.drawer
			},

			delimg(index) {
				this.img_list.splice(index, 1)
			},


			//清空form表单数据
			_clsForm() {
				const that = this
				that.eid = ""
				for (var x in that.form) {
					that.form[x] = ""
				};
			},
			subEdit() {
				const that = this;
				that.form['id'] = this.eid
				let data = {
					id:that.form.id,
					img_id:that.form.img_id,
					nav_name:that.form.nav_name,
					url:that.form.url
				}
				console.log(that.form)
				that.http.post('nav/admin/edit_nav',data).then(res=> {
						that.$message({
							showClose: true,
							message: '更新成功',
							type: 'success'
						});
						//that._clsForm()
						that.dialogFormVisible = false;
						that._load();
					});
			},
			//获取修改商品信息
			on_edit(data) {
				const that = this;
				that.eid=data.id
				that.dialogFormVisible = true
				that.form=data
				let obj = {
					id: '',
					url: ''
				}
				obj.id = data.img_id
				obj.url =data.imgs.url
				that.img_list.push(obj)
				console.log(that.img_list)
				
			},
			//提交排序
			sort_sub() {
				let obj = {}
				const that = this
				for (let value of that.list) {
					obj[value.id] = value.sort
				}
				this.http.post_show('nav/admin/set_sort', obj)
					.then((res) => {
						this.$message({
							message: '操作成功',
							type: 'success'
						})
					})
			},
			create_ad() {
				this._clsForm()
				this.dialogFormVisible = true
			},
			sub() {
				var that = this;
				let data = that.form
				//console.log(that.form)
				this.http.post('nav/admin/add_nav',data).then(res => {
					that.$message({
						showClose: true,
						message: '添加成功',
						type: 'success'
					});
					this._clsForm();
					this.img_list = []
					that.dialogFormVisible = false;
					that._load()
				});
			},
			up_ok(res) {
				this.form.img_id = res.id;
			},
			//删除广告
			del(id, index) {
				var that = this;
				this.$confirm('是否删除?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					that.http.put_show('nav/admin/del_nav?id='+id).then(res => {
						that.$message({
							showClose: true,
							message: '删除成功',
							type: 'success'
						});
						that._load()
					});
				})
			}
		},
		mounted() {
			this._load();
		}


	}
</script>

<style lang="less">
	#ad {
		line-height: 30px;

		// text-align: left;
		.list {
			line-height: 30px;
			background-color: #fff;
			padding: 15px;
			text-align: left;
		}

		.list-head {
			padding-bottom: 10px
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
