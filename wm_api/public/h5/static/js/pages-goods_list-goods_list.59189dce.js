(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-goods_list-goods_list"],{"0785":function(t,e,i){"use strict";i.r(e);var n=i("52a8"),o=i("9035");for(var r in o)"default"!==r&&function(t){i.d(e,t,(function(){return o[t]}))}(r);i("9482");var s,a=i("f0c5"),d=Object(a["a"])(o["default"],n["b"],n["c"],!1,null,"e6e66f20",null,!1,n["a"],s);e["default"]=d.exports},"164b":function(t,e,i){"use strict";var n=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;i("7c34");var o=n(i("16f8")),r={data:function(){return{getimg:this.$getimg,order_id:-1,goods:[]}},onLoad:function(t){t.order_id&&(this.order_id=t.order_id,this.getOrderInfo())},methods:{show_data:function(){this.getOrderInfo()},getOrderInfo:function(){var t=this,e=this;o.default.getOrderInfo(e.order_id).then((function(e){t.goods=e.data.order_goods}))},jump:function(t){uni.navigateTo({url:"../rate/rate?goods_id="+t+"&order_id="+this.order_id})}}};e.default=r},"52a8":function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return o})),i.d(e,"c",(function(){return r})),i.d(e,"a",(function(){return n}));var o=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"goods-list"},t._l(t.goods,(function(e,n){return i("v-uni-view",{key:n,staticClass:"goods-panel"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-image",{staticClass:"img",attrs:{src:t.getimg+e.pic,mode:""}})],1),i("v-uni-view",{staticClass:"right"},[i("v-uni-view",{staticClass:"goods_name"},[t._v(t._s(e.goods_name))]),i("v-uni-button",{staticClass:"btn",attrs:{type:"primary",size:"mini"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.jump(e.goods_id)}}},[t._v("评论")])],1)],1)})),1)},r=[]},9035:function(t,e,i){"use strict";i.r(e);var n=i("164b"),o=i.n(n);for(var r in n)"default"!==r&&function(t){i.d(e,t,(function(){return n[t]}))}(r);e["default"]=o.a},9482:function(t,e,i){"use strict";var n=i("b27a"),o=i.n(n);o.a},b27a:function(t,e,i){var n=i("e99c");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var o=i("4f06").default;o("3c93e625",n,!0,{sourceMap:!1,shadowMode:!1})},e99c:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是app内置的常用样式变量\r\n *\r\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */\r\n/* coolc-coupon 插件 */.goods-list[data-v-e6e66f20]{width:100%;padding:%?20?%}.goods-list .goods-panel[data-v-e6e66f20]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;background-color:#fff;padding:%?30?%;overflow:hidden;margin-bottom:%?30?%}.goods-list .goods-panel .left[data-v-e6e66f20]{-webkit-flex-shrink:0;flex-shrink:0;margin-right:%?40?%}.goods-list .goods-panel .left .img[data-v-e6e66f20]{width:%?100?%;height:%?100?%}.goods-list .goods-panel .right[data-v-e6e66f20]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.goods-list .goods-panel .right .goods_name[data-v-e6e66f20]{width:%?500?%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.goods-list .goods-panel .right .btn[data-v-e6e66f20]{margin-top:%?20?%;width:%?130?%;-webkit-align-self:flex-end;align-self:flex-end}',""]),t.exports=e}}]);