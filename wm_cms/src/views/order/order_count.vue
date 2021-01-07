<template>
	<div class="order_count">
		<el-container class="container">
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="3"></Nav>
			</el-aside>
			<el-main class="main">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>订单</el-breadcrumb-item>
					<el-breadcrumb-item>订单列表</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="">
					<el-row>
						<el-col style="display: flex;justify-content: flex-start;margin-bottom: 10px;">
							<el-button plain :autofocus="show_default" @click="reset">1000条数据</el-button>
							<el-button plain>所有数据</el-button>
							<el-button plain @click="get_excel">导出</el-button>
							<el-button plain @click="reset">刷新</el-button>
						</el-col>
					</el-row>
					<el-collapse v-if="!detail_show" v-model="activeNames" style="padding:25px;background-color: #fff;margin-bottom:15px;" >
						<el-collapse-item title="订单搜索" name="1">
							<div class="search">
								<div class="sea_02">
					
									<!-- 条件搜索 -->
									<div class="sea_02_01">
										<div class="sea_02_01_l">订单号：</div>
										<div class="sea_02_01_r">
											<el-input v-model="search_form.num" placeholder="请输入订单号"></el-input>
										</div>
										<div class="sea_02_01_l">用户名：</div>
										<div class="sea_02_01_r">
											<el-input v-model="search_form.user_name" placeholder="请输入用户名全称"></el-input>
										</div>
										<div class="sea_02_01_l">商品名：</div>
										<div class="sea_02_01_r">
											<el-input v-model="search_form.pro_name" placeholder="请输入商品名"></el-input>
											<el-button size="small" style="margin-left: 10px;" type="success" @click="search('goods_name')">搜索</el-button>
										</div>
									</div>
									<div class="sea_02_01">
										<div class="sea_02_01_l">创建时间：</div>
										<div class="sea_02_01_r">
											<el-button type="primary" plain @click="reset">全部</el-button>
											<template v-for="item of time">
												<el-button type="primary" plain size="mini" @click="choose_time(item.value)">{{item.ti}}</el-button>
											</template>
										</div>
									</div>
					
									<!-- 条件搜索结束 -->
									<!-- <div class="sea_02_01">
										<div class="sea_02_01_l">搜索：</div>
										<div class="sea_02_02_r">
											<div class="sea_02_02_r_1">
												<el-input placeholder="请输入用户名、商品名或订单编号" v-model="input" style="" clearable></el-input>
												<el-button size="small" style="margin-left: 10px;" type="success" @click="search(input)">搜索</el-button>
											</div>
										</div>
									</div> -->
								</div>
					
							</div>
							<el-row :gutter="20" >
								<template v-for="(item,index) of message">
									<el-col :span="6">
										<div class="tishi" style="border: 1px solid #DADADA;border-radius: 5px;">
											<div class="ts_01">
												<div class="ts_01_l">{{item.types}}</div>
												<div class="ts_01_m">{{item.wen}}</div>
											</div>
											<div class="ts_02">
												<div class="ts_02_l">
													<span>{{item.num}}</span>
												</div>
											</div>
										</div>
									</el-col>
								</template>
							</el-row>
						</el-collapse-item>
					</el-collapse>
				</div>
			</el-main>
		</el-container>
	</div>
</template>

