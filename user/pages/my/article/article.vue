<template>
	<view>
		<rich-text :nodes="content"></rich-text>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				content:''
			}
		},
		onLoad() {
			
			this.content=uni.getStorageSync('content')
		},
		methods: {
			
		}
	}
</script>

<style>

</style>
