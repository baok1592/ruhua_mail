<template>
	<div class="adddiscount">
		<el-container>
			<el-aside  width="160px" class="not-print bg-white erbian">
				<Nav ac="4"></Nav>
			</el-aside>
			
			<el-main class="main">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>应用</el-breadcrumb-item>
					<el-breadcrumb-item>满减活动</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="add">
					<div class="add_btn">
						<el-button type="primary" size="small" @click="jumpback">返回</el-button>
					</div>
					<div class="xiao">活动信息</div>
					<el-form ref="form" :model="form" label-width="120px" class="demo-dynamic">
						<el-form-item label="活动名称">
							<el-input v-model="form.name" hide-required-asterisk style="width:500px"></el-input>
						</el-form-item>
						<el-form-item label="满多少">
							<el-input v-model="form.full" hide-required-asterisk style="width:500px"></el-input>
						</el-form-item>
						<el-form-item label="减多少">
							<el-input v-model="form.reduce" hide-required-asterisk style="width:500px"></el-input>
						</el-form-item>
						<el-form-item label="生效时间">
							<el-date-picker type="date" placeholder="选择日期" v-model="form.start_time" style="width: 200px;"></el-date-picker>
							&emsp;至&emsp;
							<el-date-picker type="date" placeholder="选择日期" v-model="form.end_time" style="width: 200px;"></el-date-picker>
						</el-form-item>
						<!-- <el-form-item label="活动标签">
							<el-input v-model="form.label" hide-required-asterisk style="width:300px"></el-input>
						</el-form-item> -->
					</el-form>
					<div class="xiao">选择活动商品</div>
					<el-tabs type="border-card" style="margin-bottom: 20px" v-model="active_name">
						<el-tab-pane label="第一步：选择商品" name="one">
							<div class="choose">
								<div class="search">
									<el-select v-model="value" placeholder="所有分组">
										<el-option label="一" value="shanghai"></el-option>
										<el-option label="二" value="beijing"></el-option>
									</el-select>&emsp;
									<el-button type="primary">搜索</el-button>
								</div>
								<el-table :data="tableData" style="width: 100%;" :row-class-name="tableRowClassName">
									<el-table-column prop="" label="商品信息">
										<template slot-scope="scope">
											<div class="pro">

												<div class="pro_02"><img :src="getimg +scope.row.img_id" /></div>
												<div class="pro_03">
													<div class="pro_03_1">{{scope.row.goods_name}}</div>
													<div class="pro_03_2">¥{{scope.row.price}}</div>
												</div>
											</div>
										</template>

									</el-table-column>
									<el-table-column prop="stock" label="库存">
									</el-table-column>
									<el-table-column prop="operation" label="操作" width="300px">
										<template slot-scope="scope">
											<el-button v-if="scope.row.is_discount == 1" type="primary" size="small" @click="add_discout(scope.row.goods_id,scope.$index,scope.row)">参加满减</el-button>

											<el-button v-if="scope.row.is_discount == 2" type="danger" size="small" slot="reference" @click="del(scope.$index)">取消参加</el-button>
										</template>
									</el-table-column>
								</el-table>
							</div>
							<div class="quan">
								<!-- <div class="quan_l">
									<el-checkbox v-model="checked"></el-checkbox>&nbsp;全选
								</div> -->
								<div class="quan_r">共5条，每页30条</div>
							</div>
						</el-tab-pane>
						<el-tab-pane label="第二步：设置满减" name="two" v-if="is_two == 1">
							<div class="choose">
								<el-table :data="discount_list" style="width: 100%;" :row-class-name="tableRowClassName">
									<el-table-column prop="" label="">
										<template slot-scope="scope">
											<div class="pro">
												<div class="pro_02"><img :src="getimg + scope.row.img_id" /></div>
												<div class="pro_03">
													<div class="pro_03_1">{{scope.row.goods_name}}</div>
													<div class="pro_03_2">¥{{scope.row.price}}</div>
												</div>
											</div>
										</template>
									</el-table-column>
									
									<el-table-column prop="" label="">
										<template slot-scope="scope">
											减价：满{{form.full}}减{{form.reduce}}元
										</template>

									</el-table-column>
									<el-table-column prop="operation" label="" width="300px">
										<template slot-scope="scope">
											<el-button type="primary" size="small" @click="del_disgoods(scope.$index)">取消</el-button>
										</template>
									</el-table-column>
								</el-table>
							</div>
							<div class="quan">
								<!-- <div class="quan_l">
									<el-checkbox v-model="checked"></el-checkbox>&nbsp;全选
								</div> -->
								<div class="quan_r">共5条，每页30条</div>
							</div>
						</el-tab-pane>
						<el-pagination background layout="prev, pager, next" :total="total"  @current-change="jump_page">
						</el-pagination>

					</el-tabs>

					<span slot="footer" class="dialog-footer ">
						<el-button @click="jumpback">取 消</el-button>
						<el-button @click="next" v-if="is_two == 0">下一步</el-button>
						<el-button @click="back" v-if="is_two == 1">上一步</el-button>
						<el-button type="primary" @click="onSubmit" v-if="is_two == 1">确 定</el-button>
					</span>
				</div>
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
	import extendModel from "../../model/extend.js"
	import proModel from "../../model/product.js"
	export default {
		data() {
			return {
				active_name: 'two',
				is_two: 1,
				discount_list: [],
				getimg: this.$getimg,
				choose: true,
				tableData: [],
				tab_nav: false,
				dialogVisibleadd: false,
				dialogFormVisible: false,
				oid: 0,
				form: {
					goods_json:[]
				},
				list: [],
				all: '',
				size: 10,
				total: '',
				value: '',
			}
		},
		watch: {
			active_name() {
				if (this.active_name == 'one') {
					this.is_two = 0
				}
				if (this.active_name == 'two') {
					this.is_two = 1
				}
			}
		},
		components: {
			Nav
		},
		mounted() {
			console.log(this.$route.query.id)
			this.get_one_mj(this.$route.query.id)
			
			// const site = JSON.parse(localStorage.getItem("edit_data"));
			// if (site) {
			// 	console.log(site)
			// 	this.form.id = site.id
			// 	this.form.name = site.name
			// 	this.form.start_time = site.start_time
			// 	this.form.end_time = site.end_time
			// 	this.form.label = site.label
			// 	this.discount_list = site.discount_goods
			// 	this.form.buy_rule = site.buy_rule
			// 	this.form.buy_num = site.buy_num
			// 	this.form.full = site.full
			// 	this.form.reduce = site.reduce
			// }
			this._load()
			// this.goods_json();
		},
		methods: {
			_load() {
				proModel.get_all_no_mj_pro().then(res => {
					for (let k in res.data) {
						let v = res.data[k]
						v.is_discount = 1
					}
					this.all = res.data
					this.total = res.data.length
					this.tableData = res.data.slice(0,this.size)
					console.log(this.tableData)
				})
			},
			jump_page(e) {
				console.log(e)
				const that = this;
				let start = (e - 1) * that.size;
				let end = e * that.size;
				console.log(start, end)
				this.tableData = this.all.slice(start, end);
			},
			//添加为折扣商品
			add_discout(id, index, item) {
				let obj = {
					goods_id: id,
					discount_type: 1,
					reduce_price: '',
					discount_price: 0
				}
				let obj_2 = {
					img_id: item.img_id,
					goods_id: item.goods_id,
					goods_name:item.goods_name,
					price:item.price,
					goods: {
						goods_name: item.goods_name,
						price: item.price
					},
					reduce_price: '',
					discount_type: 1,
					discount_price: 0
				}
				this.tableData[index].is_discount = 2
				this.form.goods_json.push(obj)
				this.discount_list.push(obj_2)
				console.log(this.form)
				console.log(this.discount_list)
			},
			//取消折扣
			del(index) {
				this.tableData[index].is_discount = 1
				this.form.goods_json.splice(index, 1)
				this.discount_list.splice(index, 1)
				console.log(this.form)
			},
			//删除已选中折扣商品列表中商品
			del_disgoods(index) {
				this.discount_list.splice(index, 1)
			},
			get_one_mj(e) {
				extendModel.get_one_mj(e).then(res=>{
					this.discount_list = res.data.goods
					let data = res.data.reduction
					this.form = {
						id:data.id,
						name:data.name,
						start_time:data.start_time,
						end_time:data.end_time,
						full:data.full,
						reduce:data.reduce,
						goods_json:[]
					}
				})
			},
			next() {
				this.active_name = 'two'
				this.is_two = 1
			},
			back() {
				this.is_two = 0
				this.active_name = 'one'
			},
			onSubmit() {
				const that = this
				let arr = []
				let obj = {
					goods_id: '',
					discount_type: '',
					reduce_price: '',
					discount_price: ''
				}
				// this.form.goods_json = this.discount_list
				for (let k in this.discount_list) {
					let v = this.discount_list[k]
					obj.goods_id = v.goods_id
					obj.discount_type = v.discount_type
					obj.reduce_price = v.reduce_price
					obj.discount_price = v.discount_price
					arr.push(obj.goods_id)
					obj = {
						goods_id: '',
						discount_type: '',
						reduce_price: '',
						discount_price: ''
					}
				}
				this.form.goods_json = arr
				console.log(this.form)
				this.http.post_show('reduction/admin/edit_reduction', this.form).then(res => {
					console.log(res)
					if (res.status == 400) {
						that.$message({
							showClose: true,
							message: res.msg,
							type: 'success'
						});
					} else {
						that.$message({
							showClose: true,
							message: '修改成功',
							type: 'success'
						});
					}

					this.jumpback()
				})
			},
			add_user() {
				this.dialogVisibleadd = true
			},

			edit(id, goods_name, content, img_id, stock, points) {
				this.form.id = id
				this.form.goods_name = goods_name
				this.form.content = content
				this.form.img_id = img_id
				this.form.stock = stock
				this.form.points = points
				console.log(this.form)
			},
			jumpback() {
				this.$router.push({
					path: './discount'
				})
			},
			//获取商品列表
			goods_json() {},

		},

	}
