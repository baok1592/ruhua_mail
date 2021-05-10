 
export default {
	data() {
		return {
			
		}
	},
	onLoad(options) {
		
	},
	onShow() {
		
	},
	methods: {
		show_data() {},
	},
	onPullDownRefresh() {
		this.show_data();
		setTimeout(function () {
			uni.stopPullDownRefresh();
		}, 2000);
	},
}
