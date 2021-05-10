<template>
	<div class="">
		<el-container>
			<el-aside width="160px" class="not-print bg-white erbian">
				<NavTo ac="1"></NavTo>
			</el-aside>
			<transition appear appear-active-class="animated fadeInLeft">
				<el-main style="background-color: #FFFFFF;">
					<el-breadcrumb separator-class="el-icon-arrow-right">
						<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
						<el-breadcrumb-item>订单列表</el-breadcrumb-item>
					</el-breadcrumb>
					<div class="H10"></div>
					<!-- 搜索 -->
					<div class="search">
						<el-col :span="4" class="col">
							<span>支付状态</span>
							<el-select v-model="form.playstate" placeholder="支付状态">
								<el-option label="全部" value="-1"></el-option>
								<el-option label="已支付" value="1"></el-option>
								<el-option label="待支付" value="0"></el-option>
							</el-select>
						</el-col>
						
						<el-col :span="6" class="col col_center">
							<span>日期范围</span>
							<el-col :span="11">
								<el-date-picker type="date" placeholder="开始日期" v-model="form.starttime" style="width: 100%;" value-format="yyyy-MM-dd"></el-date-picker>
							</el-col>
							<el-col class="line" :span="2">-</el-col>
							<el-col :span="11">
								<el-date-picker type="date" placeholder="结束日期" v-model="form.endtime" style="width: 100%;" value-format="yyyy-MM-dd"></el-date-picker>
							</el-col>
						</el-col>
						
						<el-col :span="4" class="col">
							<span>关键词</span>
							<el-input v-model="form.wordkey" placeholder="输入 订单号 或 手机号"></el-input>
						</el-col>
						
						<el-col :span="1" class="col">
							<el-button size="mini" type="primary" @click="search">搜索</el-button>
						</el-col>
					</div>
					<!-- 搜索 end -->
					<div class="H10"></div>
					<div class="order">
						<div v-for="(item,index) of show_list" :key="index">
							<div class="order-01">
								<div>
									<el-row style="line-height: 32px;">
										<el-col :span="4">
											<div><span class="cu">订单号：</span>{{item.order_num}}</div>
										</el-col>
										<el-col :span="2">
											<div><span class="cu">折扣： </span>-{{item.reduction_money*1+item.coupon_money*1}}</div>
										</el-col>
										<el-col :span="3">
											<div><span class="cu">应付金额：</span>{{item.order_money}}</div>
										</el-col>
										<el-col :span="4" v-if="item.drive_type == '配送'">
											<div ><span class="cu">地址：</span>{{item.receiver_city+item.receiver_address}}</div>
											
										</el-col>
										<el-col :span="4"  v-if="item.drive_type == '店内就餐'">
											<div><span class="cu">桌号：</span>{{item.table_num}}号桌</div>
										</el-col>
										<el-col :span="5">
											<div><span class="cu">日期：</span>{{item.created_at}}</div>
										</el-col>
										
										
										
									</el-row>
									<el-row style="margin-top: 10px;line-height: 42px;">
										<el-col :span="2">
											<div>
												<!-- <span class="cu">支付状态：</span> -->
												
												<el-button size="mini" type="info" v-if="item.payment_state == 1" :disabled="true">已支付</el-button>
												<el-button size="mini" v-else type="info" @click="zf(item.order_id)">待支付</el-button>
											</div>
										</el-col>
										<el-col :span="2">
											<div v-if="item.payment_state == 1">
												<!-- <span class="cu">配送状态：</span> -->
												<el-button size="mini" type="info" v-if="item.shipment_state == 0" @click="send(item.order_id)">配送</el-button>
												<el-button size="mini" type="info" v-else-if="item.shipment_state == 1" :disabled="true">已配送</el-button>
												<el-button size="mini" type="info" v-else :disabled="true">已完成</el-button>
											</div>
										</el-col>
										
										<el-col :span="2">
											<div>
												<el-button style="margin-left: 10px" v-if="item.state==0 && item.shipment_state == 1" type="info" size="mini" slot="reference"
												 @click="qrysd(item.order_id)">确认已送达</el-button>
												<el-button  size="mini" type="info" v-if="item.state==1" :disabled="true">已收到</el-button>
											</div>
										</el-col>
										<el-col :span="2">
											<div>
												<el-button style="margin-left: 10px" type="info" size="mini" slot="reference" @click="print_tik(item.order_num)" v-if="item.payment_state == 1">打印小票</el-button>
											</div>
										</el-col>
										<el-col :span="1">
											<div>
												<el-button style="margin-left: 10px" type="danger" size="mini" slot="reference" @click="del(item.order_id)">删除</el-button>
												
											</div>
										</el-col>
										
									</el-row>

								</div>
								<div class="order-01-2">
									<div class="order-01-2-01" v-for="(ite,index) of item.ordergoods" :key="index">
										<img v-if="!ite.pic" src="@/img/1.jpg" />
										<img style="width: 6.5rem; height: 6.5rem;" v-else :src="geting+ite.pic" />
										<div class="order-01-2-01-name">{{ite.goods_name}}&nbsp;x{{ite.number}}</div>
										
									</div>
								</div>
							</div>
							<div class="BH10"></div>
						</div>

					</div>
					<el-pagination style='padding-top: 60px;text-align: center;' background layout="prev, pager, next" :total="total"
					 :page-size="size" @current-change="jump_page">
					</el-pagination>
				</el-main>
			</transition>
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
	import orderModel from "../../model/order.js"
	import searchModel from "../../model/search.js"
	import NavTo from './components/order_nav.vue'
	import Header from '@/components/header.vue'
	export default {

		data() {
			return {
				size:8,
				total:0,
				list: [],
				all:[],
				geting: this.$getimg,
				// 显示订单的列表
				show_list: [],
				test: '',
				form: {
					playstate: '',
					starttime: '',
					endtime: '',
					wordkey: '',
				}
			}
		},
		components: {
			Header,
			NavTo,
		},
		mounted() {
			this.get_all_order()
		},
		methods: {
			print_tik(order_num){
				this.http.get('cms/print_order?order_num='+order_num).then(res=>{
					this.$message({
						type: 'success',
						message: '打印中...'
					});
					setTimeout(()=>{
						this.$message({
							type: 'success',
							message: '打印成功'
						});
					},4000)
				})
			},
			jump_page(e) {
				const that = this;
				let start = (e - 1) * that.size;
				let end = e * that.size;
				console.log(start, end)
				this.show_list = this.all.slice(start, end);
			},
			//点击配送
			send(id) {
				const _this = this;
				this.$confirm('确认配送？', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.get('order/admin/edit_courier?id=' + id).then(res => {
						this.$message({
							type: 'success',
							message: '商品正在配送中'
						});
						_this.get_all_order()
					});
				})
			},
			zf(id) {
				const _this = this;
				this.$confirm('确认修改支付？', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.http.get('order/admin/edit_pay?id=' + id).then(res => {
						this.$message({
							type: 'success',
							message: '修改支付状态'
						});
						_this.get_all_order()
					});
				})
			},
			qrysd(id) {
				this.$confirm('确认已配送到收货地址？', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(()=>{
					this.http.put_show('order/user/receive?id=' + id).then(res => {
						this.$message({
							type: 'success',
							message: '确认收货成功'
						});
						this.get_all_order();
					})
				})
				
			},
			get_all_order() {
				orderModel.get_all_order().then(res => {
					this.all = res.data
					this.show_list = res.data.slice(0,this.size)
					this.total = res.data.length
				})
			},
			del(id) {
				const that = this
				this.$confirm('确定删除该订单', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					orderModel.del_order(id).then(res => {
						this.$message({
							type: 'success',
							message: '删除成功!'
						});
						that.get_all_order()
					})
				})
			},
			search() {
				const _this = this;
				let data = this.form;
				if(data.playstate == -1) {
					data.playstate = '';
				}
				// data.playstate = Number(data.playstate);
				searchModel.searchOrder(data).then(res => {
					_this.show_list = [];
					_this.show_list = res.data
				})
			}

		},



	}
</script>

<style lang="less">
	.search {
		display: flex;
		margin-top: 20px;
		margin-bottom: 20px;
		.col {
			display: flex;
			align-items: center;
			margin-right: 20px;
			&:last-child {
				margin-right: 0;
			}
			
			>span {
				display: inline-block;
				flex-shrink: 0;
				color: #777;
				margin-right: 10px;
				font-size: 0.9rem;
			}
		}
	}

	.order {
		text-align: left;
		// color: #6F6F6F;

		.order-01 {
			margin: 20px 0;
			padding-left: 15px;

			.order-01-2 {
				display: flex;
				padding: 25px 0 0 15px;
				flex-wrap: wrap;

				.order-01-2-01 {
					width: 150px;
					margin-right: 50px;
					margin-bottom: 20px;

					img {
						margin-bottom: 15px;
						width: 150px;
						height: 150px;
					}
				}

				.order-01-2-01-name {
					height: 25px;
					line-height: 25px;
					overflow: hidden;
					white-space: nowrap;
					text-overflow: ellipsis;
				}
			}
		}

		.BH10 {
			height: 10px;
			background-color: #F0F0F0;
		}

		.cu {
			// font-weight: 600;
			color: #777;
			font-size: 0.9rem;
		}
	}
</style>