</script>

<style lang="less">
	.adddiscount {

		.el-table__row {
			line-height: 40px !important;

			img {
				width: 80px !important;
				height: 80px !important;
			}
		}

		.search {
			text-align: left;
			border-bottom: 1px solid #E6E6E6;
			padding-bottom: 15px
		}

		.xiao {
			padding: 10px 10px 15px 15px;
			text-align: left;
			font-size: 15px;
			font-weight: 600;
		}

		.quan {
			display: flex;
			justify-content: space-between;
			padding: 15px 10px;

			.quan_r {
				font-size: 13px;
			}
		}

		.pro {
			display: flex;

			.pro_01 {
				padding-right: 10px;
				display: flex;
				flex-direction: column;
				justify-content: center;
			}

			.pro_02 img {
				height: 60px !important;
				;
				width: 60px !important;
				padding-right: 10px
			}

			.pro_03 {
				display: flex;
				flex-direction: column;
				justify-content: space-between;

				.pro_03_1 {
					color: #2768D7
				}

				.pro_03_2 {
					color: #FF6600
				}
			}
		}

		.tableRowClassName {
			background-color: #f0f0f0;
		}

		.add {
			background-color: #fff;margin-top: 10px;
			padding: 25px;

			.add_btn {
				padding: 5px 0 20px 0px;
				text-align: left;
			}

			.dan {
				padding-left: 10px
			}

			.ts {
				text-align: left;
				font-size: 12px;
				color: #A6A7A8;
				padding-left: 130px;
				margin-top: -18px;
				padding-bottom: 18px;
			}

			.jian {
				padding-right: 10px
			}

			.line {
				padding: 0 15px;
			}

			.xzsp {
				color: #155BD4;
				text-align: left;
				padding: 0 0 15px 130px;
				margin-top: -20px;
				font-size: 14px;
			}

			.spxz {
				padding: 0 0 25px 130px;
				width: 40%;

				.shiyong {
					display: flex;

					.sy_01 img {
						height: 40px !important;
						;
						width: 40px !important;
						padding-right: 10px
					}

					.sy_02 {
						display: flex;
						flex-direction: column;
						justify-content: space-between;

						.sy_01_1 {
							color: #2768D7
						}

						.sy_01_2 {
							color: #FF6600
						}
					}
				}
			}
		}

		.article {
			line-height: 30px;
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
