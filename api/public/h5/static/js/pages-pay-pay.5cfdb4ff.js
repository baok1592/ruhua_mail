(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-pay-pay"],{"0b90":function(t,i,e){"use strict";e.r(i);var n=e("2807"),o=e("ac52");for(var a in o)"default"!==a&&function(t){e.d(i,t,(function(){return o[t]}))}(a);e("4886");var r,c=e("f0c5"),l=Object(c["a"])(o["default"],n["b"],n["c"],!1,null,"02a056dc",null,!1,n["a"],r);i["default"]=l.exports},"205e":function(t,i,e){var n=e("a1a4");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var o=e("4f06").default;o("0a2c1fd7",n,!0,{sourceMap:!1,shadowMode:!1})},2807:function(t,i,e){"use strict";var n;e.d(i,"b",(function(){return o})),e.d(i,"c",(function(){return a})),e.d(i,"a",(function(){return n}));var o=function(){var t=this,i=t.$createElement,n=t._self._c||i;return n("v-uni-view",{staticClass:"pay"},[n("v-uni-view",{staticClass:"head"},[n("v-uni-view",{staticClass:"row"},[t.countdownStr?n("v-uni-text",[t._v("支付剩余时间 "+t._s(t.countdownStr))]):n("v-uni-text",[t._v("重新提交订单")])],1),n("v-uni-view",{staticClass:"row pricebox pt-8"},[n("v-uni-text",{staticClass:"fh"},[t._v("￥")]),n("v-uni-text",{staticClass:"txt1"},[t._v(t._s(t.orderInfo.order_money))])],1),n("v-uni-view",{staticClass:"row pt-4",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.doOrder.apply(void 0,arguments)}}},[n("v-uni-text",[t._v(t._s(t.orderInfo.store_name))]),t.orderInfo.store_community?n("v-uni-text",[t._v("（"+t._s(t.orderInfo.store_community)+"）")]):t._e(),n("v-uni-text",[t._v("订单详情")]),n("i",{staticClass:"hxicon-right"})],1)],1),n("v-uni-view",{staticClass:"container"},[n("v-uni-radio-group",{staticClass:"list-box",on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.payChange.apply(void 0,arguments)}}},[t._l(t.payData,(function(i,o){return[n("v-uni-view",{key:o+"_0",staticClass:"flex-rl list-item"},[n("v-uni-view",{staticClass:"left"},[n("v-uni-view",{staticClass:"iconbox"},[n("v-uni-image",{staticClass:"icon-img",attrs:{src:e("f3df"),mode:""}})],1)],1),n("v-uni-view",{staticClass:"b-b right"},[n("v-uni-view",{staticClass:"tit-box"},[n("v-uni-text",{staticClass:"tit"},[t._v(t._s(i.name))])],1),n("v-uni-radio",{attrs:{value:i.id,color:"#ffc107",checked:1==i.default}})],1)],1)]}))],2)],1),n("v-uni-view",{staticClass:"btn",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.submitPay.apply(void 0,arguments)}}},[n("v-uni-text",[t._v("确认支付")])],1)],1)},a=[]},4886:function(t,i,e){"use strict";var n=e("205e"),o=e.n(n);o.a},"8bb9":function(t,i,e){"use strict";var n=e("4ea4");e("e25e"),e("ac1f"),e("5319"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var o=n(e("73bc")),a=n(e("ac6d")),r={onLoad:function(t){t.id&&(this.orderID=t.id),this.show_data()},data:function(){return{orderID:0,pay_cate:"",countdownStr:"00:00",orderInfo:{},payType:1,payData:[{id:"wxpay",name:"微信支付",icon:"hxicon-weixinzhifu",icon_color:"#09bb07",default:1}]}},methods:{show_data:function(){var t=this,i=this;this.orderID&&o.default.get_one_order(this.orderID).then((function(e){i.orderInfo=e.data.order,t.orderInfo["expiration_date"]=e.data.order.updated_at,i.countdown()}))},payChange:function(t){console.log(t);var i=t.target.value;this.payType="wxpay"==i?1:2},doOrder:function(){uni.showModal({content:"这是查看订单的事件",showCancel:!1,confirmColor:"#999",success:function(t){}})},countdown:function(){var t=new Date(this.orderInfo.expiration_date.replace(/-/g,"/")),i=new Date;if(t.getTime()){var e=t.getTime()+18e5-i.getTime();if(e<=0)return this.countdownStr="",void this.showPrompt();var n=parseInt(e/1e3%60),o=parseInt(e/1e3/60%60),a=parseInt(e/1e3/60/60%24);n<10&&(n="0"+n),o<10&&(o="0"+o);var r=o+":"+n;a>0&&(r=a+":"+r),this.countdownStr=r,setTimeout(this.countdown,1e3)}},showPrompt:function(){uni.showModal({content:"支付超时，请重新下单",showCancel:!1,confirmText:"重新下单",confirmColor:"#999",success:function(t){t.confirm&&uni.switchTab({url:"../index/index"})}})},submitPay:function(){var t=this;if(""!=this.countdownStr){var i={pay_cate:this.payType,id:this.orderID};a.default.H5_order_pay(i).then((function(i){200!=i.status&&(uni.showToast({title:"支付失败",icon:"none"}),setTimeout((function(){uni.switchTab({url:"../order/order"})}),1e3)),t.wxPay(i.data)}))}else this.showPrompt()},wxPay:function(t){"undefined"==typeof WeixinJSBridge?document.addEventListener?document.addEventListener("WeixinJSBridgeReady",jsApiCall,!1):document.attachEvent&&(document.attachEvent("WeixinJSBridgeReady",jsApiCall),document.attachEvent("onWeixinJSBridgeReady",jsApiCall)):this.jsApiCall(t)},jsApiCall:function(t){var i=this;WeixinJSBridge.invoke("getBrandWCPayRequest",t,(function(t){WeixinJSBridge.log("a:",t.err_msg),"get_brand_wcpay_request:ok"==t.err_msg?console.log("支付成功"):"get_brand_wcpay_request:cancel"==t.err_msg?console.log("取消支付"):console.log("支付失败"),1!=this.is_kai?setTimeout((function(){uni.redirectTo({url:"../order/order"})}),1e3):uni.navigateTo({url:"../invite/invite?id="+i.pid})}))},wx_pay:function(t){uni.requestPayment({provider:"wxpay",timeStamp:t.timeStamp,nonceStr:t.nonceStr,package:t.package,signType:t.signType,paySign:t.paySign,success:function(t){console.log("success:"+JSON.stringify(t)),uni.switchTab({url:"../order/order"})},fail:function(t){uni.showToast({title:"支付失败",icon:"none"}),setTimeout((function(){uni.switchTab({url:"../order/order"})}),1e3)}})}}};i.default=r},a1a4:function(t,i,e){var n=e("24fb");i=n(!1),i.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-02a056dc]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */uni-page-body[data-v-02a056dc]{background-color:#f1f1f1}.pay .pt-8[data-v-02a056dc]{margin-top:8px}.pay .pt-4[data-v-02a056dc]{margin-top:4px}.pay .flex-rl[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.pay .pay-back[data-v-02a056dc]{width:100%;text-align:center;max-height:44px}.pay .pay-tit[data-v-02a056dc]{margin:0 auto;font-size:16px}.pay .head[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;padding:30px 15px}.pay .head .row[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:12px;color:#888}.pay .head .row .fh[data-v-02a056dc]{font-size:16px;font-weight:700;color:#000}.pay .head .row .txt1[data-v-02a056dc]{font-size:34px;font-weight:700;color:#000}.pay .head .row [class*="hxicon-"][data-v-02a056dc]{position:relative;top:3px;margin-left:3px}.pay .head .pricebox[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline}.pay .container[data-v-02a056dc]{width:95%;-webkit-border-radius:10px;border-radius:10px;background-color:#fff;overflow:hidden;padding:0 8px 0 14px;margin:0 auto}.pay .container .list-box[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.pay .container .list-box .list-item[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:50px}.pay .container .list-box .list-item .left[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.pay .container .list-box .list-item .left .iconbox[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:24px;width:24px;-webkit-border-radius:4px;border-radius:4px}.pay .container .list-box .list-item .left .iconbox [class*="hxicon-"][data-v-02a056dc]{font-size:22px;color:#fff}.pay .container .list-box .list-item .left .iconbox .icon-img[data-v-02a056dc]{width:%?45?%;height:%?45?%}.pay .container .list-box .list-item .right[data-v-02a056dc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-flex:1;-webkit-flex:1;flex:1;height:100%}.pay .container .list-box .list-item .right .tit-box[data-v-02a056dc]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.pay .container .list-box .list-item .right .tit-box .tit[data-v-02a056dc]{font-size:16px;color:#333;margin-left:6px}.pay .btn[data-v-02a056dc]{position:fixed;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-border-radius:10px;border-radius:10px;overflow:hidden;bottom:15px;left:15px;right:15px;height:45px;font-size:16px;font-weight:700;color:#333;background:-webkit-linear-gradient(45deg,#ffd900,#ffc107);background:linear-gradient(45deg,#ffd900,#ffc107)}body.?%PAGE?%[data-v-02a056dc]{background-color:#f1f1f1}',""]),t.exports=i},ac52:function(t,i,e){"use strict";e.r(i);var n=e("8bb9"),o=e.n(n);for(var a in n)"default"!==a&&function(t){e.d(i,t,(function(){return n[t]}))}(a);i["default"]=o.a},f3df:function(t,i){t.exports="data:image/png;base64,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"}}]);