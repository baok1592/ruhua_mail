<template>
	<div class="root">
		<div class="top-title">订单管理</div>
		<el-menu
			:default-active="act"
			class="el-menu-vertical-demo"
			@open="handleOpen"
			@close="handleClose">
			
				
				<el-menu-item index="1" @click="jump_to_a">
					<span slot="title">订单列表</span>
				</el-menu-item>
				<el-menu-item index="2" @click="jump_to_b">
					<span slot="title">评价</span>
				</el-menu-item>
				<!-- <el-menu-item index="3" @click="jump_to_order_count">
					<span slot="title">统计</span>
				</el-menu-item> -->
				<el-menu-item index="4" @click="jump_to_tk">
					<span slot="title">退款</span>
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
			this.act=this.ac //localStorage.getItem("act");
		},
		methods:{
			jump_to_order_count(){
				this.$router.push({
					path:'/order/order_count'
				})
			},
			jump_to_a(){
				this.$router.push({
					path:'/order/order_list'
				})
			},
			jump_to_tk(){
				this.$router.push({
					path:'/order/tk'
				})
			},
			jump_to_b(){
				this.$router.push({
					path:'/order/evaluate'
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
