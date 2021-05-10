<template>
	<div class="mould">
		<el-container>
			<el-aside width="200px">
				<NavTo></NavTo>
			</el-aside>
			<el-container class="mould-list">
				<el-header style="border-bottom: 1px solid #d0d0d0;background-color: #FFFFFF;">
					<Header></Header>
				</el-header>

				<transition appear appear-active-class="animated fadeInLeft">

                    <el-main style="background-color: #F3F3F3;">
                        <el-button size="medium" style="margin-bottom: 20px;" type="primary" @click="add_moulds">添加模板</el-button>
                        <el-table :data="tableData" stripe style="width: 100%">
                            <el-table-column type="index" label="编号" width="80">
                            </el-table-column> 
                            <el-table-column prop="temp_id" label="模板编号">
                                <template slot-scope="scope">
                                   {{scope.row.temp_id}}
                                </template>
                            </el-table-column>
                            <el-table-column prop="temp_key" label="模板ID">
                                <template slot-scope="scope">
                                   {{scope.row.temp_key}}
                                </template>
                            </el-table-column>
                            <el-table-column prop="temp_name" label="模板名称">
                                <template slot-scope="scope">
                                   {{scope.row.temp_name}}
                                </template>
                            </el-table-column>
                            <el-table-column prop="content" label="回复内容">
                                <template slot-scope="scope">
                                    {{scope.row.content}}
                                </template>
                            </el-table-column>
                            <el-table-column prop="temp_date" label="添加时间">
                                <template slot-scope="scope">
                                    {{scope.row.temp_date}}
                                </template>
                            </el-table-column>
                            <el-table-column label="操作">
                                <template slot-scope="scope">
                                    <el-button type="success" @click="edit_moulds(scope.$index,scope.row.id)">编辑</el-button>
                                    <el-button type="danger" @click='del_moulds(scope.row.id)'>删除</el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-main>
				</transition>
			</el-container>
		</el-container>
		<!-- 添加/修改模板 -->
		<el-dialog :title="titMap[titleDialog]" :visible.sync="add_mould_dialog" width="30%" :before-close="handleCloseAE">
			<el-form ref="form" :model="add_mould" label-width="90px">
				<el-form-item label="模板ID">
					<el-input v-model="add_mould.temp_key"></el-input>
				</el-form-item>
				<el-form-item label="模板编号">
					<el-input v-model="add_mould.temp_id"></el-input>
				</el-form-item>
                <el-form-item label="模板名称">
					<el-input v-model="add_mould.temp_name"></el-input>
				</el-form-item>
                <el-form-item label="回复内容">
					<el-input type="textarea" style="resize:none;" :rows='8' v-model="add_mould.content"></el-input>
				</el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="cancel_add_mould">取 消</el-button>
                <template v-if="add_edit==true">
                    <el-button type="primary" @click="sub_add_mould">确 定</el-button>
                </template>
                <template v-else>
                    <el-button type="primary" @click="sub_edit_mould">修 改</el-button>
                </template>
			</span>
		</el-dialog>
		<!-- 添加/修改模板结束 -->
	</div>
</template>

<script>
	import NavTo from '@/components/navTo.vue'
    import Header from '@/components/header.vue'
    import { Api_url } from "@/common/config";
    export default {
        data(){
            return{
                tableData:[],
                add_mould_dialog:false,

                add_mould:{
                    temp_key:'',
                    temp_id:'',
                    temp_name:'',
                    content:'',
                    temp_date:'2020-07-20',
                },
                id:'',
                titMap:{
                    add_mould_title:'新增模板',
                    edit_mould_title:'编辑模板',
                },
                titleDialog:'',
                add_edit:true,
            }
        },
        components:{
            Header,
            NavTo,
        },
        mounted() {
			this._load();
        },
        methods:{
            _load(){
                this.http.get('cms//template/get_template').then(res=>{
                    this.tableData=res.data;
                })
            },


            // 添加模板
            add_moulds(){
                this.add_mould_dialog=true;
                this.titleDialog='add_mould_title';
                if(this.add_edit!=true){
                    this.add_edit=true;
                }
            },
            // 提交添加
            sub_add_mould(){
                if(this.add_mould.temp_key<6){
                    this.$message({
                        message:'模板ID不能少于6位',
                        type:'warning'
                    });
                    this.add_mould.temp_key='';
                    return
                }
                if(this.add_mould.temp_id<6){
                    this.$message({
                        message:'模板编号不能少于6位',
                        type:'warning'
                    });
                    this.add_mould.temp_id='';
                    return
                }
                if(this.add_mould.temp_name==''){
                    this.$message({
                        message:'模板名称不能为空',
                        type:'warning'
                    });
                    this.add_mould.temp_name='';
                    return
                }
                if(this.add_mould.content==''){
                    this.$message({
                        message:'回复内容不能为空',
                        type:'warning'
                    });
                    this.add_mould.content='';
                    return
                }
                this.http.post_show('cms/template/add_template',this.add_mould).then(res=>{
                    this.add_mould.temp_date=new Date();
                    this.$message({
                        message:'添加成功',
                        type:'success'
                    });
                    this.add_mould={
                        temp_key:'',
                        temp_id:'',
                        temp_name:'',
                        content:'',
                        temp_date:'',
                    }
                    this.add_mould_dialog=false;
                    this._load();
                })
            },
            // 取消添加
            cancel_add_mould(){
                this.add_mould={
                    temp_key:'',
                    temp_id:'',
                    temp_name:'',
                    content:'',
                    temp_date:'',
                }
                this.add_mould_dialog=false;
            },

            // 修改模板
            edit_moulds(index,id){
                this.add_mould_dialog=true;
                this.titleDialog='edit_mould_title';
                this.add_mould.temp_key=this.tableData[index].temp_key;
                this.add_mould.temp_id=this.tableData[index].temp_id;
                this.add_mould.temp_name=this.tableData[index].temp_name;
                this.add_mould.content=this.tableData[index].content;

                if(this.add_edit==true){
                    this.add_edit=false;
                }
                this.id=id;
                console.log(id);
            },
            // 提交修改
            sub_edit_mould(){
                console.log(this.add_mould)
                let edit_arr={
                    temp_key:this.add_mould.temp_key,
                    temp_id:this.add_mould.temp_id,
                    temp_name:this.add_mould.temp_name,
                    content:this.add_mould.content,
                    id:this.id,
                }
                console.log(edit_arr);
                this.http.post_show('cms/template/update_template',edit_arr).then(res=>{
                    this.$message({
                        type:'success',
                        message:'修改成功'
                    });
                    this.add_mould_dialog=false;
                    this._load();
                })
            },
            // 取消修改
            cancel_edit_mould(){
                this.edit_mould={
                    temp_key:'',
                    temp_id:'',
                    temp_name:'',
                    content:'',
                    temp_date:'',
                }
                this.id="";
                this.add_mould_dialog=false;
            },
            // 删除模板
            del_moulds(id){
				this.$confirm('确定删除该模板？', '提示', {
					confirmButtonText: '删除',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
                    this.http.del('cms/template/del_template',{id:id}).then(res=>{
                        this.$message({
                            type:'success',
                            message:'删除成功'
                        });
                        this._load();
                    });
				})
            },

            handleCloseAE(){
                this.add_mould={
                    temp_key:'',
                    temp_id:'',
                    temp_name:'',
                    content:'',
                    temp_date:'',
                };
                this.add_mould_dialog=false;
            },
        },
    }
</script>

<style lang="less" scope>
    .mould{

        .mould-list{
            text-align: left !important;
        }
    }
</style>