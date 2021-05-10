<template>
	<div id="ad">
		<el-container>
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="3"></Nav>
			</el-aside>
			<el-main style="background-color: #F3F3F3;">
				<transition appear appear-active-class="animated fadeInLeft">
					<div class="list">
						<div class="list-head">
							<el-row style="display: flex;">
								<el-button type="primary" size='small' @click="create_ad">添加广告</el-button>
								<el-button type="warning" size='small' @click='sort_sub'>更新排序</el-button>
								<!-- 弹框修改和添加广告 -->
								<el-dialog title="" :visible.sync="dialogFormVisible" width="45%" center>
									<el-form :model="form">
										<el-form-item label="广告位名称" :label-width="formLabelWidth">
											<el-input v-model="form.key_word" auto-complete="off"></el-input>
										</el-form-item>
										<el-form-item label="选择广告位" :label-width="formLabelWidth">
											<el-select v-model="form.banner_id">
												<el-option v-for="item in banners" :key="item.id" :value="item.id" :label="item.description"></el-option>
											</el-select>
										</el-form-item>
										<el-form-item label="跳转到" :label-width="formLabelWidth">
											<el-select v-model="form.type" @change="is_change">
												<el-option v-for="item in options" :key="item.value" :value="item.value" :label="item.label"></el-option>
											</el-select>
											&emsp;&emsp;
											<el-select v-if="type_list.length" v-model="form.jump_id" @change="choose">
												<template v-for="(item,index) of type_list">
													<el-option v-if="is_goods == 1" :key="index" :value="item.goods_id" :label="item.goods_name"></el-option>
													<el-option v-if="is_goods == 0" :key="index" :value="item.id" :label="item.title"></el-option>
												</template>
											</el-select>
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
										<el-button type="primary" :disabled="addAdBotton" v-if="eid<1" @click="sub">立即创建</el-button>
										<el-button v-else type="success" @click="subEdit">提交修改</el-button>
									</div>
								</el-dialog>
							</el-row>
						</div>
						<!-- 广告列表 -->
						<template>
							<el-table :data="list" border style="width: 100%">
								<el-table-column prop="sort" label="排序" width="100" sortable>
									<template slot-scope="scope">
										<el-input v-model="scope.row.sort"></el-input>
									</template>
								</el-table-column>
								<el-table-column prop="key_word" label="名称" width="220"></el-table-column>
								<el-table-column prop="banner.name" label="所属广告位" width="220"></el-table-column>
								<el-table-column prop="imgs.url" label="缩略图" width="280">
									<template slot-scope="scope">
										<img :src="getimg+scope.row.imgs.url" with="140" height="70" />
									</template>
								</el-table-column>
								<el-table-column prop="main.title" label="跳转到" width="280">
									<template slot-scope="scope">
										<p v-if="scope.row.type=='goods'">商品</p>
										<p v-else-if="scope.row.type=='article'">文章</p>
										<p v-else>不跳转</p>
									</template>
								</el-table-column>
								<el-table-column prop="operation" label="操作">
									<template slot-scope="scope">
										<el-button type="success" size="small" @click="on_edit(scope.row.id)">编辑</el-button>
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
					key_word: '',
					img_id: '',
					banner_id: '',
					type: "",
					jump_id: ""
				},
				formLabelWidth: '120px',
				input: '',
				banners: '',
				upfile_url: Api_url + 'admin/upload/img',
				upfile_data: {
					use: 'AD'
				},
				options: [{
						value: '0',
						label: '不跳转'
					},
					// {
					// 	value: 'goods',
					// 	label: '商品'
					// },
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
				goods: "",
				// 控制添加广告时按钮显隐
				addAdBotton: false,
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
				console.log('跳转到', e)
				if (e == 'article') {
					this.type_list = this.article
					this.is_goods = 0
				}
				else if (e == 'goods') {
					this.type_list = this.goods
					this.is_goods = 1
				}
				else {
					this.type_list = [];
				}
			},
			//获取广告位
			_load() {
				var that = this;
				this.http.get('banner/get_all_banner')
					.then((res) => {
						// console.log(res.data);
						var res_code = res.status.toString();
						if (res_code.charAt(0) == 2) {
							that.banners = res.data;
						}
					});
				this.http.get('product/admin/all_goods_name').then((res) => {
					this.goods = res.data
				});
				this.http.get('article/admin/all_article_name')
					.then((res) => {
						this.article = res.data
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
				console.log('get_img_end:', e, this.img_list)
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
				that.upfile_list = [];
				for (var x in that.form) {
					that.form[x] = ""
				};
			},
			subEdit() {
				const that = this;
				that.form['id'] = this.eid
				let data = {
					banner_id: this.form.banner_id,
					id: this.form.id,
					img_id: this.form.img_id,
					is_visible: this.form.is_visible,
					jump_id: this.form.jump_id,
					key_word: this.form.key_word,
					sort: this.form.sort,
					type: this.form.type
				}
				this.http.post_show('banner/admin/edit_banner', data)
					.then((res) => {
						that.$message({
							showClose: true,
							message: '更新成功',
							type: 'success'
						});
						that._clsForm()
						that.dialogFormVisible = false;
						that.getBannerItems();
					});
			},
			//获取修改商品信息
			on_edit(id) {
				const that = this;
				this.dialogFormVisible = true
				this.eid = id;
				this.img_list = []
				let obj = {
					id: '',
					url: ''
				}
				this.http.get('banner/get_banner_content?id=' + id)
					.then((res) => {
						// console.log(res)
						that.form = res.data
						// if(that.form.type == "0") {
						// 	that.form.type = Number(that.form.type);
						// }
						this.is_change(res.data.type)
						obj.id = res.data.img_id
						obj.url = res.data.imgs.url
						this.img_list.push(obj)
						// console.log(this.img_list)
					})
			},
			//提交排序
			sort_sub() {
				let obj = {}
				const that = this
				for (let value of that.list) {
					obj[value.id] = value.sort
				}
				console.log(obj)
				this.http.post('banner/admin/set_sort', obj).then((res) => {
					this.$message({
						message: '操作成功',
						type: 'success'
					})
					that._load();
					that.getBannerItems();
				})
			},
			create_ad() {
				this._clsForm()
				this.dialogFormVisible = true
			},
			sub() {
				this.addAdBotton = true;
				var that = this;
				let data = {
					banner_id: that.form.banner_id,
					img_id: that.form.img_id,
					jump_id: that.form.jump_id || 0,
					key_word: that.form.key_word,
					type: that.form.type || 0
				}
				extendModel.add_ad(data).then(() => {
					that.$message({
						showClose: true,
						message: '添加成功',
						type: 'success'
					});
					for (var x in that.form) {
						that.form[x] = ""
					}
					this.img_list = []
					that.upfile_list = [];
					that.dialogFormVisible = false;
					that.getBannerItems();
					that.addAdBotton = true;
				});
			},

			//获取所有广告位下的广告
			getBannerItems() {
				var that = this;
				// let loadingInstance = Loading.service({
				// 	fullscreen: true
				// }); //显示加载 
				extendModel.get_all_ad().then(res => {
					// loadingInstance.close(); //关闭加载 
					var res_code = res.status.toString();
					if (res_code.charAt(0) == 2) {
						that.list = res.data;
					}
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
					extendModel.del_ad({
						id: id
					}).then(res => {
						that.$message({
							showClose: true,
							message: '删除成功',
							type: 'success'
						});
						that.getBannerItems()
					});
				})
			}
		},
		mounted() {
			this._load();
			this.getBannerItems();
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
