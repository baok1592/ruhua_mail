<template>
	<div class="addcoupon">
		<el-container>
			<el-aside width="160px" class="not-print bg-white erbian"><Nav ac="1"></Nav></el-aside>

			<el-main>
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>应用</el-breadcrumb-item>
					<el-breadcrumb-item>优惠券</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="add">
					<div class="add_btn"><el-button type="primary" size="small" @click="jumpback">返回</el-button></div>
					<el-form ref="form" :model="form" label-width="120px" class="demo-dynamic">
						<el-form-item label="优惠券名称"><el-input v-model="form.name" hide-required-asterisk style="width:500px"></el-input></el-form-item>
						<el-form-item label="发放总量">
							<el-input v-model="form.stock" style="width:200px"></el-input>
							<div class="dan">张</div>
						</el-form-item>

						<div class="ts">修改优惠券总量时只能增加不能减少，请谨慎设置</div>
						<el-form-item label="使用门槛">
							订单满&emsp;
							<el-input v-model="form.full" style="width:100px"></el-input>
							&emsp;元
						</el-form-item>
						<el-form-item label="优惠价格">
							<div class="jian">减免</div>
							<el-input v-model="form.reduce" style="width:100px"></el-input>
							<div class="dan">元</div>
						</el-form-item>
						<el-form-item label="用券时间">
							<el-radio-group v-model="time" style="text-align: left;" @change="time_type_change">
								<el-radio :label="1">
									<el-date-picker type="date" placeholder="选择日期" v-model="start_time" style="width: 200px;" value-format="yyyy-MM-dd"></el-date-picker>
									&emsp;-&emsp;
									<el-date-picker type="date" placeholder="选择日期" v-model="end_time" style="width: 200px;" value-format="yyyy-MM-dd"></el-date-picker>
								</el-radio>
								<br />
								<div style="height: 23px"></div>
								<el-radio :label="2">
									领券当日起&emsp;
									<el-input v-model="form.day" style="width:100px"></el-input>
									&emsp;天内可用
								</el-radio>
							</el-radio-group>
						</el-form-item>
						<el-form-item label="使用次数" prop="resource">
							<el-radio-group v-model="form.status" style="margin-top: 15px;">
								<el-radio label="1">有限</el-radio>
								<el-radio label="2">无限</el-radio>
							</el-radio-group>
						</el-form-item>
					</el-form>
					<span slot="footer" class="dialog-footer ">
						<el-button @click="jumpback" size="small">取 消</el-button>
						<el-button type="primary" @click="onSubmit" size="small">确 定</el-button>
					</span>
				</div>
			</el-main>
		</el-container>
	</div>
</template>

<script>
import extendModel from '../../model/extend.js';
import { Loading } from 'element-ui';
import { Api_url } from '@/common/config';

import Nav from './components/extend_nav.vue';
export default {
	data() {
		return {
			time_type: '',
			show_ininput: 0,
			menkan: '',
			canjia_list: [],
			is_all: '',
			top: '0',
			activeNames: ['1'],
			tableRowClassName: '',
			tableData: [],
			dialogVisibleadd: false,
			start_time: '',
			end_time: '',
			time: '',
			form: {
				stock: '',
				name: '',
				full: '',
				reduce: '',
				day: '',
				status: '',
				stock_type: '',
				start_time: '',
				end_time: ''
			}
		};
	},
	components: {
		Nav
	},
	methods: {
		time_type_change(e) {
			console.log(e);
			this.time_type = e;
		},
		handleChange(val) {
			console.log(val);
		},
		get_value(e) {
			console.log(e);
			let a = [];
			if (e == 0) {
				a.push(e);
			}
			this.form.goods_ids = a;
		},
		//添加优惠券
		onSubmit() {
			if (this.time_type == 1) {
				this.form['start_time'] = this.start_time;
				this.form['end_time'] = this.end_time;
				this.form.day = '';
			}
			if (this.time_type == 2) {
				if (this.form.day == '') {
					this.$message({
						type: 'warning',
						message: '未填写天数!'
					});
					return;
				}
			}
			if (this.time_type == 1) {
				if (this.form.start_time == '' || this.form.end_time == '') {
					this.$message({
						type: 'warning',
						message: '未填写起止日期'
					});
					return;
				}
			}
			if (!this.form.stock) {
				this.form.stock_type = '0';
			} else {
				this.form.stock_type = '1';
			}
			console.log(this.form);
			extendModel.add_coupon(this.form).then(() => {
				this.$message({
					type: 'success',
					message: '添加成功!'
				});
				this.form = {};
				this.dialogVisibleadd = false;
				this.$router.push({
					path: '/extend/coupon'
				});
			});
		},
		//返回
		jumpback() {
			this.$router.push({
				path: '/extend/coupon'
			});
		}
	},
	mounted() {
		// this.get_pro()
	}
};
</script>

<style lang="less">
.addcoupon {
	.el-table__row {
		line-height: 40px !important;

		img {
			width: 80px !important;
			height: 80px !important;
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
			width: 60px !important;
			padding-right: 10px;
		}

		.pro_03 {
			display: flex;
			flex-direction: column;
			justify-content: space-between;

			.pro_03_1 {
				color: #2768d7;
				text-overflow: -o-ellipsis-lastline;
				overflow: hidden;
				text-overflow: ellipsis;
				display: -webkit-box;
				-webkit-line-clamp: 2;
				-webkit-box-orient: vertical;
			}

			.pro_03_2 {
				color: #ff6600;
			}
		}
	}

	.tableRowClassName {
		background-color: #f0f0f0;
	}

	.add {
		background-color: #fff;
		margin-top: 10px;
		padding: 25px;

		.add_btn {
			padding: 5px 0 20px 0px;
			text-align: left;
		}

		.dan {
			padding-left: 10px;
		}

		.ts {
			text-align: left;
			font-size: 12px;
			color: #a6a7a8;
			padding-left: 130px;
			margin-top: -8px;
			padding-bottom: 18px;
		}

		.jian {
			padding-right: 10px;
		}

		.line {
			padding: 0 15px;
		}

		.xzsp {
			color: #155bd4;
			text-align: left;
			// padding: 0 0 15px 130px;
			margin-top: 10px;
			font-size: 14px;
		}

		.spxz {
			padding: 0 0 25px 130px;
			width: 40%;

			.shiyong {
				display: flex;

				.sy_01 img {
					height: 40px !important;
					width: 40px !important;
					padding-right: 10px;
				}

				.sy_02 {
					display: flex;
					flex-direction: column;
					justify-content: space-between;

					.sy_01_1 {
						color: #2768d7;
					}

					.sy_01_2 {
						color: #ff6600;
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
		padding-bottom: 10px;
	}

	.el-form-item__content {
		display: flex;
		justify-content: flex-start;
	}
}
</style>
