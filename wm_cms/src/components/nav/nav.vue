<template>
	<div class="root">
		<el-menu :default-active="Act" class="el-menu-vertical-demo" @open="handleOpen"
		 @close="handleClose" background-color="#545c64"
		 text-color="#fff" active-text-color="#ffd04b" @select="handleselect">
			<el-menu-item index="111" disabled>
				<span slot="title"></span>
			</el-menu-item>
			<el-menu-item index="1" @click="jump_to_index">
				<i class="el-icon-s-home"></i>
				<span slot="title">首页</span>
			</el-menu-item>
			<el-menu-item index="2" @click="jump_to_shops">
				<i class="el-icon-s-shop"></i>
				<span slot="title">商品</span>
			</el-menu-item>
			<el-menu-item index="4" @click="jump_to_order">
				<i class="el-icon-document"></i>
				<span slot="title">订单</span>
			</el-menu-item>
			<el-menu-item index="3" @click="jump_to_user">
				<i class="el-icon-user"></i>
				<span slot="title">用户</span>
			</el-menu-item>
			
			 <!-- <el-menu-item index="7" @click="jump_to_admin">
				<i class="el-icon-s-custom"></i>
				<span slot="title">管理员</span>
			</el-menu-item> -->
			 <!-- <el-menu-item index="5" @click="jump_to_serach">
				<i class="el-icon-search"></i>
				<span slot="title">搜索</span>
			</el-menu-item> -->
			<el-menu-item index="6" @click="jump_to_app">
				<i class="el-icon-menu"></i>
				<span slot="title">应用</span>
			</el-menu-item>
			
			<el-submenu index="8">
				<template slot="title">
					<i class="el-icon-setting"></i>
					<span>设置</span>
				</template>
					<el-menu-item index="8-1" @click="jump_to_set">
						<span slot="title" style="margin-left: -30px;">站点设置</span>
					</el-menu-item>
					<el-menu-item index="8-3" @click="jump_to_admin">
						<span slot="title" style="margin-left: -30px;">管理员</span>
					</el-menu-item>
			</el-submenu>
			<!-- <el-menu-item index="8" @click="jump_to_set">
				<i class="el-icon-setting"></i>
				<span slot="title">设置</span>
			</el-menu-item> -->
		</el-menu>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				Act: ''
			}
		},
		mounted() {
			this.Act = localStorage.getItem("Act")
		},
		methods: {
			handleselect(key, keyPath) {
				this.Act = key
				localStorage.setItem("Act", key);
				localStorage.setItem("act", 1);
			},
			jump_to_app() {
				this.$router.push({
					path: '/extend/ad'
				})
			},
			// jump_to_serach() {
			// 	this.$router.push({
			// 		path: '/serach/serach'
			// 	})
			// },
			jump_to_admin() {
				this.$router.push({
					path: '/admin/admin'
				})
			},
			jump_to_index() {
				this.$router.push({
					path: '/'
				})
			},
			jump_to_order() {
				this.$router.push({
					path: '/order/order_list'
				})
			},
			jump_to_set() {
				this.$router.push({
					path: '/set/set'
				})
			},
			jump_to_shops() {
				this.$router.push({
					path: '/shops/pro_list'
				})
			},
			jump_to_user() {
				this.$router.push({
					path: '/user/user_list'
				})
			},
			handleOpen(key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose(key, keyPath) {
				console.log(key, keyPath);
			}
		}
	}
</script>

<style>
	el-menu-item{
		text-align: left;
	}
</style>
