<template>
	<div class="discount">
		<el-container>
			<el-aside  width="160px" class="not-print bg-white erbian">
				<Nav ac="1"></Nav>
			</el-aside>
			

				<transition appear appear-active-class="animated fadeInLeft">
					<el-main class="main">
						<el-breadcrumb separator-class="el-icon-arrow-right">
							<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
							<el-breadcrumb-item>应用</el-breadcrumb-item>
							<el-breadcrumb-item>分销</el-breadcrumb-item>
						</el-breadcrumb>
						<div class="H10"></div>
						<div class="zhang t_l">
							<el-button type="primary" size="small" @click="add_user">添加分销商品</el-button>
							<div style="height:20px;">&nbsp;</div>
							<el-table :data="list" border>
								<el-table-column type="index" label="序号" width="50px"></el-table-column>
								<el-table-column prop="goodsinf.goods_name" label="商品名称" width="400">
									<template slot-scope="scope">
										{{scope.row.goodsinf.goods_name}}
									</template>
								</el-table-column>
								<el-table-column prop="goods_info.imgs" label="图片" width="110">
									<template slot-scope="scope">
										<template v-if="scope.row.getimg">
											<img :src="getimg + scope.row.getimg.thumb_img" />
										</template>
									</template>
								</el-table-column>
								<el-table-column prop="price" label="商品价格" width="100">
									<template slot-scope="scope">
										{{scope.row.goodsinf.price}}
									</template>
								</el-table-column>
								<el-table-column prop="price" label="分销佣金" width="150">
									<template slot-scope="scope">
										<el-input v-model="scope.row.price"></el-input>
									</template>
								</el-table-column>
								<el-table-column prop="operation" label="操作">
									<template slot-scope="scope">
										<el-button @click="edit(scope.row.id,scope.row.price,scope.row.goodsinf.price)" type="success" size="small">修改</el-button>
										<el-button style="margin-left: 10px" type="danger" size="small" slot="reference" @click="del(scope.row.id)">删除</el-button>
									</template>
								</el-table-column><strong></strong>
							</el-table>
						</div>
					</el-main>
				</transition>
			
		</el-container>
	</div>

</template>

<script>
import Nav from './components/extend_nav.vue'
	import {
		Loading
	} from 'element-ui';
	import {
		Api_url
	} from "@/common/config";
	export default {
		data() {
			return {
				getimg:this.$getimg,
				dialogImageUrl: '',
				dialogVisiblea: false,
				tab_nav: false,
				price: '',
				dialogVisibleadd: false,
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
				list: [],
				all: '',
				size: 10,
			}
		},
		components: {
			Nav
		},
		methods: {
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
					this.get_reseller()
				})

			},
			add_user() {
				this.$router.push({
					path: '/extend/addreseller'
				})
			},
			edit(id, price, goods_price) {
				if (price * 1 < goods_price * 1) {
					this.http.post_show('shopscms/fx/update_fx', {
						id: id,
						price: price
					}).then(res => {
						this.$message({
							showClose: true,
							message: '修改成功',
							type: 'success'
						});
					})
				} else {
					this.$message({
						message: '分销佣金必须小于商品价格',
						type: 'warning'
					});
				}

			},
			//获取商品列表
			get_reseller() {
				this.http.get('pro/get_all').then(res => {
					this.list = res.data
				})
			},
			//删除商品
			del(id) {
				var that = this;
				this.$confirm('是否删除?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.Del('pro/del_fx', {
						id: id
					}).then(() => {
						that.$message({
							showClose: true,
							message: '删除成功',
							type: 'success'
						});
						this.get_reseller()
						// that.list.splice(index, 1);
					});
				})
			},
		},
		mounted() {
			this.get_reseller();
		}
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
	}
</style>
