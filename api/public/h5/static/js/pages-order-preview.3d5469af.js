(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-order-preview"],{"0706":function(t,e,i){"use strict";var o=i("d5f4"),a=i.n(o);a.a},1311:function(t,e,i){var o=i("24fb");e=o(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-c681da2e]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.coupon-item[data-v-c681da2e]{width:100%;height:auto;display:table;-webkit-border-radius:%?10?%;border-radius:%?10?%;padding:0 %?20?%;margin-top:%?22?%;border:1px solid #eee;position:relative}.coupon-item .coupon-money[data-v-c681da2e]{width:%?465?%;height:auto;display:table;float:left;padding:%?26?% 0;border-style:none dotted none none;border-color:#eee}.coupon-item .coupon-money .nick[data-v-c681da2e]{width:100%;height:%?50?%;line-height:%?30?%;font-size:%?20?%;color:#999}.coupon-item .coupon-money .tit[data-v-c681da2e]{width:100%;height:%?50?%;line-height:%?50?%;font-size:%?20?%;color:#999}.coupon-item .coupon-money .demand[data-v-c681da2e]{width:100%;height:%?30?%;line-height:%?30?%;font-size:%?20?%;color:#999}.coupon-item .coupon-money .layof[data-v-c681da2e]{width:100%;height:%?48?%;line-height:%?30?%;font-size:%?44?%;color:#ff9000;font-weight:700}.coupon-item .coupon-money .end_time[data-v-c681da2e]{width:100%;height:%?30?%;line-height:%?30?%;font-size:%?20?%;color:#999}.coupon-item .get-btn[data-v-c681da2e]{width:%?146?%;height:%?52?%;line-height:%?50?%;position:absolute;top:50%;right:%?26?%;margin-top:%?-26?%;text-align:center;-webkit-border-radius:%?60?%;border-radius:%?60?%;color:#ff9000;border:1px solid #ff9000;font-size:%?20?%;float:right}.coupon-item[data-v-c681da2e]:after{width:%?40?%;height:%?20?%;position:absolute;left:%?460?%;top:-1px;-webkit-border-radius:0 0 %?40?% %?40?%;border-radius:0 0 %?40?% %?40?%;content:"";display:block;background:#fff;border:1px solid #eee;border-top:0}.coupon-item[data-v-c681da2e]:before{width:%?40?%;height:%?20?%;position:absolute;left:%?460?%;bottom:-1px;-webkit-border-radius:%?40?% %?40?% 0 0;border-radius:%?40?% %?40?% 0 0;content:"";display:block;background:#fff;border:1px solid #eee;border-bottom:0}',""]),t.exports=e},1991:function(t,e,i){"use strict";var o=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=o(i("4c1e"));function n(t){var e="coupon/user/order_coupon";return a.default.post(e,t).then((function(t){return t}))}function r(){var t="coupon/user/get_coupon";return a.default.get(t).then((function(t){return t}))}function s(){var t="coupon/get_coupon";return a.default.get(t).then((function(t){return t}))}function d(t){var e="coupon/add_coupon?id="+t;return a.default.get(e).then((function(t){return t}))}var l={get_order_coupon:n,get_coupon:r,get_all_coupon:s,user_lq_coupon:d};e.default=l},"19bd":function(t,e,i){"use strict";var o;i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return n})),i.d(e,"a",(function(){return o}));var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"tui-cell-class tui-list-cell",class:{"tui-cell-last":t.last,"tui-line-left":t.lineLeft,"tui-line-right":t.lineRight,"tui-radius":t.radius},style:{background:t.bgcolor,fontSize:t.size+"rpx",color:t.color,padding:t.padding},attrs:{"hover-class":t.hover?"tui-cell-hover":"","hover-stay-time":150},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleClick.apply(void 0,arguments)}}},[t._t("default"),t.arrow?i("v-uni-image",{staticClass:"arrow",attrs:{src:"/static/images/common/icon_jump_black3.png"}}):t._e()],2)},n=[]},"29a5":function(t,e,i){"use strict";i.r(e);var o=i("cff5"),a=i.n(o);for(var n in o)"default"!==n&&function(t){i.d(e,t,(function(){return o[t]}))}(n);e["default"]=a.a},"2c79":function(t,e,i){"use strict";i.r(e);var o=i("5e07"),a=i.n(o);for(var n in o)"default"!==n&&function(t){i.d(e,t,(function(){return o[t]}))}(n);e["default"]=a.a},"34be":function(t,e,i){"use strict";i.r(e);var o=i("91ce"),a=i("29a5");for(var n in a)"default"!==n&&function(t){i.d(e,t,(function(){return a[t]}))}(n);i("6b33");var r,s=i("f0c5"),d=Object(s["a"])(a["default"],o["b"],o["c"],!1,null,"6a55efd8",null,!1,o["a"],r);e["default"]=d.exports},"374b":function(t,e,i){var o=i("1311");"string"===typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);var a=i("4f06").default;a("915b6d0e",o,!0,{sourceMap:!1,shadowMode:!1})},"42bb":function(t,e,i){"use strict";var o=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=o(i("4c1e")),n=function(t){var e="cms/get_config";return a.default.get(e,{type:t}).then((function(t){return t}))},r={getSystemConfig:n};e.default=r},"5e07":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var o={components:{},data:function(){return{is_chose:!1,choose_id:""}},watch:{is_chose:function(){console.log(this.is_chose)}},props:{item:{type:Object},types:{type:String,default:""},theme:{type:String,default:"#ff9000"},solid:{type:String,default:"#ffffff"},color:{type:String,default:"#ff9000"}},methods:{choose:function(t){t.is_choose?t.is_choose=!1:t.is_choose=!0,this.is_chose=t.is_choose,this.$emit("choose_done",t)}}};e.default=o},"6b33":function(t,e,i){"use strict";var o=i("f9aa"),a=i.n(o);a.a},"7cc0":function(t,e,i){"use strict";var o=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=o(i("4c1e"));function n(){var t="address/get_default_address";return a.default.get(t).then((function(t){return t}))}function r(){var t="address/get_all_address";return a.default.get(t).then((function(t){return t}))}function s(){var t="index/get_address";return a.default.get(t).then((function(t){return t}))}function d(t){var e="address/get_one_address?id=";return a.default.get(e+t).then((function(t){return t}))}function l(t){var e="address/edit_address";return a.default.post(e,t).then((function(t){return t}))}function c(t){var e="address/add_address";return a.default.post(e,t).then((function(t){return t}))}function f(t){var e="address/del_address";return a.default.put(e,{id:t}).then((function(t){return t}))}function u(t){var e="address/set_default_address";return a.default.post(e,{id:t}).then((function(t){return t}))}var b={get_default_address:n,get_all_address:r,get_address:s,get_one_address:d,edit_address:l,add_address:c,deleteAddress:f,setDefaultAddress:u};e.default=b},"8ff1":function(t,e,i){"use strict";i.r(e);var o=i("19bd"),a=i("9d9e");for(var n in a)"default"!==n&&function(t){i.d(e,t,(function(){return a[t]}))}(n);i("0706");var r,s=i("f0c5"),d=Object(s["a"])(a["default"],o["b"],o["c"],!1,null,"16e75238",null,!1,o["a"],r);e["default"]=d.exports},"91ce":function(t,e,i){"use strict";i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return n})),i.d(e,"a",(function(){return o}));var o={listCell:i("8ff1").default,uniPopup:i("127e").default},a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-view",{staticClass:"head tab-right-active"},[i("v-uni-view",{staticClass:"container head-bottom",class:{selectOne:1==t.tabIndex,selectTow:2==t.tabIndex}},["店内就餐"==t.type?i("v-uni-view",{staticClass:"tab"},[i("v-uni-view",{staticClass:"t-top"},[i("v-uni-view",{staticClass:"t-top-box"},[[i("v-uni-text",{staticClass:"txt1"},[t._v("桌号："+t._s(t.table_num)+"号桌")]),i("i",{staticClass:"hxicon-right icon1",staticStyle:{"text-align":"right"}})]],2)],1)],1):i("v-uni-view",{staticClass:"tab"},[i("v-uni-view",{staticClass:"t-top",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.choose_address.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"t-top-box"},[t.addressData?[i("v-uni-view",{},[i("v-uni-view",{staticStyle:{"font-weight":"800"}},[t._v(t._s(t.addressData.name)+" "+t._s(t.addressData.mobile))]),i("v-uni-view",{staticStyle:{"text-align":"right"}},[i("i",{staticClass:"hxicon-right"}),i("br")])],1),t._v(t._s(t.addressData.province)+t._s(t.addressData.city)+t._s(t.addressData.detail))]:[i("v-uni-text",{staticClass:"txt1"},[t._v("暂无收货地址")]),i("i",{staticClass:"hxicon-right icon1",staticStyle:{"text-align":"right"}})]],2)],1),i("v-uni-view",{staticClass:"t-bb"})],1)],1)],1),i("v-uni-view",{staticClass:"b-r m-t container p12"},[i("v-uni-view",{staticClass:"store"},[i("v-uni-view",{staticClass:"name "},[t.storeData.store_name?i("v-uni-text",[t._v(t._s(t.storeData.store_name))]):t._e(),t.storeData.community?i("v-uni-text",[t._v("("+t._s(t.storeData.community)+")")]):t._e()],1),i("v-uni-view",{staticClass:"p-bb b-b"}),i("v-uni-view",{staticClass:"goods-box"},[t._l(t.carts,(function(e,o){return t.carts?[i("v-uni-view",{key:o+"_0",staticClass:"goods-item"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-image",{attrs:{src:t.getimg+e.good.img_id,mode:"aspectFit"}})],1),i("v-uni-view",{staticClass:"right"},[i("v-uni-view",{staticClass:"row1"},[i("v-uni-view",{staticClass:"tit"},[e.good.oldprice&&Number(e.good.price)<Number(e.good.oldprice)?i("v-uni-text",{staticClass:"zk"},[t._v("折")]):t._e(),i("v-uni-text",[t._v(t._s(e.good.name))])],1),e.good.oldprice?i("v-uni-view",{staticClass:"old-price"},[i("v-uni-text",{staticClass:"fh"},[t._v("￥")]),i("v-uni-text",{staticClass:"lt"},[t._v(t._s(e.good.oldprice))])],1):t._e(),i("v-uni-view",{staticClass:"price"},[i("v-uni-text",{staticClass:"fh"},[t._v("￥")]),i("v-uni-text",[t._v(t._s(e.good.price))])],1)],1),i("v-uni-view",{staticClass:"row2"}),t._v(t._s(e.materials_text)),i("v-uni-view",{staticClass:"row3"},[t._v("x"),i("v-uni-text",[t._v(t._s(e.number))])],1)],1)],1)]:t._e()}))],2),i("v-uni-view",{staticClass:"p-bb b-b"}),"配送"==t.type?i("list-cell",[i("v-uni-view",{staticClass:"w-100 d-flex align-items-center justify-content-between"},[i("v-uni-view",{staticClass:"d-flex align-items-center"},[i("v-uni-view",[t._v("配送费")])],1),i("v-uni-view",{staticClass:"text-color-assist"},[t._v(t._s(t.send_cost?"￥"+t.send_cost:"免费"))])],1)],1):t._e(),i("list-cell",{attrs:{arrow:!0,last:!0},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.choose_coupon.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"w-100 d-flex align-items-center justify-content-between"},[i("v-uni-view",{staticClass:"d-flex align-items-center"},[i("v-uni-view",[t._v("优惠券")])],1),i("v-uni-view",{staticClass:"text-color-assist"},[t._v(t._s(t.coupon_name?t.coupon_name:"有"+t.couponData.length+"张可用"))])],1)],1),i("list-cell",{attrs:{arrow:!0,last:!0}},[i("v-uni-view",{staticClass:"w-100 d-flex align-items-center justify-content-between overflow-hidden"},[i("v-uni-view",{staticClass:"flex-shrink-0"},[t._v("备注")]),i("v-uni-navigator",{staticClass:"flex-fill ml-40 text-truncate text-right",attrs:{"hover-class":"none","open-type":"navigate",url:"/pages/pay/remark"}},[t._v(t._s(t.remark))])],1)],1),i("v-uni-view",{staticClass:"flex-rl totalbox"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-text",[t._v("优惠规则")]),i("i",{staticClass:"hxicon-question"})],1),i("v-uni-view",{staticClass:"right"},[i("v-uni-view",{staticClass:"yh"},[i("v-uni-text",{staticClass:"txt"},[t._v("已优惠")]),i("v-uni-text",{staticClass:"fh"},[t._v("￥")]),i("v-uni-text",{staticClass:"num"},[t._v(t._s(t.coupon_price+t.reduce))])],1),i("v-uni-view",{staticClass:"total"},[i("v-uni-text",{staticClass:"txt"},[t._v("小计")]),i("v-uni-text",{staticClass:"fh"},[t._v("￥")]),i("v-uni-text",{staticClass:"num"},[t._v(t._s(t.totalPrice))])],1)],1)],1)],1)],1),i("v-uni-view",{staticClass:"body-end"}),i("v-uni-view",{staticClass:"foot"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-view",{staticClass:"price"},[i("v-uni-text",{staticClass:"fh"},[t._v("￥")]),i("v-uni-text",{staticClass:"txt"},[t._v(t._s(t.totalPrice))])],1),t.coupon_price?i("v-uni-view",{staticClass:"discount"},[i("v-uni-text",[t._v("已优惠￥"+t._s(t.coupon_price+t.reduce))])],1):t._e()],1),i("v-uni-view",{staticClass:"right",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.submit.apply(void 0,arguments)}}},[i("v-uni-text",[t._v("提交订单")])],1)],1),i("uni-popup",{ref:"popup",attrs:{type:"share"}},[i("v-uni-view",{staticClass:"coupon_box"},t._l(t.couponData,(function(e,o){return i("coupon",{key:o,attrs:{item:e,types:"carts",theme:"#ff6c00",color:"#ffffff",solid:"#ff6c00"},on:{choose_done:function(e){arguments[0]=e=t.$handleEvent(e),t.choose_done.apply(void 0,arguments)}}})})),1)],1)],1)},n=[]},9904:function(t,e,i){"use strict";i.r(e);var o=i("a4fb"),a=i("2c79");for(var n in a)"default"!==n&&function(t){i.d(e,t,(function(){return a[t]}))}(n);i("dea9");var r,s=i("f0c5"),d=Object(s["a"])(a["default"],o["b"],o["c"],!1,null,"c681da2e",null,!1,o["a"],r);e["default"]=d.exports},"9d9e":function(t,e,i){"use strict";i.r(e);var o=i("d454"),a=i.n(o);for(var n in o)"default"!==n&&function(t){i.d(e,t,(function(){return o[t]}))}(n);e["default"]=a.a},a4fb:function(t,e,i){"use strict";var o;i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return n})),i.d(e,"a",(function(){return o}));var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"coupon-item"},[i("v-uni-view",{staticClass:"coupon-money"},[t.types?t._e():i("v-uni-view",{staticClass:"nick"},[t._v(t._s(t.item.seller_name)+"使用")]),i("v-uni-view",{staticClass:"layof",style:{color:t.theme}},[t._v("￥"+t._s(t.item.reduce))]),i("v-uni-view",{staticClass:"end_time"},[t._v(t._s(t.item.end_time)+"前使用")]),t.types?t._e():i("v-uni-view",[i("v-uni-view",{staticClass:"tit"},[t._v("券号："+t._s(t.item.ticket))]),i("v-uni-view",{staticClass:"demand"},[t._v(t._s(t.item.title))])],1)],1),t.types&&t.item.is_choose?i("v-uni-view",{staticClass:"get-btn",style:{color:t.color,borderColor:t.color,background:t.solid,"background-color":"#BEBEBE"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.choose(t.item)}}},[t._v("已选择")]):t._e(),t.types&&!t.item.is_choose?i("v-uni-view",{staticClass:"get-btn",style:{color:t.color,borderColor:t.color,background:t.solid},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.choose(t.item)}}},[t._v("选择使用")]):t._e(),t.types?t._e():i("v-uni-navigator",{staticClass:"get-btn",style:{color:t.color,borderColor:t.color,background:t.solid},attrs:{url:t.item.url}},[t._v("立即使用")])],1)},n=[]},ae34:function(t,e,i){var o=i("24fb");e=o(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-6a55efd8]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.coupon_box[data-v-6a55efd8]{background:#fff;width:100%;height:auto;display:table;padding:%?6?% %?26?% %?26?% %?26?%}.pop_item[data-v-6a55efd8]{width:100%;height:50%;background-color:#fff}.coupon_list[data-v-6a55efd8]{height:40px}.b-r[data-v-6a55efd8]{-webkit-border-radius:6px;border-radius:6px}.m-t[data-v-6a55efd8]{margin-top:6px}.p-bb[data-v-6a55efd8]{margin:16px 0;height:1px}.flex-rl[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.container[data-v-6a55efd8]{margin-right:12px;background-color:#fff}.p12[data-v-6a55efd8]{padding:12px}.head[data-v-6a55efd8]{padding-top:20px}.head .tab-box[data-v-6a55efd8]{position:relative;height:40px;margin:0 12px}.head .tab-box .item[data-v-6a55efd8]{position:absolute;top:0;bottom:0;height:40px;text-align:center;font-size:14px;width:50%}.head .tab-box .item .tit-box[data-v-6a55efd8]{position:relative;height:36px;line-height:36px;-webkit-border-top-left-radius:6px;border-top-left-radius:6px;-webkit-border-top-right-radius:6px;border-top-right-radius:6px;background-color:hsla(0,0%,100%,.6);width:100%}.head .tab-box .item[data-v-6a55efd8]:first-child{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end;left:0}.head .tab-box .item[data-v-6a55efd8]:last-child{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end;right:0}.head .tab-box .active[data-v-6a55efd8]{height:40px;width:51%;font-weight:700}.head .tab-box .active .tit-box[data-v-6a55efd8]{height:40px;line-height:40px;background-color:#fff}.head .tab-box .left .tit-box[data-v-6a55efd8]{margin-left:12px;margin-right:-12px;padding-right:12px}.head .tab-box .right .tit-box[data-v-6a55efd8]{-webkit-flex-shrink:0;flex-shrink:0;margin-right:12px;margin-left:-12px;padding-left:12px}.head .tab-box .left.active .tit-box[data-v-6a55efd8]{margin:0}.head .tab-box .right.active .tit-box[data-v-6a55efd8]{margin:0}.head .tab-box .left.active .tit-box[data-v-6a55efd8]:after{content:"";position:absolute;right:-12px;bottom:0;border-top:12px solid transparent;border-right:12px solid transparent;border-bottom:36px solid #fff}.head .tab-box .right.active .tit-box[data-v-6a55efd8]:after{content:"";position:absolute;left:-12px;bottom:0;border-top:12px solid transparent;border-left:12px solid transparent;border-bottom:36px solid #fff}.head .head-bottom[data-v-6a55efd8]{overflow:hidden;background:#fff;-webkit-border-top-left-radius:6px;border-top-left-radius:6px;-webkit-border-top-right-radius:6px;border-top-right-radius:6px;-webkit-border-bottom-left-radius:6px;border-bottom-left-radius:6px;-webkit-border-bottom-right-radius:6px;border-bottom-right-radius:6px}.head .head-bottom .tab .t-top-box[data-v-6a55efd8]{margin:0;padding:12px}.head .head-bottom .tab .t-top-box .txt1[data-v-6a55efd8]{font-size:18px;color:#888}.head .head-bottom .tab .t-top-box .icon1[data-v-6a55efd8]{margin-left:8px;color:#bbb}.head .head-bottom .tab .t-top-box[data-v-6a55efd8]:active{background-color:#f5f5f5}.head .head-bottom .tab .t-bb[data-v-6a55efd8]{margin:0 12px;height:.5px;background-color:#e4e7ed}.head .head-bottom .tab .t-bottom[data-v-6a55efd8]{padding:12px}.head .head-bottom .tab .t-bottom .row1[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.head .head-bottom .tab .t-bottom .row1 .left[data-v-6a55efd8]{font-size:14px;font-weight:700}.head .head-bottom .tab .t-bottom .row1 .right[data-v-6a55efd8]{font-size:14px;color:#ff9800}.head .head-bottom .tab .t-bottom .row1 .right i[data-v-6a55efd8]{margin-left:8px;color:#bbb}.head .head-bottom .tab .t-bottom .row2[data-v-6a55efd8]{margin-top:6px;font-size:12px;color:#ff9800}.head .head-bottom.selectOne[data-v-6a55efd8]{-webkit-border-top-left-radius:0;border-top-left-radius:0;-webkit-border-top-right-radius:px;border-top-right-radius:px}.head .head-bottom.selectTow[data-v-6a55efd8]{-webkit-border-top-left-radius:6px;border-top-left-radius:6px;-webkit-border-top-right-radius:0;border-top-right-radius:0}.store[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.store .name[data-v-6a55efd8]{padding:4px 0 0;font-size:14px}.store .goods-box .goods-item[data-v-6a55efd8]{margin-top:20px;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row}.store .goods-box .goods-item .left[data-v-6a55efd8]{width:60px;height:60px}.store .goods-box .goods-item .left uni-image[data-v-6a55efd8]{-webkit-border-radius:4px;border-radius:4px;overflow:hidden;width:100%;height:100%;background-color:#f1f1f1}.store .goods-box .goods-item .right[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-flex:1;-webkit-flex:1;flex:1;padding-left:14px}.store .goods-box .goods-item .right .row1[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.store .goods-box .goods-item .right .row1 .tit[data-v-6a55efd8]{font-size:14px;color:#333;font-weight:700;-webkit-box-flex:1;-webkit-flex:1;flex:1;-webkit-flex-wrap:wrap;flex-wrap:wrap}.store .goods-box .goods-item .right .row1 .tit .zk[data-v-6a55efd8]{padding:1px 3px;font-size:10px;margin-right:8px;-webkit-border-radius:4px;border-radius:4px;background-color:#f9221d;color:#fff}.store .goods-box .goods-item .right .row1 .old-price[data-v-6a55efd8]{padding-left:12px;font-size:14px;color:#888;font-weight:700}.store .goods-box .goods-item .right .row1 .old-price .lt[data-v-6a55efd8]{text-decoration:line-through}.store .goods-box .goods-item .right .row1 .old-price .fh[data-v-6a55efd8]{font-size:10px}.store .goods-box .goods-item .right .row1 .price[data-v-6a55efd8]{font-size:16px;padding-left:12px;color:#333;font-weight:700}.store .goods-box .goods-item .right .row1 .price .fh[data-v-6a55efd8]{font-size:10px}.store .goods-box .goods-item .right .row3[data-v-6a55efd8]{font-size:10px;color:#888}.store .goods-box .goods-item[data-v-6a55efd8]:first-child{margin:0}.store .peisong .right[data-v-6a55efd8]{font-size:14px;font-weight:700}.store .peisong .left[data-v-6a55efd8]{font-size:16px;font-weight:700}.store .peisong .left .fh[data-v-6a55efd8]{font-size:10px}.store .zhekou-box .zhekou[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;margin-top:12px}.store .zhekou-box .zhekou .row1[data-v-6a55efd8]{-webkit-box-align:center;-webkit-align-items:center;align-items:center}.store .zhekou-box .zhekou .row1 .left[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:20px;line-height:20px}.store .zhekou-box .zhekou .row1 .left i[data-v-6a55efd8]{font-size:16px;color:#ff5722}.store .zhekou-box .zhekou .row1 .left .tit[data-v-6a55efd8]{font-weight:700;margin-left:6px;font-size:14px;color:#333}.store .zhekou-box .zhekou .row1 .right .tag1[data-v-6a55efd8]{font-weight:700;font-size:14px;color:#ff5722}.store .zhekou-box .zhekou .row2[data-v-6a55efd8]{height:20px;line-height:20px;font-size:12px;color:#888}.store .zhekou-box .zhekou[data-v-6a55efd8]:first-child{margin:0}.store .totalbox[data-v-6a55efd8]{-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.store .totalbox .left[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:14px;color:#888}.store .totalbox .left [class*="hxicon-"][data-v-6a55efd8]{color:#aaa;margin-left:4px;font-size:16px}.store .totalbox .right[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.store .totalbox .right .yh[data-v-6a55efd8]{color:#ff5722}.store .totalbox .right .yh .txt[data-v-6a55efd8]{color:#000;font-size:15px}.store .totalbox .right .yh .fh[data-v-6a55efd8]{font-weight:700;margin-left:3px;font-size:13px}.store .totalbox .right .yh .num[data-v-6a55efd8]{font-weight:700;font-size:18px}.store .totalbox .right .total[data-v-6a55efd8]{margin-left:16px;color:#333}.store .totalbox .right .total .txt[data-v-6a55efd8]{font-size:15px}.store .totalbox .right .total .fh[data-v-6a55efd8]{margin-left:3px;font-size:12px;font-weight:700}.store .totalbox .right .total .num[data-v-6a55efd8]{font-weight:900;font-size:22px}.privacy[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.privacy .row1[data-v-6a55efd8]{-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end}.privacy .row1 .left[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.privacy .row1 .left .icon1[data-v-6a55efd8]{color:#444;font-size:24px}.privacy .row1 .left .icon2[data-v-6a55efd8]{color:#aaa;margin-left:6px;font-size:16px}.privacy .row1 .left .txt[data-v-6a55efd8]{color:#333;margin-left:6px;font-weight:700;font-size:14px}.privacy .row2[data-v-6a55efd8]{margin-top:4px;color:#888;font-size:12px}.privacy .row3[data-v-6a55efd8]{margin-top:8px;font-size:12px;color:#ff9800}.other-box[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.other-box .row[data-v-6a55efd8]{-webkit-box-align:center;-webkit-align-items:center;align-items:center}.other-box .row .left[data-v-6a55efd8]{font-size:14px;color:#333;font-weight:700;-webkit-box-flex:1;-webkit-flex:1;flex:1}.other-box .row .right[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:center;-webkit-align-items:center;align-items:center;width:60%;font-size:14px;display:flex;-webkit-flex-direction:row;flex-direction:row;color:#aaa}.other-box .row .right [class*="hxicon-"][data-v-6a55efd8]{position:relative;top:2px;font-size:14px}.body-end[data-v-6a55efd8]{height:100px}.foot[data-v-6a55efd8]{z-index:11;position:fixed;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-border-radius:50px;border-radius:50px;overflow:hidden;bottom:12px;left:12px;right:12px;height:50px}.foot .left[data-v-6a55efd8]{padding:0 18px;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;background-color:#222;-webkit-box-flex:1;-webkit-flex:1;flex:1}.foot .left .price[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;color:#fff;height:25px;line-height:25px}.foot .left .price .fh[data-v-6a55efd8]{font-weight:700;font-size:12px}.foot .left .price .txt[data-v-6a55efd8]{font-size:22px;font-weight:700}.foot .left .discount[data-v-6a55efd8]{margin-left:2px;font-size:10px;color:#bbb}.foot .right[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;color:#222;font-weight:700;font-size:16px;padding-left:15px;padding-right:15px;-webkit-transition:all .3s;transition:all .3s;background:-webkit-linear-gradient(45deg,#ffeb3b,#ffc107);background:linear-gradient(45deg,#ffeb3b,#ffc107)}.foot .right[data-v-6a55efd8]:active{background:-webkit-linear-gradient(45deg,#e0ce31,#e4ad06);background:linear-gradient(45deg,#e0ce31,#e4ad06)}.flex-start[data-v-6a55efd8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start}.flex-start > uni-view[data-v-6a55efd8]{height:100%}.flex-start > uni-view[data-v-6a55efd8]:first-child{width:%?100?%;-webkit-flex-shrink:0;flex-shrink:0}.flex-start > uni-view[data-v-6a55efd8]:last-child{width:100%}',""]),t.exports=e},cff5:function(t,e,i){"use strict";var o=i("4ea4");i("4160"),i("a630"),i("13d5"),i("fb6a"),i("a9e3"),i("b680"),i("3ca3"),i("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("96cf");var a=o(i("1da1")),n=(o(i("73bc")),o(i("a38e")),o(i("7cc0"))),r=o(i("1991")),s=o(i("ac6d")),d=o(i("697d")),l=o(i("42bb")),c=o(i("8ff1")),f=o(i("9904")),u={components:{listCell:c.default,coupon:f.default},data:function(){return{coupon_name:"",msg:"",getimg:this.$getimg,scrollData:{},shoppingCartStorageName:"cart",storeData:{},shopcart:[],tabIndex:1,addressData:null,ysStatus:!0,couponData:[],totalPrice:0,totalYhPrice:0,totalNumber:0,totalOldPrice:0,carts:[],couponid:0,coupon_price:0,type:"",reduce:0,sku:{},send_cost:0,table_num:""}},computed:{remark:function(){return this.$store.state.remark}},onShow:function(){this.check_login()?this.get_default_address():uni.reLaunch({url:"../user/login/login"})},onLoad:function(t){var e=this;this.type=t.type,"店内就餐"==t.type&&(this.table_num=uni.getStorageSync("table_num")),e.storeData=uni.getStorageSync("merchant");var i=uni.getStorageSync("shipping_dees");this.send_cost=1*i.value,t.sid&&(e.carts=uni.getStorageSync(e.shoppingCartStorageName),e.shopcart=uni.getStorageSync("shopcart"),e.shopcart=Array.from(e.shopcart),e.totalOldPrice=e.shopcart[e.shopcart.length-1].cartPrice.toFixed(2),"配送"==e.type&&(e.totalOldPrice=1*e.totalOldPrice+1*e.send_cost,console.log("totalOldPrice",e.totalOldPrice,e.type,1*e.send_cost)),e.totalPrice=e.totalOldPrice,e.totalNumber=e.shopcart[0].cartNum,r.default.get_order_coupon({total_money:e.totalOldPrice}).then((function(t){for(var i in t.data){var o=t.data[i];o["is_choose"]=!1}e.couponData=t.data}))),e.reduce_money()},onPageScroll:function(t){this.scrollData=t},methods:{choose_done:function(t){for(var e in this.$refs.popup.close(),console.log("aaa",t),this.couponData){var i=this.couponData[e];i.id==t.id?i.is_choose=t.is_choose:i.is_choose=!1}console.log(this.couponData),this.couponid=t.coupon_id,this.coupon_price=Number(t.reduce),this.totalPrice=(1*this.totalOldPrice-1*this.coupon_price).toFixed(2),this.totalPrice<0&&(this.totalPrice=0),this.coupon_name="减"+t.reduce+"元"},choose_coupon:function(){this.couponData.length>0&&this.$refs.popup.open()},check_login:function(){var t=uni.getStorageSync("token");return!!t},choose_address:function(){},get_default_address:function(){var t=this;n.default.get_default_address().then((function(e){t.addressData=e.data}))},privacyStatusChange:function(t){this.ysStatus=t.target.value},getSystemConfig:function(){var t=this;l.default.getSystemConfig(6).then((function(e){for(var i in e.data)"shipping_dees"==e.data[i].key&&(t.send_cost=Number(e.data[i].value))}))},submit:function(){var t=this;return(0,a.default)(regeneratorRuntime.mark((function e(){var i,o,a,n,r,d;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(i=t,o=uni.getStorageSync("Dtype"),t.addressData&&t.addressData.name||"配送"!=o){e.next=5;break}return uni.showToast({title:"请选择收货地址",icon:"none"}),e.abrupt("return");case 5:for(n in a=[],i.carts)a.push(i.carts[n].id);r={goods_id:a,coupon_id:i.couponid,privacy_status:i.ysStatus?1:0,order_from:"0",payment_type:"xcx",pay_cate:"1",json:i.computeSKU(),total_price:i.totalPrice,msg:i.remark,drive_type:t.type?t.type:"配送",coupon_price:i.coupon_price,table_num:i.table_num},d=uni.getStorageSync("sjm"),r["invite_code"]=d,uni.showLoading({title:"正在生成订单"}),s.default.order_create(r).then((function(t){if(uni.hideLoading(),200==t.status){var e=t.data;uni.redirectTo({url:"../pay/pay?id="+e.id})}else uni.showToast({title:t,icon:"none"})}));case 12:case"end":return e.stop()}}),e)})))()},radioChange:function(t){var e=[];this.couponData.forEach((function(i){i.id==t.detail.value&&(e=i)})),this.couponid=e.coupon_id,this.coupon_price=Number(e.reduce),this.totalPrice=this.totalOldPrice-this.coupon_price,this.totalPrice<0&&(this.totalPrice=0)},reduce_money:function(){var t=this,e=this,i={json:e.computeSKU()};d.default.get_order_money(i).then((function(e){t.totalOldPrice=e.data.total_money,"配送"==t.type&&(t.totalOldPrice=1*t.totalOldPrice+1*t.send_cost),t.totalPrice=t.totalOldPrice,t.reduce=Number(e.data.reduce)}))},computeSKU:function(){var t=this,e={},i={};for(var o in t.carts){var a=t.carts[o],n="";if(i.goods_id=a.id,i.sku_id=a.materials_sku_id||0,i.price=a.materials_price,i.num=a.number,a.is_sku){var r=JSON.parse(a.sku[0].json),s=r.tree,d="";for(var l in s)for(var c in s[l].v)s[l].v[c].select&&(d+=s[l].v[c].id+"-");n=d.slice(0,-1),d=""}else i.price=a.price,i.is_sku=0;e[n+"-"+o]=i,n="",i={}}return e}}};e.default=u},d454:function(t,e,i){"use strict";i("a9e3"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var o={name:"ListCell",props:{arrow:{type:Boolean,default:!1},hover:{type:Boolean,default:!1},lineLeft:{type:Boolean,default:!0},lineRight:{type:Boolean,default:!1},padding:{type:String,default:"30rpx"},last:{type:Boolean,default:!1},radius:{type:Boolean,default:!1},bgcolor:{type:String,default:"#fff"},size:{type:Number,default:28},color:{type:String,default:"#343434"},index:{type:Number,default:0}},methods:{handleClick:function(){this.$emit("click",{index:this.index})}}};e.default=o},d5f4:function(t,e,i){var o=i("e02e");"string"===typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);var a=i("4f06").default;a("c5ad2bb0",o,!0,{sourceMap:!1,shadowMode:!1})},dea9:function(t,e,i){"use strict";var o=i("374b"),a=i.n(o);a.a},e02e:function(t,e,i){var o=i("24fb");e=o(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-16e75238]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.tui-list-cell[data-v-16e75238]{position:relative;width:100%;-webkit-box-sizing:border-box;box-sizing:border-box;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tui-radius[data-v-16e75238]{-webkit-border-radius:%?12?%;border-radius:%?12?%;overflow:hidden}.tui-cell-hover[data-v-16e75238]{background:#f7f7f9!important}.tui-list-cell[data-v-16e75238]::after{content:"";position:absolute;border-bottom:%?1?% solid rgba(200,199,204,.3);bottom:0;right:0;left:0}.tui-line-left[data-v-16e75238]::after{left:%?30?%!important}.tui-line-right[data-v-16e75238]::after{right:%?30?%!important}.tui-cell-last[data-v-16e75238]::after{border-bottom:0!important}.arrow[data-v-16e75238]{width:%?20?%;height:%?32?%;position:relative;-webkit-flex-shrink:0;flex-shrink:0;margin-left:%?10?%}',""]),t.exports=e},f9aa:function(t,e,i){var o=i("ae34");"string"===typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);var a=i("4f06").default;a("e40c9124",o,!0,{sourceMap:!1,shadowMode:!1})}}]);