<template>
	<div class="user_level">
		<el-container class="container">
			<el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="7"></Nav>
			</el-aside>
			<el-main class="main">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>搜索</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="zhang" style="text-align: left;">
					<el-button style="margin-bottom: 10px;" type="primary" size="medium" @click="add_level">新增搜索热词</el-button>
					<el-table :data="list" border style="width: 100%">
						<el-table-column type="index" label="序号" width="80"></el-table-column>
						<el-table-column prop="name_l" label="搜索热词">
							<template slot-scope="scope">
							<span>{{scope.row.name}}</span>
							</template>
						</el-table-column>
						<el-table-column label="操作" width="300px">
							<template slot-scope="scope">
								<el-button type="danger" size="mini" @click="del(scope.row)">删除</el-button>
							</template>
						</el-table-column>
					</el-table>
				</div>
			</el-main>
		</el-container>
		<el-dialog title="新增搜索热词" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
			<el-form ref="form" :model="form" label-width="80px">
				<el-form-item label="搜索词"><el-input placeholder="请输入搜索词..." v-model="form.name"></el-input></el-form-item>
				<el-form-item label="搜索次数"><el-input placeholder="请输入搜索次数..." v-model="form.num"></el-input></el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="sub_add">确 定</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
import Nav from '../extend/components/extend_nav.vue'
import UserModel from '../../model/user.js';
export default {
	components: {
		Nav
	},
	data() {
		return {
			dialogVisible: false,
			form: {
				name_l: '',
				discount: '0.8',
				sort: '0'
			},
			sort: 0,
			list: []
		};
	},
	watch: {
		dialogVisible(n, o) {
			if (!n) {
				this.form = {
					name: '',
					num:1,
				};
			}
		}
	},
	mounted() {
		this.get_all_record();
	},
	methods: {
		get_all_record() {
			this.http.get('search/record').then(res=>{
				console.log(res)
				this.list=res.data
			})
		},
		sub_add() {
			this.http.post('search/admin/add_record',this.form).then(res=>{
				this.dialogVisible = false;
				this.get_all_record();
			});
		},
		add_level() {
			this.dialogVisible = true;
		},
		del(name) {
			this.http.put_show('search/admin/del_record?name='+name).then(res=>{
				this.$message({
					message: '操作成功',
					type: 'success'
				});
				this.get_all_record();
			});
		},
		handleClose() {
			this.dialogVisible = false;
		}
	}
};
</script>

<style lang="less"></style>
