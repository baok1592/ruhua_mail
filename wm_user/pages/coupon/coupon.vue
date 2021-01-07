<template>
	<view class="coupon">
		<template v-for="(item, index) in coupon">
			<coolc-coupon :key="index" :theme="'#ea0000'" :item="item"></coolc-coupon>
		</template>
	</view>
</template>

<script>
	import CoolcCoupon from '@/components/coolc-coupon/coolc-coupon.vue'
	import usercoupon from "@/api/user_coupon.js"
	
	export default {
		components: {
			CoolcCoupon,
		},
		data() {
			return {
				coupon: []
			};
		},
		created() {
			
		}
	}
</script>

<style lang="scss" scoped>
.coupon {
	padding: 0 20rpx;
}
</style>
