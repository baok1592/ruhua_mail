<template>
	<view class="container" style="font-size: 15px !important;">
		<view class="address-form">
			<list-cell padding="30rpx">
				<view class="form-item">
					<view class="label">联系人</view>
					<input type="text" v-model="form.name" placeholder="请填写收货人的姓名" placeholder-class="placeholder"/>
				</view>
			</list-cell>
			<list-cell padding="30rpx">
				<view class="form-item">
					<view class="label">手机号</view>
					<input type="text" maxlength="11" v-model="form.mobile" placeholder="请填写收货手机号码" placeholder-class="placeholder"/>
				</view>
			</list-cell>
			<list-cell padding="30rpx">
				<view class="form-item">
					<view class="label">地区</view>
					<picker @change="bindPickerChange" :value="index" mode="selector" :range="provinces">
					    <view class="uni-input">{{provinces[index]}}</view>
					</picker>
				</view>
			</list-cell>
			<list-cell padding="30rpx">
				<view class="form-item">
					<view class="label">街道</view>
					<picker @change="bindPickerChange1" mode="selector" :value="index1" :range="citys">
					    <view class="uni-input">{{citys[index1]}}</view>
					</picker>
				</view>
			</list-cell>
			<list-cell padding="30rpx">
				<view class="form-item">
					<view class="label">详细地址</view>
					<input type="text" v-model="form.detail" placeholder="例:B座6楼606室" placeholder-class="placeholder"/>
				</view>
			</list-cell>
		</view>
		
		<view class="save-btn">
			<button type="info" @click="save()">保存</button>
		</view>
	</view>
</template>

<script>
	import listCell from '@/components/list-cell/list-cell.vue'
	import addres from '../../api/address.js'
	
	export default {
		components: {
			listCell
		},
		data() {
			return {
				form: {
					name: '',
					mobile: '',
					detail: '',
					is_default: 0,
					province: '',
					city:'',
				},
				index:0,
				index1:0,
				provinces:['请选择'],
				citys:['请选择'],
				address:[],
				idEdit: false,
				id: -1,
			}
		},
		watch:{
			index(val){
				let t=this.provinces[val]
				let p=this.address.find(function(v){
					return v.name==t
				})
				for(var i in this.address){
					if(this.address[i].pid==p.id) {
						this.citys.push(this.address[i].name)
					}
				}
			}
		},
		onLoad({id}) {
			this.id = id;
			this.show_data();
		},
		methods: {
			show_data() {
				addres.get_address().then(res=>{
					this.address=res.data
					for(var i in res.data){
						if(res.data[i].level==1)
							this.provinces.push(res.data[i].name)
					} 
				})
				if(this.id) {
					this.idEdit = true;
					addres.get_one_address(this.id).then(res => {
						this.form=res.data
						for(var i in this.provinces){
							if(this.provinces[i]==this.form.province){
								this.index=i;
								break;
							}
						}
						// console.log(this.citys)
						for(var j in this.citys){
							if(this.citys[j]==this.form.city){
								this.index1=j;
								break;
							}
						}
					})
				}
			},
			bindPickerChange: function(e) {
			    this.index = e.target.value
				this.form.province = this.provinces[this.index]
			},
			bindPickerChange1: function(e) {
			    console.log('picker发送选择改变，携带值为', e.target.value)
			    this.index1 = e.target.value
				this.form.city=this.citys[this.index1] 
			},
			save(){
				if(this.form.id){
					addres.edit_address(this.form).then(res=>{
						if(res.data)
						{
							uni.showToast({
								title: '修改成功！',
								duration: 2000
							})
							uni.navigateBack();
						}
						else
							uni.showToast({
								title: '修改失败！',
								duration: 2000
							})
					})
				}
				else{
					if(!this.form.city || !this.form.detail || !this.form.mobile || !this.form.name || !this.form.province){
						uni.showToast({
							icon:"none",
							title:'请填写完整信息'
						})
						return
					}
					
					addres.add_address(this.form).then(res=>{
						if(res.data){
							uni.showToast({
								title: '添加成功！',
								duration: 2000
							})
							// uni.reLaunch({
							// 	url:"./addresses"
							// })
							uni.navigateBack();
						}
						else
							uni.showToast({
								title: '添加失败！',
								duration: 2000
							})
					})
				}
			}
		}
		
	}
</script>

<style lang="scss" scoped>
.address-form {
	margin-top: 20rpx;
	
	.form-item {
		width: 100%;
		display: flex;
		align-items: center;
		
		.label {
			width: 160rpx;
		}
		
		input {
			flex: 1;
		}
		
		.jump-icon {
			width: 30rpx;
			height: 48rpx;
		}
		
		.radio {
			display: flex;
			margin-right: 50rpx;
			image {
				width: 40rpx;
				height: 40rpx;
				margin-right: 20rpx;
			}
		}
	}
}

.save-btn {
	padding: 0 30rpx;
	margin-top: 60rpx;
	
	button {
		width: 100%;
		font-size: $font-size-extra-lg;
	}
}

</style>
