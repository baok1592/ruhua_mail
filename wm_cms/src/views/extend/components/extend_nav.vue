<template>
	<div class="root">
		<div class="top-title">应用管理</div>
		<el-menu
			:default-active="act"
			class="el-menu-vertical-demo"
			@open="handleOpen"
			@close="handleClose">
			
			
				<el-menu-item index="3" @click="jump_to_ad">
					<span slot="title">广告</span>
				</el-menu-item>
				<el-menu-item index="4" @click="jump_article">
					<span slot="title">文章</span>
				</el-menu-item>
				<!-- <el-menu-item index="8" @click="jump_Nav">
					<span slot="title">导航</span>
				</el-menu-item> -->
				<el-menu-item index="5" @click="jump_address">
					<span slot="title">地址</span>
				</el-menu-item>
		</el-menu>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				act:''
			}
		},
		props:{
			ac:String
		},
		mounted() {
			console.log(this.ac)
			this.act=this.ac //localStorage.getItem("act");
		},
		methods:{
			jump_address(){
				this.$router.push({
					path:'/extend/address'
				})
			},
			jump_Nav(){
				this.$router.push({
					path:'/extend/Nav'
				})
			},
			
			jump_article(){
				this.$router.push({
					path:'/extend/article'
				})
			},
			jump_to_ad(){
				this.$router.push({
					path:'/extend/ad'
				})
			},
			
			jump_to_c(){
				this.$router.push({
					path:'/extend/pt'
				})
			},
			jump_to_d(){
				this.$router.push({
					path:'/extend/discount'
				})
			},
			
			handleOpen(key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose(key, keyPath) {
				console.log(key, keyPath);
			},
			handleselect(key,keyPath){
				this.act=key
				localStorage.setItem("act",key);
			},
			
			
		}
	}
</script>

<style>
</style>
