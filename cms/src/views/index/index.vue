<template>
	<div class="bg-main">
		<el-main style="">

			<el-row :gutter="20">
				<template v-for="(item,index) of message">
					<el-col :span="6">
						<div class="tishi">
							<div class="ts_01">
								<div class="ts_01_l">{{item.types}}</div>
								<div :class="item.state?'ts_01_r':'ts_01_m'">{{item.wen}}</div>
							</div>
							<div class="ts_02">
								<div class="ts_02_l">
									<span>{{item.num}}</span><br />
									{{item.mess}}
								</div>
								
							</div>
						</div>
					</el-col>
				</template>
			</el-row>
			<el-row style="background-color: #FFFFFF;">
				<el-row
					style="display: flex;justify-content: flex-start; padding: 10px; height: 70px;line-height: 50px;">
					<span>按月查询：</span>
					<el-date-picker v-model="value2" type="month" placeholder="选择月" format="yyyy年MM月"
						value-format="timestamp" @change="get_month(value2)">
					</el-date-picker>
				</el-row>
				<ve-line :data="chartData" :settings="chartSettings"></ve-line>
			</el-row>
		</el-main>
	</div>
</template>

<script>
	export default {
		name: "index",
		data() {

			this.chartSettings = {
				xAxisType: 'time',
				labelMap: {
					'day': '日期',
					'order_num': '用户数',
					'user_num': '月销量'
				},
				legendName: {
					'访问用户': '访问用户 total: 10000'
				}
			}
			return {
				value2: '',
				tableData: [],
				userList: '',
				points_rank: '',
				chartData: {
					columns: ['day', 'order_num', 'user_num'],
					rows: []
				},
				message: [{
						"types": '订单总数',
						"num": 0,
						"mess": "订单总数",
						"state": 1,
						"wen": "总",
						"duibi": 0,
						"fudu": 0
					},
					{
						"types": '总金额',
						"num": 0,
						"mess": "总金额",
						"state": 0,
						"wen": "总",
						"duibi": 0,
						"fudu": 0
					},
					{
						"types": '商品总数',
						"num": 0,
						"mess": "商品总数",
						"state": 1,
						"wen": "总",
						"duibi": 0,
						"fudu": 1
					},
					{
						"types": '用户总数',
						"num": 0,
						"mess": "用户总数",
						"state": 1,
						"wen": "总",
						"duibi": 0,
						"fudu": 0
					}
				]
			}
		},
		mounted() {
			this.check_login()
			
		},
		methods: {

			get_home_data() {
				this.http.get_show('statistic/admin/get_index_data').then(res => {
					console.log(res)
					this.message[0].num = res.data.total_order
					this.message[1].num = res.data.total_money
					this.message[2].num = res.data.total_goods
					this.message[3].num = res.data.today_user
					this.message[4].num = res.data.yesterday_order + '/' + res.data.yesterday_money
					this.message[5].num = res.data.month_order + '/' + res.data.month_money
					this.message[6].num = res.data.today_user
					this.message[7].num = res.data.month_user
				})
			},
			get_data() {
				this.http.post_show('statistic/admin/get_table').then(res => {
					this.chartData.rows = res.data
				})
			},
			get_month(month) {
				this.http.post('statistic/admin/get_table', {
					month: month / 1000
				}).then(res => {
					this.chartData.rows = res.data
				})
				console.log(month)
			},
			get_points_rank() {
				
			},
			async check_login() {
				let token = localStorage.getItem('shops_pc_token')
				if (!token) {
					this.$router.push('/login')
				} else {
					this.http.get('index/verify_token').then(res => {
						console.log(res)
						if (res.status != 200) {
							localStorage.clear()
							this.$router.push('/login')
						} else {
							this.get_home_data()
							this.get_all_city()
							this.get_points_rank()
							this.get_data()
						}
					})
				}
			},
			get_all_city() {
				
			},

			handleOpen(key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose(key, keyPath) {
				console.log(key, keyPath);
			},
		}
	};
</script>

<style lang="less">
	.bg-main {
		background-color: #F5F7F9;
		margin: 0px;
		padding: 20px;

		.tishi {
			line-height: 20px;
			margin-bottom: 15px;
			background-color: #fff;
			text-align: left;
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
	}
</style>
