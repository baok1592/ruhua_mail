<!-- 修改地址未完善 -->


<template>
	<div class="root">
		<el-container>
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="5"></Nav>
			</el-aside>
			<el-main>
				<el-row style="text-align: left;margin-bottom: 10px;">
					<el-col :span="2">
						<el-button type="primary" size="small">返回</el-button>
					</el-col>
					<el-col :span="3">
						<el-select v-model="add_form.pid" placeholder="请选择地址等级">
							<el-option label="顶级" :value="0">
							</el-option>
							<el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
							</el-option>
						</el-select>
					</el-col>
					<el-col :span="5">
						<el-input placeholder="请输入二级地址,如 一栋@二栋@三栋" v-model="add_form.name"></el-input>
					</el-col>
					<el-col :span="2">
						<el-button style="margin-left: 20px;" type="primary" size="medium" @click="sub_add">提交</el-button>
					</el-col>
				</el-row>
				<el-table :data="tableData" border style="width: 100%">
					<el-table-column type="index" label="序号" width="180">
					</el-table-column>
					<el-table-column prop="name" label="名称">
						<template slot-scope="scope">
							<template v-if="scope.row.level == 1">{{scope.row.name}}</template>
							<template v-else><span>&nbsp;&nbsp;|---&nbsp;&nbsp;</span>{{scope.row.name}}</template>
						</template>
					</el-table-column>

					<el-table-column label="操作">
						<template slot-scope='scope'>
							<el-button type="success" size="mini" @click="edit_address(scope.row)">修改</el-button>
							<el-button type="danger" size="mini" @click="del_address(scope.row.id)">删除</el-button>
						</template>
					</el-table-column>
				</el-table>

			</el-main>
		</el-container>
		<el-dialog title="修改地址" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
			<el-form ref="form" :model="edit_form" label-width="80px">
				<el-form-item label="地址">
					<el-input v-model="edit_form.name"></el-input>
				</el-form-item>
			</el-form>

			<span slot="footer" class="dialog-footer">
				<el-button @click="cancel">取 消</el-button>
				<el-button type="primary" @click="sub_edit">确 定</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
	import extendModel from '../../model/extend.js'
	import Nav from './components/extend_nav.vue'
	export default {
		components: {
			Nav
		},
		data() {
			return {
				edit_form: {
					id: '',
					name: '',
					level: '',
					pid: ''
				},
				dialogVisible: false,
				add_form: {
					pid: '',
					name: ''
				},
				value: '',
				options: [],
				tableData: []
			}
		},
		mounted() {
			this.get_all_address()
		},
		methods: {
			handleClose() {
				this.dialogVisible = false
			},
			//取消修改
			cancel() {
				this.dialogVisible = false
			},
			//提交修改
			sub_edit() {
				extendModel.edit_address(this.edit_form).then(res => {
					this.$message({
						message: '修改成功',
						type: 'success'
					});
					this.get_all_address()
					this.dialogVisible = false
				})

			},
			//点击修改地址
			edit_address(item) {
				console.log(item)
				this.dialogVisible = true
				this.edit_form = item
			},
			del_address(id) {
				extendModel.del_address(id).then(res => {
					this.get_all_address()
				})
			},
			sub_add() {
				extendModel.add_address(this.add_form).then(res => {
					this.get_all_address()
					this.add_form.pid = ''
					this.add_form.name = ''
				})
			},
			get_all_address() {
				this.options = []
				extendModel.get_all_address().then(res => {
					let obj = {}
					this.tableData = res.data
					for (let k in res.data) {
						let v = res.data[k]
						if (v.level == 1) {
							obj = {
								label: v.name,
								value: v.id
							}
							this.options.push(obj)
						}
					}
				})
			}

		}
	}
</script>

<style>
</style>
