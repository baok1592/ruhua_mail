<template>
	<div id="detail_page">
		<el-main>
			<el-row style="text-align: left;">
				<el-button style="margin: 10px;" type="primary" size="mini" @click="back">返回</el-button>
			</el-row>
			<el-tabs v-model="activeName" type="card" @tab-click="handleClick">
				<el-tab-pane label="余额变更记录" name="first">
					<div class="log">
						<div class="log-01">余额变更记录</div>
						<div class="log-02">
							<ul>
								<li v-for="(item,index) of money_arr">
									[{{item.create_time}}]
									<b v-if="item.type_name == 'money'">余额：</b> 
									{{item.content}}
								</li>
							</ul>
						</div>
					</div>
				</el-tab-pane>
				<el-tab-pane label="积分变更记录" name="second">
					<div class="log">
						<div class="log-01">积分变更记录</div>
						<div class="log-02">
							<ul>
								<li v-for="(item,index) of point_arr">
									[{{item.create_time}}] 
									<b v-if="item.type_name == 'points'">积分：</b> 
									{{item.content}}
								</li>
							</ul>
						</div>
					</div>
				</el-tab-pane>
			</el-tabs>

			<div class="clear"></div>
		</el-main>

	</div>
</template>

<script>
	import UserModel from "../../model/user.js"
	export default {
		name: "Details",

		data() {
			return {
				money_arr:[],
				point_arr:[],
				activeName: 'first',
				log: [],
				details: [],
				list: [],
				mid: this.order_id,
				remark: false,
				form: {
					remark: "", //订单备注
					price: "", //调整的金额
					courier: "", //快递公司
					courier_num: "" //快递单号
				},
				form_price: false,
				form_shipping: false,
				formLabelWidth: "120px",
				kd_cmp: {}
			};
		},
		//vue生命函数
		mounted() {
			this.post_details(this.$route.query.id);
		},
		methods: {
			handleClick(tab, event) {
				console.log(tab, event);
			},
			//获取用户信息
			post_details(id) {
				UserModel.get_user_log(id).then(res => {
					this.log = res.data.log
					let money_arr = []
					let point_arr = []
					for (let k in this.log) {
						let v = this.log[k]
						if(v.type_name == 'money'){
							money_arr.push(v)
						}
						if(v.type_name == 'points'){
							point_arr.push(v)
						}
					}
					this.money_arr = money_arr
					this.point_arr = point_arr
					console.log(this.log)
				})
			},
			back() {
				this.$router.go(-1)
			}
		},

	};
</script>

<style lang="less">
	#detail_page {

		.el-input__inner {
			width: 100%;
		}

		background-color: #FFFFFF;

		.fl {
			float: left;
		}

		.fr {
			float: right;
		}

		.clear {
			clear: both;
		}

		.details {
			border: 1px solid #e0e0e0;
		}

		.details-l {
			border-right: 1px solid #f0f0f0;
			width: 20%;
			box-sizing: border-box;
			padding: 30px;
		}

		.details-l-01 {
			font-weight: bold;
			width: 100%;
			font-size: 14px;
		}

		.details-l-01 span {
			font-weight: 400;
			font-size: 10px;
			text-align: right;
			color: #ffa042;
		}

		.details-l-02 {
			font-size: 10px;
			color: #000000;
			line-height: 30px;
		}

		.details-l-02-l {
			display: inline-block;
			width: 30%;
			text-align: right;
			vertical-align: top;
		}

		.details-l-02-r {
			display: inline-block;
			width: 70%;
		}

		.details-r-01 {
			padding-bottom: 20px;
		}

		.details-r-01-r-01 {
			padding-bottom: 10px;
		}

		.details-r {
			width: 80%;
			box-sizing: border-box;
			padding: 30px;
		}

		.details-r-01-l {
			display: inline-block;
			vertical-align: top;
		}

		.details-r-01-r {
			display: inline-block;
			padding-left: 10px;
			font-size: 12px;
			line-height: 30px;
			padding-bottom: 10px;
		}

		.details-r-02 {
			padding-top: 15px;
			font-size: 14px;
		}

		.details-r-03 {
			text-align: right;
			height: 60px;
			line-height: 60px;
			font-size: 14px;
		}

		.details-r-03 span {
			color: red;
		}



		.log-01 {
			height: 40px;
			background-color: #f0f0f0;
			color: #000000;
			line-height: 40px;
			font-size: 12px;
			border-top: 1px solid #e0e0e0;
			border-bottom: 1px solid #e0e0e0;
			padding-left: 10px;
		}

		.log-02 {
			text-align: left;
			color: #8e8e8e;
			line-height: 40px;
			font-size: 12px;
			border-bottom: 1px solid #e0e0e0;
			padding-left: 10px;
		}

		.log-02 ul,
		.log-02 li {
			text-decoration: none;
			list-style: none;
		}

		.details-r-02 ul {
			border-bottom: 1px solid #e0e0e0;
			line-height: 50px;
		}

		.details-r-02 ul li {
			display: inline-block;
		}

		.order-list-info li {
			line-height: 28px;
		}

		.order-list-info li img {
			width: 70px;
			height: 70px;
			padding: 10px;
			vertical-align: middle;
		}
	}
</style>
