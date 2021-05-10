import axios from 'axios'
import {Api_url} from './config'    
//创建axios实例
var service = axios.create({
	baseURL: Api_url,
	timeout: 5000
})

// 添加请求拦截器
axios.interceptors.request.use(function (config) {
    // 在发送请求之前做些什么
    return config;
  }, function (error) {
    // 对请求错误做些什么
    return Promise.reject(error);
  });

// 添加响应拦截器
axios.interceptors.response.use(function (response) {
    // 对响应数据做点什么
    return response;
  }, function (error) {
    // 对响应错误做点什么
    return Promise.reject(error);
  });
  
//真机获取  
axios.defaults.adapter = function (config) {  
    return new Promise((resolve, reject) => {  
        var settle = require('axios/lib/core/settle');  
        var buildURL = require('axios/lib/helpers/buildURL');  
        uni.request({  
            method: config.method.toUpperCase(),  
            url:Api_url+config.url,  
            header: config.headers,  
            data: config.data,  
            dataType: config.dataType,  
            responseType: config.responseType,  
            sslVerify: config.sslVerify,  
            complete:function complete(response){  
                response = {  
                  data: response.data,  
                  status: response.statusCode,  
                  errMsg: response.errMsg,  
                  header: response.header,  
                  config: config  
                };  

            settle(resolve, reject, response);  
            }  
        })  
    })  
}  

export default {
	//get请求
	get(url, param) {
		return new Promise((cback, reject) => {
			service({
				header:{token:uni.getStorageSync('token')||''},
				method: 'get',
				url,
				params: param,
			}).then(res => { //axios返回的是一个promise对象 
			let arr=res.data
			console.log(res)
				var res_code = arr.status; 
				if (res_code==200) { 
					cback(arr); 
				}else{
					if(res_code==600){
						//登录失效
						
					}else{
						uni.showToast({
							title:arr.msg?res.msg:'请求异常',
							icon:'none'
						})
					}
				}
			}).catch(err => { 				 
				console.log(err, '异常2')
			})

		})
	},

	put(url, param) {
		return new Promise((cback, reject) => {
			service({
				header:{token:uni.getStorageSync('token')},
				method: 'put',
				url,
				params: param,
			}).then(res => { //axios返回的是一个promise对象	
			let arr=res.data
				var res_code = arr.status; 
				if (res_code==200) { 
					cback(arr); 
				}else{
					if(res_code==600){
						//登录失效
						
					}else{
						uni.showToast({
							title:arr.msg?res.msg:'请求异常',
							icon:'none'
						})
					}
				}
			}).catch(err => {
				//reject(err.response);
				console.log(err.response, '异常2')
			})
		})
	},

	post(url, param) {
		const that = this
		return new Promise((cback, reject) => {
			service({
				header:{token:uni.getStorageSync('token')},
				method: 'post',
				url,
				data: param,
			}).then(res => {
				let arr=res.data
					var res_code = arr.status; 
					if (res_code==200) { 
						console.log(arr)
						cback(arr)
					}else{
						if(res_code==600){
							//登录失效
							
						}else{
							uni.showToast({
								title:arr.msg?arr.msg:'请求异常',
								icon:'none'
							})
						}
					}
			}).catch(err => {
				console.log(err, '异常2')
			})
		})
	}
}
