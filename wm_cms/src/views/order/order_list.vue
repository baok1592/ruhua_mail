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
									<el-row>
										<el-col :span="4">
											<div><span class="cu">订单号：</span>{{item.order_num}}</div>
										</el-col>
										<el-col :span="5">
											<div><span class="cu">日期：</span>{{item.created_at}}</div>
										</el-col>
										<el-col :span="6">
											<div><span class="cu">折扣： </span>满减折扣：{{item.reduction_money}} 优惠卷折扣：{{item.coupon_money}}</div>
										</el-col>
										<el-col :span="4">
											<div><span class="cu">应付金额：</span>{{item.order_money}}</div>
										</el-col>
										<el-col :span="3">
											<div>
												<el-button style="margin-left: 10px" type="danger" size="small" slot="reference" @click="del(item.order_id)">删除</el-button>
												<!-- <el-button style="margin-left: 10px" type="success" size="small">详情</el-button> -->
											</div>
										</el-col>
									</el-row>
									<el-row style="margin-top: 10px;">
										<el-col :span="4">
											<div><span class="cu">地址：</span>{{item.receiver_city+item.receiver_address}}</div>
										</el-col>
										<el-col :span="5">
											<div>
												<span class="cu">支付状态：</span>
												<el-button size="mini" type="primary" v-if="item.payment_state == 1" :disabled="true">已支付</el-button>
												<el-button size="mini" v-else type="warning" @click="zf(item.order_id)">待支付</el-button>
											</div>
										</el-col>
										<el-col :span="6">
											<div v-if="item.payment_state == 1">
												<span class="cu">配送状态：</span>
												<el-button size="mini" type="primary" v-if="item.shipment_state == 0" @click="send(item.order_id)">配送</el-button>
												<el-button size="mini" v-else-if="item.shipment_state == 1" :disabled="true">已配送</el-button>
												<el-button size="mini" v-else :disabled="true">已完成</el-button>
											</div>
										</el-col>
										<el-col :span="4">
											<div>
												<span class="cu">订单状态：</span>
												<el-button size="mini" type="primary" v-if="item.state == 0" :disabled="true">未完成</el-button>
												<el-button size="mini" v-else-if="item.state == 1" :disabled="true">已完成</el-button>
												<el-button size="mini" v-else-if="item.state == 2" :disabled="true">已评价</el-button>
												<el-button size="mini" v-else-if="item.state == -1" :disabled="true">退款中</el-button>
												<el-button size="mini" v-else-if="item.state == -2" :disabled="true">已退款</el-button>
												<el-button size="mini" v-else-if="item.state == -3" :disabled="true">关闭订单</el-button>
											</div>
										</el-col>
										<el-col :span="3">
											<div>
												<el-button style="margin-left: 10px" v-if="item.state==0" type="primary" size="small" slot="reference"
												 @click="qrysd(item.order_id)">确认已送达</el-button>
												<el-button type="text" v-else>已收到</el-button>
											</div>
										</el-col>
									</el-row>

								</div>
								<div class="order-01-2">
									<div class="order-01-2-01" v-for="(ite,index) of item.ordergoods" :key="index">
										<img v-if="!ite.pic" src="@/img/1.jpg" />
										<img style="width: 6.5rem; height: 6.5rem;" v-else :src="geting+ite.pic" />
										<div class="order-01-2-01-name">{{ite.goods_name}}</div>
										x{{ite.number}}
									</div>
								</div>
							</div>
							<div class="BH10"></div>
						</div>

					</div>
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
				list: [],
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
				this.http.put_show('order/user/receive?id=' + id).then(res => {
					if(res.status==200){
						this.$message({
							type: 'success',
							message: '已收到'
						});
						this.get_all_order();
					}else{
						this.$message({
							type: 'waring',
							message: res.msg
						});
					}
				
				})
			},
			get_all_order() {
				orderModel.get_all_order().then(res => {
					this.list = res.data
					this.show_list = res.data
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