<script>
	import Nav from './components/order_nav.vue'
	export default {
		components: {
			Nav
		},
		data() {
			return {
				detail_show:false,
				activeNames: '1',
				show_default: true,
				search_form: {
					user_name: '',
					pro_name: '',
					num: ''
				},
				time: [{
					"ti": "昨天",
					value: '0'
				}, {
					"ti": "今天",
					value: '1'
				}, {
					"ti": "本周",
					value: '2'
				}, {
					"ti": "本月",
					value: '3'
				}, {
					"ti": "本季度",
					value: '4'
				}, {
					"ti": "今年",
					value: '5'
				}],
				message: [{
						"types": '订单',
						"num": 0,
						"mess": "待发货",
						"state": 1,
						"wen": "急",
						"duibi": 0,
						"fudu": 0
					},
					{
						"types": '订单',
						"num": 0,
						"mess": "退换货",
						"state": 0,
						"wen": "待",
						"duibi": 0,
						"fudu": 0
					},
					{
						"types": '商品',
						"num": 0,
						"mess": "库存预警",
						"state": 1,
						"wen": "急",
						"duibi": 0,
						"fudu": 1
					},
					{
						"types": '待提现',
						"num": 0,
						"mess": "待提现",
						"state": 1,
						"wen": "待",
						"duibi": 0,
						"fudu": 0
					},
					{
						"types": '订单',
						"num": 2,
						"mess": "昨日订单数",
						"state": 0,
						"wen": "昨",
						"duibi": 1,
						"fudu": 1
					},
					{
						"types": '交易',
						"num": 2,
						"mess": "昨日订单数",
						"state": 0,
						"wen": "昨",
						"duibi": 1,
						"fudu": 0
					},
					{
						"types": '粉丝',
						"num": 20,
						"mess": "今日新增粉丝",
						"state": 0,
						"wen": "今",
						"duibi": 1,
						"fudu": 1
					},
					{
						"types": '粉丝',
						"num": 27,
						"mess": "本月新增粉丝",
						"state": 0,
						"wen": "月",
						"duibi": 1,
						"fudu": 0
					}
				],
			}
		},
		methods: {
			reset() {
				this.get_all_order()
				this.fy_show = 1
				this.list = this.all.slice(0, this.size)
			
			},
			//导出数据
			get_excel() {
				const aLink = document.createElement('a');
				let token = localStorage.getItem('token');
				aLink.href = Api_url + 'index/export_excl?token=' + token
				aLink.target = '_blank'
				aLink.download = 'ly_2019.csv';
				aLink.click();
				aLink.remove();
			},
			choose_time(value) {
				const that = this
				this.reset_key = 0
				let arr = []
			
				if (value == 0) {
					for (let k in this.all) {
						let t = this.all[k]
						let T = new Date(t.pay_time).getTime()
						console.log(T)
						console.log(this.yestoday_start)
						console.log(this.yestoday_end)
						if (this.yestoday_start < T && T < this.yestoday_end) {
							arr.push(t)
						}
					}
					this.list = arr.slice(0, that.size);
					this.total = arr.length
					console.log(arr)
					return
				}
				if (value == 1) {
			
					for (let k in this.all) {
						let t = this.all[k]
						let T = new Date(t.create_time).getTime()
						if (this.day_start < T && T < this.day_end) {
							arr.push(t)
						}
					}
					this.list = arr.slice(0, that.size);
					this.total = arr.length
					console.log(arr)
					return
				}
				if (value == 2) {
					for (let k in this.all) {
						let t = this.all[k]
						let T = new Date(t.create_time).getTime()
			
						if (this.week_start < T && T < this.week_end) {
							arr.push(t)
						}
					}
					this.list = arr.slice(0, that.size);
					this.total = arr.length
					console.log(arr)
					return
				}
				if (value == 3) {
			
					for (let k in this.all) {
						let t = this.all[k]
						let T = new Date(t.create_time).getTime()
						if (this.month_start < T && T < this.month_end) {
							arr.push(t)
						}
					}
					this.list = arr.slice(0, that.size);
					this.total = arr.length
					console.log(arr)
					return
				}
				if (value == 4) {
			
					for (let k in this.all) {
						let t = this.all[k]
						let T = new Date(t.create_time).getTime()
						if (this.Quarter_start < T && T < this.Quarter_end) {
							arr.push(t)
						}
					}
					this.list = arr.slice(0, that.size);
					this.total = arr.length
					console.log(arr)
					return
				}
				if (value == 5) {
					for (let k in this.all) {
						let t = this.all[k]
						let T = new Date(t.create_time).getTime()
						if (this.now_year_firstDay < T && T < this.now_year_lastDay) {
							arr.push(t)
						}
					}
					this.list = arr.slice(0, that.size);
					this.total = arr.length
					console.log(arr)
					return
			
				}
			
			},
			get_all_order(){
				
			}
		}
	}
</script>

<style lang="less">
	.search {
		line-height: 20px;
		margin-bottom: 15px;
		background-color: #fff;
		// text-align: left;
		color: #6B6B6B;
		font-size: 14px;
	
		.sea_01 {
			border-bottom: 1px solid #F0F0F0;
			padding: 10px;
		}
	
		.sea_02 {
			padding: 10px 15px;
			font-size: 12px;
	
			.sea_02_01 {
				display: flex;
				line-height: 30px;
				margin-bottom: 15px;
	
				.sea_02_01_l {
					width: 100px;
				}
	
				.sea_02_01_r {
					display: flex;
	
					.sea_02_01_r_1 {
						background-color: #008DE1;
						color: #fff;
						padding: 0 10px;
						margin-right: 10px;
						border-radius: 3px;
					}
	
					.sea_02_01_r_2 {
						border: 1px solid #EFEFEF;
						margin-right: 10px;
						padding: 0 10px;
	
						.grey {
							background-color: #EEEEEE;
							padding: 3px 6px;
							border-radius: 3px;
						}
	
						.orange {
							background-color: #FF551D;
							padding: 3px 5px;
							color: #fff;
							border-radius: 3px;
						}
					}
				}
	
				.sea_02_02_r {
					.sea_02_02_r_1 {
						display: flex;
						margin-bottom: 15px;
						width: 600px;
					}
	
					.sea_02_02_r_2 {
						display: flex;
	
						.sea_02_02_r_2_1 {
							background-color: #008DE1;
							color: #fff;
							padding: 0 10px;
							margin-right: 10px;
							border-radius: 3px;
						}
	
						.sea_02_02_r_2_2 {
							padding: 0 10px;
							margin-right: 10px;
							border-radius: 3px;
							border: 1px solid #EFEFEF;
						}
					}
				}
			}
		}
	}
	
	.tishi {
		line-height: 20px;
		margin-bottom: 15px;
		background-color: #fff;
		// text-align: left;
		color: #6B6B6B;
		font-size: 14px;
	
		.ts_01 {
			display: flex;
			justify-content: space-between;
			border-bottom: 1px solid #F0F0F0;
			padding: 10px;
	
			.ts_01_l {
				font-weight: 600;
			}
	
			.ts_01_r {
				background-color: #F54864;
				color: #fff;
				font-size: 12px;
				padding: 0px 10px;
				border-radius: 3px
			}
	
			.ts_01_m {
				background-color: #0392E4;
				color: #fff;
				font-size: 12px;
				padding: 0px 10px;
				border-radius: 3px
			}
		}
	
		.ts_02 {
			padding: 20px 15px;
			font-size: 13px;
			display: flex;
			justify-content: space-between;
	
			.ts_02_l {
				span {
					font-size: 28px;
				}
			}
	
			.ts_02_r {
				color: #0092E5;
				padding-top: 25px;
			}
		}
	}
</style>
