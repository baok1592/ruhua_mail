<template>
	<div class="root">
		<el-container>
			<el-aside width="160px" class="not-print bg-white erbian">
				<!-- <Nav ac="6"></Nav> -->
				<Nav ac="6"></Nav>
			</el-aside>
			<el-main style="background-color: #F3F3F3;">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>扫码点餐</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10">
					<!-- 添加桌号 -->
					<el-dialog title="" :visible.sync="dialogFormVisible" width="45%" center>
						<el-form :model="form">
							<el-form-item label="桌号" :label-width="formLabelWidth">
								<el-input v-model="form.zh_num" auto-complete="off"></el-input>
							</el-form-item>
							<el-form-item label="备注" :label-width="formLabelWidth">
								<el-input v-model="form.bz" auto-complete="off"></el-input>
							</el-form-item>
						</el-form>
						<div slot="footer" class="dialog-footer">
							<el-button type="primary" @click="sub">立即创建</el-button>
							<!-- <el-button v-else type="success" @click="subEdit">提交修改</el-button> -->
						</div>
					</el-dialog>
				</div>
				<el-button type="primary" size='small' @click="create_ad" style="float: left; margin: 30px 20px;">添加桌号</el-button>
				<div class="zhang">
					<el-table :data="tableData" border style="width: 100%;">
						<el-table-column type="index" label="序号" width="100">
						</el-table-column>
						<el-table-column prop="zh_num" label="桌号" width="200">
							<template slot-scope="scope">
								<el-input v-model="scope.row.zh_num"></el-input>
							</template>
						</el-table-column>
						<el-table-column prop="bz" label="备注" width="320">
							<template slot-scope="scope">
								<el-input v-model="scope.row.bz"></el-input>
							</template>
						</el-table-column>
						<el-table-column prop="operation" label="操作">
							<template slot-scope="scope">
								<el-button type="danger" size="small" @click="del(scope.row.id)">删除</el-button>
								<el-button type="primary" size="small" @click="on_edit(scope.row)">修改</el-button>
								<el-button type="primary" size="small" @click="qrcode(scope.row.zh_num)">生成二维码</el-button>
							</template>
						</el-table-column>
					</el-table>
				</div>
				
			</el-main>
			<el-dialog title="扫码点餐" :visible.sync="dialogVisible" width="30%">
				<div style="display: flex;">
					<div class="qrcode" id="qrcode" ref="qrcode"></div>
					<!-- <el-image title="H5专用码" :src="img.h5_img" style="width: 200px;height: 200px;"></el-image> -->
					<el-image title="小程序专用码" :src="img.xcx_img" style="width: 200px;height: 200px;margin: 10px;"></el-image>
				</div>
				<span slot="footer" class="dialog-footer">
					<!-- <el-button @click="dialogVisible = false">取 消</el-button> -->
					<el-button type="primary" @click="dialogVisible = false">确 定</el-button>
				</span>
			</el-dialog>
		</el-container>
	</div>
</template>

<script>
	import Nav from './components/extend_nav.vue';
	import QRCode from "qrcodejs2";
	import {
		Api_url
	} from '@/common/config';

	export default {
		data() {
			return {
				tableData: [],
				dialogFormVisible: false,
				form: {},
				formLabelWidth: '100px',
				img: {},
				// 控制二维码弹框
				dialogVisible: false,
				
			};
		},
		watch:{
			//关闭弹窗时清除已生成的二维码
			dialogVisible(n){
				if(!n){
					 this.$refs.qrcode.innerHTML = ''
				}
			}
		},
		components: {
			Nav
		},
		mounted() {
			this.get_all_zz();
		},
		methods: {
			async qrcode(table_num) {
				await this.http.get('order/admin/code_order?type=code_order&id='+table_num).then(res=>{
					setTimeout(()=>{
						let qrcode = new QRCode('qrcode', {
							width: 170,
							height: 170, // 高度
							colorLight: "#ffffff",
							colorDark: '#000000',
							correctLevel: QRCode.CorrectLevel.H,
							text: Api_url+'h5/#/pages/index/index?type=code_order&table_num='+ table_num// 二维码内容（接口返回的数字或者什么，如：需要扫码跳转的链接）
						});
					},200)
					this.img.xcx_img = res.data.xcx_img
					this.dialogVisible = true
				})
				
				
			},
			get_all_zz() {
				this.http.get('index/admin/get_all_zz').then(res => {
					this.tableData = res.data
				})
			},
			create_ad() {
				this.dialogFormVisible = true;
			},
			sub() {
				this.http.post_show('index/admin/add_zz', this.form).then(res => {
					this.$message({
						showClose: true,
						message: '添加成功',
						type: 'success'
					});
					this.dialogFormVisible = false;
					this.form = {}
					this.get_all_zz()
				})
			},
			del(id) {
				this.http.Del('index/admin/del_zz?id=' + id).then(res => {
					this.$message({
						showClose: true,
						message: '更新成功',
						type: 'success'
					});
					this.get_all_zz()
				})
			},
			on_edit(data) {
				this.http.post_show('index/admin/edit_zz', data).then(res => {
					this.$message({
						showClose: true,
						message: '更新成功',
						type: 'success'
					});
					this.get_all_zz()
				})
			},
			scewm(id) {
				const _this = this;
				this.http.get('order/admin/code_order?id=' + id).then(res => {
					this.img = res.data
					// window.open(this.img)
					_this.dialogVisible = true;
				})
			}
		}
	}
</script>

<style lang="less" scoped="">
	.qrcode{
		margin: 10px;
		display: inline-block;
		img{
			padding: 6px;
			box-sizing: border-box;
		}
	}
	.article {
		line-height: 30px;
		background-color: #fff;
		padding: 15px;
		text-align: left;
	}

	.list-head {
		padding-bottom: 10px;
	}
</style>
