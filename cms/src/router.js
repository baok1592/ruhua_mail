import Vue from 'vue'
import Router from 'vue-router' 

Vue.use(Router)

export default new Router({
	routes: [
		{  
			path: '/',
			name: 'index',
			component: () => import('./views/index/index.vue')
		},
		{
			path: '/shops/pro_list',
			name: 'pro_list',
			component: () => import('./views/shops/pro/pro_list.vue')
		},
		
		
		{
			path: '/shops/pro_group',
			name: 'pro_group',
			component: () => import('./views/shops/pro/pro_group')
		},
		{
			path: '/order/order_list',
			name: 'order_list',
			component: () => import('./views/order/order_list.vue')
		},
		{
			path: '/order/order_count',
			name: 'order_count',
			component: () => import('./views/order/order_count')
		},
		{
			path: '/order/evaluate',
			name: 'evaluate',
			component: () => import('./views/order/evaluate.vue')
		},
		{
			path: '/login',
			name: 'Login',
			component: () => import('./views/login/login.vue')
		},		 
		{
			path: '/lout',
			name: 'lout',
			component: () => import('./views/login/lout.vue')
		},
		{
			path: '/user/user_list',
			name: 'user_list',
			component: () => import('./views/user/user_list.vue')
		},
		{
			path: '/user/user_detail',
			name: 'user_detail',
			component: () => import('./views/user/user_detail.vue')
		},
		{
			path: '/user/user_level',
			name: 'user_level',
			component: () => import('./views/user/user_level.vue')
		},
		
		
		
		{
			path: '/extend/coupon',
			name: 'coupon',
			component: () => import('./views/extend/coupon.vue')
		},
		{
			path: '/extend/address',
			name: 'address',
			component: () => import('./views/extend/address.vue')
		},
		{
			path: '/extend/article',
			name: 'article',
			component: () => import('./views/extend/article.vue')
		},
		{
			path: '/extend/addcoupon',
			name: 'addcoupon',
			component: () => import('./views/extend/addcoupon.vue')
		},
		
		{
			path: '/extend/ad',
			name: 'ad',
			component: () => import('./views/extend/ad.vue')
		},
		{
			path: '/set/set',
			name: 'set',
			component: () => import('./views/set/set.vue')
		},
		
		{
			path: '/extend/discount',
			name: 'discount',
			component: () => import('./views/extend/discount.vue')
		},
		{
			path: '/extend/editdiscount',
			name: 'editdiscount',
			component: () => import('./views/extend/editdiscount.vue')
		},
		{
			path: '/extend/adddiscount',
			name: 'adddiscount',
			component: () => import('./views/extend/adddiscount.vue')
		},
		{
			path: '/admin/admin',
			name: 'admin',
			component: () => import('./views/admin/admin.vue')
		},
		{
			path: '/serach/serach',
			name: 'serach',
			component: () => import('./views/serach/serach.vue')
		},
		{
			path: '/extend/smdc',
			name: 'smdc',
			component: () => import('./views/extend/smdc.vue')
		},
		{
			path: '/order/tk',
			name: 'tk',
			component: () => import('./views/order/tk.vue')
		},
		{
			path: '/extend/Nav',
			name: 'Nav',
			component: () => import('./views//extend/Nav.vue')
		},
		
		
		
	]
})
