(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-gifts-gifts"],{"0315":function(t,e,i){var a=i("c4e2");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("3d4ea9ed",a,!0,{sourceMap:!1,shadowMode:!1})},"0b40":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var a={uniPopup:i("127e").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("uni-popup",{ref:"popup",attrs:{type:"bottom"}},[i("v-uni-view",{staticClass:"card-popup"},[i("v-uni-view",{staticClass:"header"},[i("v-uni-image",{staticClass:"close-btn",attrs:{src:"/static/images/common/gift_icon_close_new.png"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.close.apply(void 0,arguments)}}})],1),i("v-uni-view",{staticClass:"unit-set"},[i("v-uni-image",{staticClass:"product-img",attrs:{src:t.product.image_url,mode:"widthFix"}}),i("v-uni-view",[t._v(t._s(t.product.name))])],1),i("v-uni-view",{staticClass:"content"},[i("v-uni-view",{staticClass:"row sku-list-row"},[i("v-uni-view",{staticClass:"label"},[t._v("选择面额：")]),t.product.sku_list?i("v-uni-picker",{attrs:{mode:"selector",value:t.selectedSkuIndex,range:t.product.sku_list,"range-key":"card_amount"},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.skuPickerChange.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"sku-list-picker"},[i("v-uni-view",{staticClass:"price"},[t._v("￥"+t._s(t.product.sku_list[t.selectedSkuIndex].card_amount))]),i("v-uni-image",{staticClass:"down-icon",attrs:{src:"/static/images/common/icon-drop-down.png"}})],1)],1):t._e()],1),i("v-uni-view",{staticClass:"row"},[i("v-uni-view",{staticClass:"label"},[t._v("温馨提示：")]),i("v-uni-view",{staticClass:"desc"},[t._v("成功购买阿喜有礼电子卡后，可在【我的】-【阿喜有礼】-【购买历史】-【查看详情】-【申请发票】申请预付卡发票")])],1),i("v-uni-view",{staticClass:"row"},[i("v-uni-view",{staticClass:"label"},[t._v("购买须知：")]),i("v-uni-view",{staticClass:"desc"},[t._v("购买即视为阅读并同意"),i("v-uni-navigator",{staticClass:"tips",attrs:{"hover-class":"none"}},[t._v("《使用须知》")]),t._v("及"),i("v-uni-navigator",{staticClass:"tips",attrs:{"hover-class":"none"}},[t._v("《喜茶单用途商业预付卡章程》")])],1)],1)],1),i("v-uni-button",{staticClass:"submit-btn",attrs:{type:"primary"}},[t._v("确认支付￥"+t._s(t.product.sku_list&&t.product.sku_list[t.selectedSkuIndex].card_amount))])],1)],1)},s=[]},"191a":function(t,e,i){var a=i("701e");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("4341cdf2",a,!0,{sourceMap:!1,shadowMode:!1})},"701e":function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-21b2c4d6]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.tab-bar[data-v-21b2c4d6]{z-index:10;background-color:#fff;position:fixed;top:0;top:var(--window-top);width:100%;height:%?100?%;color:#666;font-size:%?32?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:stretch;-webkit-align-items:stretch;align-items:stretch;-webkit-box-pack:space-evenly;-webkit-justify-content:space-evenly;justify-content:space-evenly}.tab-bar .item[data-v-21b2c4d6]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;position:relative}.tab-bar .item.active[data-v-21b2c4d6]{color:#343434}.tab-bar .item.active[data-v-21b2c4d6]:after{content:" ";position:absolute;bottom:0;width:30%;left:35%;height:%?6?%;background-color:#dba871}.tab-panes[data-v-21b2c4d6]{padding-top:%?100?%;height:100%;overflow-y:scroll}.gift-cards[data-v-21b2c4d6]{margin-bottom:%?80?%}.category-list .header[data-v-21b2c4d6]{padding:%?30?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.category-list .header .title[data-v-21b2c4d6]{font-size:%?32?%;color:#343434;font-weight:700!important}.category-list .header .more[data-v-21b2c4d6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?24?%;color:#999}.category-list .header .more uni-image[data-v-21b2c4d6]{width:%?20?%;height:%?32?%}.category-list .product-list[data-v-21b2c4d6]{padding-left:%?30?%;height:%?270?%}.category-list .product-list .product .product-image[data-v-21b2c4d6]{-webkit-border-radius:%?12?%;border-radius:%?12?%;width:%?447?%;height:%?260?%;-webkit-box-shadow:0 0 %?20?% 0 rgba(200,199,204,.6);box-shadow:0 0 %?20?% 0 rgba(200,199,204,.6)}.bottom[data-v-21b2c4d6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?24?%;color:#999;padding:%?30?% 0}.bottom .divider[data-v-21b2c4d6]{width:%?2?%;background-color:#999;height:.6rem;margin:0 %?40?%}.my-gift-cards-swiper[data-v-21b2c4d6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.my-gift-cards-swiper .header[data-v-21b2c4d6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding:%?20?% %?30?%;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.my-gift-cards-swiper .header .tab-bar-2[data-v-21b2c4d6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.my-gift-cards-swiper .header .tab-bar-2 .item[data-v-21b2c4d6]{padding:%?10?% %?30?%;font-size:%?26?%;color:#999;font-weight:700!important}.my-gift-cards-swiper .header .tab-bar-2 .item.active[data-v-21b2c4d6]{background-color:#fff;color:#dba871}.my-gift-cards-swiper .header .right[data-v-21b2c4d6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;color:#dba871;font-size:%?26?%}.my-gift-cards-swiper .header .right uni-image[data-v-21b2c4d6]{width:%?34?%;height:%?28?%;margin-right:%?10?%}.my-gift-cards-swiper .content[data-v-21b2c4d6]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.giftcard-empty-img[data-v-21b2c4d6]{margin-top:%?100?%;width:%?438?%;height:%?291?%}',""]),t.exports=e},7069:function(t,e,i){"use strict";var a=i("4ea4");i("4de4"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("96cf");var n=a(i("1da1")),s=a(i("df83")),r={components:{CardPopup:s.default},data:function(){return{giftCards:[],tabBars:["购买阿喜有礼","我的阿喜有礼"],currentTabIndex:0,currentTab2Index:0,myGiftCards:[],product:{}}},onLoad:function(){var t=this;return(0,n.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$api("giftCards");case 2:t.giftCards=e.sent;case 3:case"end":return e.stop()}}),e)})))()},computed:{MyCanUseGiftCards:function(){return this.myGiftCards.filter((function(t){return 1==t.status}))},myInactiveGiftCards:function(){return this.myGiftCards.filter((function(t){return 0==t.status}))}},methods:{handleTabChange:function(t){this.currentTabIndex=t},handleSwiperItemChange:function(){return!0},handleTab2Change:function(t){this.currentTab2Index=t},openCardPopup:function(t){this.product=t,this.$refs["cardPopup"].open()}}};e.default=r},"71bd":function(t,e,i){"use strict";var a=i("191a"),n=i.n(a);n.a},"88b2":function(t,e,i){"use strict";var a=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("127e")),s={name:"CardPopup",components:{uniPopup:n.default},props:{product:{type:Object,default:function(){}}},data:function(){return{selectedSkuIndex:0}},methods:{open:function(){this.$refs["popup"].open()},close:function(){this.selectedSkuIndex=0,this.$refs["popup"].close()},skuPickerChange:function(t){this.selectedSkuIndex=t.target.value}}};e.default=s},"8bde":function(t,e,i){"use strict";i.r(e);var a=i("88b2"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},a0e2:function(t,e,i){"use strict";i.r(e);var a=i("7069"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},c4e2:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-63d3a2e1]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.card-popup[data-v-63d3a2e1]{padding:%?40?%;background-color:#fff;-webkit-border-radius:%?40?% %?40?% 0 0;border-radius:%?40?% %?40?% 0 0}.header[data-v-63d3a2e1]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end}.header .close-btn[data-v-63d3a2e1]{width:%?48?%;height:%?48?%}.unit-set[data-v-63d3a2e1]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?32?%;color:#343434;margin-bottom:%?30?%}.unit-set .product-img[data-v-63d3a2e1]{width:%?536?%;-webkit-border-radius:%?12?%;border-radius:%?12?%;-webkit-box-shadow:0 %?10?% %?10?% 0 rgba(200,199,204,.6);box-shadow:0 %?10?% %?10?% 0 rgba(200,199,204,.6);margin-bottom:%?30?%}.content .row[data-v-63d3a2e1]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;margin-bottom:%?20?%}.content .row .label[data-v-63d3a2e1]{font-size:%?26?%;color:#343434;-webkit-flex-shrink:0;flex-shrink:0}.content .row .desc[data-v-63d3a2e1]{font-size:%?24?%;color:#999}.content .row .desc .tips[data-v-63d3a2e1]{display:inline-block;color:#dba871}.content .sku-list-row[data-v-63d3a2e1]{padding:%?10?% 0;border-bottom:%?1?% solid #c8c7cc;margin-bottom:%?40?%;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.content .sku-list-row .sku-list-picker[data-v-63d3a2e1]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.content .sku-list-row .sku-list-picker .price[data-v-63d3a2e1]{font-family:neutra;font-size:%?48?%;color:#343434;font-weight:700!important}.content .sku-list-row .sku-list-picker .down-icon[data-v-63d3a2e1]{width:%?30?%;height:%?30?%;margin-left:%?10?%}.submit-btn[data-v-63d3a2e1]{font-size:%?32?%;width:100%;margin-top:%?50?%}',""]),t.exports=e},c94e:function(t,e,i){"use strict";var a=i("0315"),n=i.n(a);n.a},d92f:function(t,e,i){"use strict";var a;i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"container"},[i("v-uni-view",{staticClass:"tab-bar"},t._l(t.tabBars,(function(e,a){return i("v-uni-view",{key:a,staticClass:"item",class:{active:t.currentTabIndex==a},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleTabChange(a)}}},[t._v(t._s(e))])})),1),i("v-uni-swiper",{staticClass:"tab-panes",attrs:{duration:400,current:t.currentTabIndex}},[i("v-uni-swiper-item",{staticClass:"gift-cards-swiper h-100",on:{touchmove:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.handleSwiperItemChange.apply(void 0,arguments)}}},[i("v-uni-scroll-view",{staticClass:"h-100",attrs:{"scroll-y":"true"}},[i("v-uni-image",{staticClass:"w-100",attrs:{src:"https://static.heytea.com/taro_trial/v1/img/my/img_gift_card_banner.png",mode:"widthFix"}}),i("v-uni-view",{staticClass:"gift-cards"},t._l(t.giftCards,(function(e,a){return i("v-uni-view",{key:a,staticClass:"category-list"},[i("v-uni-view",{staticClass:"header"},[i("v-uni-view",{staticClass:"title"},[t._v(t._s(e.name))]),i("v-uni-view",{staticClass:"more"},[i("v-uni-view",[t._v("查看更多")]),i("v-uni-image",{attrs:{src:"/static/images/common/icon_jump_black3.png"}})],1)],1),i("v-uni-swiper",{staticClass:"product-list",attrs:{duration:500,"next-margin":"220rpx"}},t._l(e.product_list,(function(e,a){return i("v-uni-swiper-item",{key:a,staticClass:"product"},[i("v-uni-image",{staticClass:"product-image",attrs:{src:e.image_url},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.openCardPopup(e)}}})],1)})),1)],1)})),1),i("v-uni-view",{staticClass:"bottom"},[i("v-uni-view",[t._v("使用须知")]),i("v-uni-view",{staticClass:"divider"}),i("v-uni-view",[t._v("预付卡章程")])],1)],1)],1),i("v-uni-swiper-item",{staticClass:"my-gift-cards-swiper",on:{touchmove:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.handleSwiperItemChange.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"header"},[i("v-uni-view",{staticClass:"tab-bar-2"},[i("v-uni-view",{staticClass:"item",class:{active:0==t.currentTab2Index},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleTab2Change(0)}}},[t._v("可使用(0)")]),i("v-uni-view",{staticClass:"item",class:{active:1==t.currentTab2Index},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleTab2Change(1)}}},[t._v("未激活(0)")])],1),i("v-uni-view",{staticClass:"right"},[i("v-uni-image",{attrs:{src:"/static/images/my/icon_giftcard.png"}}),i("v-uni-view",[t._v("阿喜有礼卡兑换")])],1)],1),i("v-uni-view",{staticClass:"content"},[i("v-uni-swiper",{staticClass:"h-100",attrs:{duration:400,current:t.currentTab2Index},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),function(e){return t.handleTab2Change(e.detail.current)}.apply(void 0,arguments)}}},[i("v-uni-swiper-item",[i("v-uni-view",{staticClass:"h-100 d-flex flex-column align-items-center"},[t.MyCanUseGiftCards.length?t._e():[i("v-uni-image",{staticClass:"giftcard-empty-img",attrs:{src:"/static/images/my/img_giftcard_empty.png"}}),i("v-uni-view",{staticClass:"tips",staticStyle:{margin:"50rpx 0"}},[t._v("暂无阿喜有礼")]),i("v-uni-button",{staticClass:"font-size-lg",staticStyle:{padding:"0 80rpx"},attrs:{type:"primary"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleTabChange(0)}}},[t._v("现在去选购")])]],2)],1),i("v-uni-swiper-item",[i("v-uni-view",{staticClass:"h-100 d-flex flex-column align-items-center"},[t.MyCanUseGiftCards.length?t._e():[i("v-uni-image",{staticClass:"giftcard-empty-img",attrs:{src:"/static/images/my/img_giftcard_empty.png"}}),i("v-uni-view",{staticClass:"tips",staticStyle:{margin:"50rpx 0"}},[t._v("暂无阿喜有礼")]),i("v-uni-button",{staticClass:"font-size-lg",staticStyle:{padding:"0 80rpx"},attrs:{type:"primary"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleTabChange(0)}}},[t._v("现在去选购")])]],2)],1)],1)],1),i("v-uni-view",{staticClass:"bottom"},[i("v-uni-view",[t._v("购买历史")]),i("v-uni-view",{staticClass:"divider"}),i("v-uni-view",[t._v("收送记录")])],1)],1)],1),i("card-popup",{ref:"cardPopup",attrs:{product:t.product}})],1)},s=[]},df83:function(t,e,i){"use strict";i.r(e);var a=i("0b40"),n=i("8bde");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("c94e");var r,c=i("f0c5"),o=Object(c["a"])(n["default"],a["b"],a["c"],!1,null,"63d3a2e1",null,!1,a["a"],r);e["default"]=o.exports},f2e2:function(t,e,i){"use strict";i.r(e);var a=i("d92f"),n=i("a0e2");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("71bd");var r,c=i("f0c5"),o=Object(c["a"])(n["default"],a["b"],a["c"],!1,null,"21b2c4d6",null,!1,a["a"],r);e["default"]=o.exports}}]);