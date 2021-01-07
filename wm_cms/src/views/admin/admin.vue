<template>
	<div class="user_level">
		<el-container class="container">
			<!-- <el-aside width="160px" class="not-print bg-white erbian">
				<Nav ac="2"></Nav>
			</el-aside> -->
			<el-main class="main">
				<el-breadcrumb separator-class="el-icon-arrow-right">
					<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
					<el-breadcrumb-item>管理员</el-breadcrumb-item>
				</el-breadcrumb>
				<div class="H10"></div>
				<div class="zhang" style="text-align: left;">
					<el-button style="margin-bottom: 10px;" type="primary" size="medium" @click="add_level">新增管理员</el-button>
					<el-table :data="list" border style="width: 100%">
						<el-table-column type="index" label="序号" width="80"></el-table-column>
						<el-table-column prop="username" label="用户名">
						</el-table-column>
						<el-table-column prop="description" label="描述">
						</el-table-column>
						<el-table-column label="所属分组">
							<template slot-scope="scope">
							<span>{{scope.row.group.name}}</span>
							</template>
						</el-table-column>
						<el-table-column label="操作" width="300px">
							<template slot-scope="scope">
								<!-- <el-button type="primary" size="mini" @click="on_edit(scope.row)">修改</el-button> -->
								<el-button type="danger" size="mini" @click="del(scope.row.id)">删除</el-button>
							</template>
						</el-table-column>
					</el-table>
				</div>
			</el-main>
		</el-container>
		<el-dialog title="新增管理员" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
			<el-form ref="form" :model="form" label-width="80px">
				<el-form-item label="用户名"><el-input placeholder="请输入用户名..." v-model="form.username"></el-input></el-form-item>
				<el-form-item label="密码"><el-input placeholder="请输入密码..." show-password v-model="form.password"></el-input></el-form-item>
				<el-form-item label="描述"><el-input placeholder="请输入描述..." v-model="form.description"></el-input></el-form-item>
				<!-- <el-form-item label="所属分组">
					<el-select v-model="value" placeholder="请选择">
					    <el-option
					      v-for="item in groups"
					      :key="item.value"
					      :label="item.label"
					      :value="item.value">
					    </el-option>
					  </el-select>
				</el-form-item> -->
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="sub_add">确 定</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
//import Nav from '../user/components/user_nav.vue'
import UserModel from '../../model/user.js';
export default {
	components: {
	},
	data() {
		return {
			dialogVisible: false,
			form: {
				group_id:1,
				state:1
			},
			sort: 0,
			list: []
		};
	},
	watch: {
		dialogVisible(n, o) {
			if (!n) {
				this.form = {
					username: '',
					group_id:1,
					password:'',
					description:''	
				};
			}
		}
	},
	mounted() {
		this.get_all_admin();
	},
	methods: {
		get_all_admin() {
			this.http.get('cms/admin/get_all_admin').then(res=>{
				console.log(res)
				this.list=res.data
			})
		},
		on_edit(admin){
			this.dialogVisible = true;
			this.form=admin
			
		},
		sub_add() {
			if(!this.form.id){
				this.http.post_show('cms/admin/add_admin',this.form).then(res=>{
					this.dialogVisible = false;
					this.get_all_admin();
				});
			}
			else{
				
			}
		},
		add_level() {
			this.dialogVisible = true;
		},
		del(id) {
			this.http.Del('cms/admin/del_admin?id='+id).then(res=>{
				this.$message({
					message: '操作成功',
					type: 'success'
				});
				this.get_all_admin();
			});
		},
		handleClose() {
			this.dialogVisible = false;
		}
	}
};
</script>

<style lang="less"></style>
