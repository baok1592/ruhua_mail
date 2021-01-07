<template>
	<div class="pt">
		<el-container>
			<el-aside  width="160px" class="not-print bg-white erbian">
				<Nav ac="3"></Nav>
			</el-aside>
			
			<el-main class="main">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>应用</el-breadcrumb-item>
					<el-breadcrumb-item>拼团</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="zhang t_l">
					<el-button type="primary" size="small" style="display: flex;justify-content: flex-start;" @click="add_pt">添加拼团</el-button>
					<div style="height:20px;">&nbsp;</div>
					<template>
						<el-table :data="list" border style="width: 100%">
							<el-table-column type="index" label="序号" width="50px"></el-table-column>
							<el-table-column prop="name" label="活动名称"></el-table-column>

							<el-table-column prop="content" label="活动时间">
								<template slot-scope="scope">
									{{scope.row.start_time}}日--{{scope.row.end_time}}日
								</template>
							</el-table-column>
							<el-table-column prop="pt_time" label="有效入团时间">
								<template slot-scope="scope">
									<el-tag type="danger" effect="dark" >{{scope.row.pt_time}}小时之内</el-tag>
								</template>
							</el-table-column>
							
							<el-table-column prop="user_num" label="成团人数">
								<template slot-scope="scope">
									{{scope.row.user_num}}人
								</template>
							</el-table-column>
							<el-table-column prop="operation" label="操作" width="300px">
								<template slot-scope="scope">
									<el-button @click="edit(scope.row)" type="success" size="small">修改</el-button>

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
				formLabelWidth: '120px',
				list: [],
				all: '',
				size: 10,
				total: 0,
				options: [],
				value: '',
				typeList: [],
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
				this.http.get('pt/admin/get_pt').then(res => {
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
			add_pt() {
				this.$router.push({
					path: '/extend/add_pt'
				})
			},
			edit(item) {
				localStorage.setItem("edit_data",JSON.stringify(item));
				this.$router.push({
					path: '/extend/edit_pt'
				})
			},
			sub_edit() {},
			jump_page(e) {
				const that = this;
				let start = (e - 1) * that.size;
				let end = e * that.size;
				console.log(start, end)
				this.list = this.all.slice(start, end);
			},
			sub() {
				
			},
			//获取商品列表
			getCompany() {
				
			},
			//删除商品
			del(id) {
				var that = this;
				this.$confirm('是否删除?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.put_show('pt/admin/del_pt', {
						id: id
					}).then(() => {
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
	.pt {
		

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
