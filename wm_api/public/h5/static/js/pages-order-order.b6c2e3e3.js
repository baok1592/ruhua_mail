(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-order-order"],{"12f0":function(e,t,i){"use strict";var n=i("4ea4");i("4160"),i("159b"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,i("96cf");var r=n(i("1da1")),a=n(i("16f8")),o=n(i("8e43")),s={data:function(){return{tabIndex:0,orderMenuIndex:0,orders:[],storeOrders:[],wmorders:[],getimg:this.$getimg}},onLoad:function(){var e=this;return(0,r.default)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,e.verifyToken();case 2:e.getOrders(0);case 3:case"end":return t.stop()}}),t)})))()},computed:{batchInvoiceVisible:function(){return!this.orderMenuIndex&&this.orders.length||this.orderMenuIndex&&this.storeOrders.length}},methods:{show_data:function(){this.getOrders(this.tabIndex),this.orderMenuIndex=0},switchTab:function(){var e=(0,r.default)(regeneratorRuntime.mark((function e(t){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(this.tabIndex!==t){e.next=2;break}return e.abrupt("return");case 2:return this.tabIndex=t,e.next=5,this.getOrders(t);case 5:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}(),handleSwiperItemChange:function(){return!0},switchMenuTab:function(e){var t=this;return(0,r.default)(regeneratorRuntime.mark((function i(){var n,r;return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(t.orderMenuIndex!==e){i.next=2;break}return i.abrupt("return");case 2:t.orderMenuIndex=e,"0"==e?(n=[],t.storeOrders.forEach((function(e){"配送"!=e.drive_type&&n.push(e)})),t.wmorders=n):(r=[],t.storeOrders.forEach((function(e){"配送"==e.drive_type&&r.push(e)})),t.wmorders=r);case 4:case"end":return i.stop()}}),i)})))()},getOrders:function(e){var t=this,i=this;0==e?a.default.get_not_order().then((function(e){i.orders=e.data})):a.default.get_all_order().then((function(e){i.storeOrders=e.data;var n=[];t.storeOrders.forEach((function(e){"配送"!=e.drive_type&&n.push(e)})),t.wmorders=n}))},deleteOrder:function(e){var t=this;uni.showModal({title:"提示",content:"是否确定删除该订单",success:function(i){i.confirm&&a.default.deleteOrder(e).then((function(e){200==e.status&&(uni.showToast({title:"删除成功"}),t.getOrders(0))}))}})},zlyd:function(){uni.switchTab({url:"../index/index"})},ckpl:function(e){uni.navigateTo({url:"../goods_list/goods_list?order_id="+e})},pay:function(e,t){0==t&&uni.navigateTo({url:"../pay/pay?id="+e})},verifyToken:function(){return(0,r.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,o.default.verifyToken().then(function(){var e=(0,r.default)(regeneratorRuntime.mark((function e(t){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(200==t.status){e.next=4;break}return e.next=3,uni.showToast({title:"请登录",icon:"none"});case 3:uni.reLaunch({url:"/pages/my/my"});case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 2:case"end":return e.stop()}}),e)})))()}}};t.default=s},3702:function(e,t,i){"use strict";var n=i("5446"),r=i.n(n);r.a},5446:function(e,t,i){var n=i("f683");"string"===typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);var r=i("4f06").default;r("8b0183ce",n,!0,{sourceMap:!1,shadowMode:!1})},"83b0":function(e,t,i){"use strict";i.r(t);var n=i("eff4"),r=i("992d");for(var a in r)"default"!==a&&function(e){i.d(t,e,(function(){return r[e]}))}(a);i("3702");var o,s=i("f0c5"),c=Object(s["a"])(r["default"],n["b"],n["c"],!1,null,"1f4e5a0c",null,!1,n["a"],o);t["default"]=c.exports},"8e43":function(e,t,i){"use strict";var n=i("4ea4");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,i("96cf");var r=n(i("1da1")),a=n(i("aa91")),o=function(){var e=(0,r.default)(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return t="index/verify_token",e.next=3,a.default.get(t).then(function(){var e=(0,r.default)(regeneratorRuntime.mark((function e(t){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t;case 2:return e.abrupt("return",e.sent);case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 3:return e.abrupt("return",e.sent);case 4:case"end":return e.stop()}}),e)})));return function(){return e.apply(this,arguments)}}(),s={verifyToken:o};t.default=s},"992d":function(e,t,i){"use strict";i.r(t);var n=i("12f0"),r=i.n(n);for(var a in n)"default"!==a&&function(e){i.d(t,e,(function(){return n[e]}))}(a);t["default"]=r.a},eff4:function(e,t,i){"use strict";var n;i.d(t,"b",(function(){return r})),i.d(t,"c",(function(){return a})),i.d(t,"a",(function(){return n}));var r=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-uni-view",{staticClass:"container"},[i("v-uni-view",{staticClass:"tabbar"},[i("v-uni-view",{staticClass:"item",class:{active:!e.tabIndex},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.switchTab(0)}}},[e._v("当前订单")]),i("v-uni-view",{staticClass:"item",class:{active:e.tabIndex},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.switchTab(1)}}},[e._v("历史订单")])],1),i("v-uni-swiper",{staticClass:"swiper",attrs:{current:e.tabIndex,duration:300,"show-scrollbar":!1}},[i("v-uni-swiper-item",{on:{touchmove:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.handleSwiperItemChange.apply(void 0,arguments)}}},[e.orders.length?i("v-uni-scroll-view",{staticClass:"orders-scroll1",attrs:{"scroll-y":"true"}},[i("v-uni-view",{staticClass:"wrapper"},[i("v-uni-view",{staticClass:"order-list"},e._l(e.orders,(function(t,n){return i("v-uni-view",{key:n,staticClass:"order"},[i("v-uni-view",{staticClass:"header"},[i("v-uni-view",{staticClass:"flex-fill font-size-medium"},[e._v(e._s(t.id))]),i("v-uni-view",{staticClass:"status"},[i("v-uni-view",[e._v(e._s(t.payment_state?"已支付":"未支付"))]),i("v-uni-image",{attrs:{src:"/static/images/common/black_arrow_right.png"}})],1)],1),i("v-uni-navigator",{attrs:{"open-type":"navigate",url:"/pages/order/detail?id="+t.order_id}},[i("v-uni-view",{staticClass:"images"},[i("v-uni-image",{attrs:{src:e.getimg+t.ordergoods[0].pic}}),i("v-uni-view",{staticClass:"good_name"},[e._v(e._s(t.ordergoods[0].goods_name))])],1),i("v-uni-view",{staticClass:"info"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-view",[e._v("订单编号："+e._s(t.order_num))]),i("v-uni-view",[e._v("下单时间："+e._s(t.created_at))])],1),i("v-uni-view",{staticClass:"right"},[e._v("￥"+e._s(t.order_money))])],1)],1),i("v-uni-view",{staticClass:"action"},[0==t.payment_state?i("v-uni-view",{staticClass:"button button_pay",attrs:{"hover-class":"none"},on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.pay(t.order_id,t.payment_state)}}},[e._v("去支付")]):e._e(),0==t.payment_state?i("v-uni-view",{staticClass:"button button_del",attrs:{"hover-class":"none"},on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.deleteOrder(t.order_id)}}},[e._v("删除")]):e._e(),2==t.state?i("v-uni-view",[e._v("已评论")]):0!=t.state&&1==t.payment_state?i("v-uni-view",{staticClass:"button",attrs:{"hover-class":"none"},on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.ckpl(t.order_id)}}},[e._v("去评论")]):e._e()],1)],1)})),1)],1)],1):i("v-uni-view",{staticClass:"no-order-content"},[i("v-uni-image",{attrs:{src:"https://go.cdn.heytea.com/storage/ad/2020/05/20/0bdb360866d94aa4a4404c0b676a1982.jpg"}}),i("v-uni-view",{staticClass:"tips"},[i("v-uni-view",[e._v("您今天还没有下单")]),i("v-uni-view",[e._v("快去选择一杯喜欢的饮品吧")])],1),i("v-uni-button",{staticClass:"font-size-lg",attrs:{type:"primary","hover-class":"none"},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.zlyd()}}},[e._v("去下单")])],1)],1),i("v-uni-swiper-item",{on:{touchmove:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.handleSwiperItemChange.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"history-order"},[i("v-uni-view",{staticClass:"menu"},[i("v-uni-view",{staticClass:"flex-fill d-flex justify-content-start"},[i("v-uni-view",{staticClass:"item",class:{active:!e.orderMenuIndex},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.switchMenuTab(0)}}},[e._v("店内订单")]),i("v-uni-view",{staticClass:"item",class:{active:e.orderMenuIndex},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.switchMenuTab(1)}}},[e._v("外卖订单")])],1)],1),i("v-uni-swiper",{staticClass:"history-order-swiper",attrs:{current:e.orderMenuIndex,duration:300,"show-scrollbar":!1}},[i("v-uni-swiper-item",{on:{touchmove:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.handleSwiperItemChange.apply(void 0,arguments)}}},[i("v-uni-scroll-view",{staticClass:"orders-scroll",attrs:{"scroll-y":"true"}},[i("v-uni-view",{staticClass:"wrapper"},[i("v-uni-view",{staticClass:"order-list"},e._l(e.wmorders,(function(t,n){return i("v-uni-view",{key:n,staticClass:"order"},[i("v-uni-view",{staticClass:"header"},[i("v-uni-view",{staticClass:"flex-fill font-size-medium"},[e._v(e._s(t.id))]),i("v-uni-view",{staticClass:"status"},[i("v-uni-view",[e._v(e._s(t.payment_state?"已支付":"未支付"))]),i("v-uni-image",{attrs:{src:"/static/images/common/black_arrow_right.png"}})],1)],1),i("v-uni-navigator",{attrs:{"open-type":"navigate",url:"/pages/order/detail?id="+t.order_id}},[i("v-uni-view",{staticClass:"images"},[i("v-uni-image",{attrs:{src:e.getimg+t.ordergoods[0].pic}}),i("v-uni-view",{staticClass:"good_name"},[e._v(e._s(t.ordergoods[0].goods_name))])],1),i("v-uni-view",{staticClass:"info"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-view",[e._v("订单编号："+e._s(t.order_num))]),i("v-uni-view",[e._v("下单时间："+e._s(t.created_at))])],1),i("v-uni-view",{staticClass:"right"},[e._v("￥"+e._s(t.order_money))])],1)],1),i("v-uni-view",{staticClass:"action"},[2==t.state?i("v-uni-view",[e._v("已评论")]):0!=t.state&&1==t.payment_state?i("v-uni-view",{staticClass:"button",attrs:{"hover-class":"none"},on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.ckpl(t.order_id)}}},[e._v("去评论")]):e._e(),0!=t.state?i("v-uni-view",{staticClass:"button button_re",attrs:{"hover-class":"none"},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.zlyd()}}},[e._v("再来一单")]):e._e()],1)],1)})),1)],1)],1)],1),i("v-uni-swiper-item",{on:{touchmove:function(t){t.stopPropagation(),arguments[0]=t=e.$handleEvent(t),e.handleSwiperItemChange.apply(void 0,arguments)}}},[i("v-uni-scroll-view",{staticClass:"orders-scroll",attrs:{"scroll-y":"true"}},[i("v-uni-view",{staticClass:"wrapper"},[i("v-uni-view",{staticClass:"order-list"},e._l(e.wmorders,(function(t,n){return i("v-uni-view",{key:n,staticClass:"order"},[i("v-uni-view",{staticClass:"header"},[i("v-uni-view",{staticClass:"flex-fill font-size-medium"},[e._v(e._s(t.id))]),i("v-uni-view",{staticClass:"status"},[i("v-uni-view",[e._v(e._s(t.payment_state?"已支付":"未支付"))]),i("v-uni-image",{attrs:{src:"/static/images/common/black_arrow_right.png"}})],1)],1),i("v-uni-navigator",{attrs:{"open-type":"navigate",url:"/pages/order/detail?id="+t.order_id}},[i("v-uni-view",{staticClass:"images"},[i("v-uni-image",{attrs:{src:e.getimg+t.ordergoods[0].pic}}),i("v-uni-view",{staticClass:"good_name"},[e._v(e._s(t.ordergoods[0].goods_name))])],1),i("v-uni-view",{staticClass:"info"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-view",[e._v("订单编号："+e._s(t.order_num))]),i("v-uni-view",[e._v("下单时间："+e._s(t.created_at))])],1),i("v-uni-view",{staticClass:"right"},[e._v("￥"+e._s(t.order_money))])],1)],1),i("v-uni-view",{staticClass:"action"},[2==t.state?i("v-uni-view",[e._v("已评论")]):0!=t.state&&1==t.payment_state?i("v-uni-view",{staticClass:"button",attrs:{"hover-class":"none"},on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.ckpl(t.order_id)}}},[e._v("去评论")]):e._e(),0!=t.state?i("v-uni-view",{staticClass:"button button_re",attrs:{"hover-class":"none"},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.zlyd()}}},[e._v("再来一单")]):e._e()],1)],1)})),1)],1)],1)],1)],1)],1)],1)],1)],1)},a=[]},f683:function(e,t,i){var n=i("24fb");t=n(!1),t.push([e.i,'@charset "UTF-8";\r\n/**\r\n * 这里是app内置的常用样式变量\r\n *\r\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */\r\n/* coolc-coupon 插件 */uni-page-body[data-v-1f4e5a0c]{background-color:#f6f6f6}.navbar[data-v-1f4e5a0c]{height:calc(44px + 0px);height:44px;display:-webkit-box;display:-webkit-flex;display:flex;background-color:#fff}.talk-btn[data-v-1f4e5a0c]{height:32px;margin-left:10px;margin-top:26px;margin-top:6px;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:%?24?%!important;padding:0 %?20?%;-webkit-border-radius:50rem!important;border-radius:50rem!important}.talk-btn uni-image[data-v-1f4e5a0c]{width:%?40?%;height:%?40?%;margin-right:%?10?%}.tabbar[data-v-1f4e5a0c]{height:%?100?%;background-color:#fff;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-justify-content:space-around;justify-content:space-around}.tabbar .item[data-v-1f4e5a0c]{height:100%;font-size:%?32?%;color:#999;font-weight:400!important;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tabbar .item.active[data-v-1f4e5a0c]{color:#343434;border-bottom:%?4?% solid #343434}.swiper[data-v-1f4e5a0c]{width:100%;height:calc(100vh - 44px);height:calc(100vh - 100px)}.no-order-content[data-v-1f4e5a0c]{width:100%;height:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.no-order-content uni-image[data-v-1f4e5a0c]{width:%?300?%;height:%?300?%;margin-bottom:%?50?%}.no-order-content .tips[data-v-1f4e5a0c]{color:#999;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center;line-height:1.2rem!important;margin-bottom:%?70?%}.no-order-content uni-button[data-v-1f4e5a0c]{width:50%}.history-order[data-v-1f4e5a0c]{width:100%;height:100%;position:relative}.history-order .menu[data-v-1f4e5a0c]{padding:%?18?% %?30?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?26?%;color:#666;position:fixed;top:0;left:0;right:0;z-index:10}.history-order .menu .item[data-v-1f4e5a0c]{padding:%?14?% %?30?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.history-order .menu .item uni-image[data-v-1f4e5a0c]{width:%?40?%;height:%?40?%;margin-right:%?10?%}.history-order .menu .item.active[data-v-1f4e5a0c]{color:#dba871;background-color:#fff}.history-order .history-order-swiper[data-v-1f4e5a0c]{width:100%;height:100%}.store-order-wrapper[data-v-1f4e5a0c]{width:100%;height:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:%?26?%;color:#999;line-height:1.3rem!important}.store-order-wrapper uni-image[data-v-1f4e5a0c]{width:%?400?%;height:%?333?%;margin-bottom:%?40?%}.orders-scroll[data-v-1f4e5a0c]{width:100%;height:100%;padding-top:%?104?%}.orders-scroll1[data-v-1f4e5a0c]{width:100%;height:100%;padding-top:%?10?%}.good_name[data-v-1f4e5a0c]{padding-left:%?30?%;padding-top:%?15?%;color:#555;font-weight:600}.order-list[data-v-1f4e5a0c]{display:-webkit-box;display:-webkit-flex;display:flex;width:100%;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.order-list .order[data-v-1f4e5a0c]{background-color:#fff;padding:%?30?% %?40?%;margin-bottom:%?18?%}.order-list .order .header[data-v-1f4e5a0c]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.order-list .order .header .status[data-v-1f4e5a0c]{font-size:%?26?%;color:#666;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.order-list .order .header .status uni-image[data-v-1f4e5a0c]{width:%?30?%;height:%?30?%;margin-left:%?10?%}.order-list .order .images[data-v-1f4e5a0c]{display:-webkit-box;display:-webkit-flex;display:flex;padding:%?30?% 0}.order-list .order .images uni-image[data-v-1f4e5a0c]{-webkit-flex-shrink:0;flex-shrink:0;width:%?150?%;height:%?112.5?%}.order-list .order .info[data-v-1f4e5a0c]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;margin-bottom:%?30?%}.order-list .order .info .left[data-v-1f4e5a0c]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;font-size:%?26?%;color:#666}.order-list .order .info .left > uni-view[data-v-1f4e5a0c]{margin-bottom:%?10?%;font-size:.8rem}.order-list .order .info .left > uni-view[data-v-1f4e5a0c]:last-child{margin-bottom:0}.order-list .order .info .right[data-v-1f4e5a0c]{font-size:%?32?%;color:#343434}.order-list .order .action[data-v-1f4e5a0c]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.order-list .order .action uni-button[data-v-1f4e5a0c]{margin-left:%?30?%;font-size:%?24?%}.order-list .button[data-v-1f4e5a0c]{margin-left:%?30?%;padding:%?15?% %?20?%;font-size:%?24?%;-webkit-border-radius:%?70?%;border-radius:%?70?%;background-color:#eee}.order-list .button_pay[data-v-1f4e5a0c]{background-color:#dba871;color:#fff;border:none;-webkit-border-radius:%?70?%;border-radius:%?70?%}.order-list .button_del[data-v-1f4e5a0c]{color:#fff;background-color:#f56c6c}.order-list .button_re[data-v-1f4e5a0c]{color:#fff;background-color:#5cb87a}body.?%PAGE?%[data-v-1f4e5a0c]{background-color:#f6f6f6}',""]),e.exports=t}}]);