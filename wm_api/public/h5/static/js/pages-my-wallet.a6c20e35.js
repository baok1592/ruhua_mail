(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-my-wallet"],{2553:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n={data:function(){return{agree:!1,footerShow:!0}},methods:{open:function(){uni.navigateBack()}}};e.default=n},"36e0":function(t,e,i){"use strict";var n=i("78c3"),a=i.n(n);a.a},"3f4a":function(t,e,i){"use strict";i.r(e);var n=i("2553"),a=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=a.a},68414:function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}));var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"container"},[i("v-uni-view",{staticClass:"content"},[i("v-uni-view",{staticClass:"use-description"},[i("v-uni-view",{staticClass:"title"},[t._v("钱包如何充值？")]),i("v-uni-view",{staticClass:"article"},[t._v("点击“立即充值”，选择要充值的金额后，即可完成充值。"),i("br"),t._v("新用户充值即可获得一张无限制优惠劵，仅限新用户。"),i("br"),t._v("钱包内的余额可随时提现，无任何手续费。")])],1)],1),i("v-uni-view",{staticClass:"footer",class:{show:t.footerShow}},[i("v-uni-view",{staticClass:"agreement",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.agree=!t.agree}}},[i("v-uni-image",{attrs:{src:t.agree?"/static/images/common/round-black-selected.png":"/static/images/common/gouxuankuang.png"}}),i("v-uni-view",[t._v("同意《钱包章程》")])],1),i("v-uni-button",{attrs:{type:"info",disabled:!t.agree},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.open.apply(void 0,arguments)}}},[t._v("开通钱包")])],1)],1)},o=[]},"78c3":function(t,e,i){var n=i("cf5a");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("28cfbd98",n,!0,{sourceMap:!1,shadowMode:!1})},cf5a:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是app内置的常用样式变量\r\n *\r\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */\r\n/* coolc-coupon 插件 */uni-page-body[data-v-13f9b698]{background-color:#fff}.container[data-v-13f9b698]{height:auto;font-size:%?26?%;color:#999;line-height:1.2rem;padding-bottom:%?200?%}.toutu[data-v-13f9b698]{padding:%?100?% %?30?%}.content[data-v-13f9b698]{padding:0 %?40?%}.how-to-use[data-v-13f9b698]{margin-bottom:%?100?%}.how-to-use .article[data-v-13f9b698]{margin-bottom:%?60?%}.biaoti-box[data-v-13f9b698]{padding:%?60?% 0;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.biaoti-box .biaoti[data-v-13f9b698]{width:%?320?%}.use-description .title[data-v-13f9b698]{color:#343434;margin:%?20?% 0;display:list-item;list-style-type:disc;list-style-position:inside;font-weight:500}.use-description .article[data-v-13f9b698]{marign:%?10?% 0}.footer[data-v-13f9b698]{z-index:10;background-color:#fff;position:fixed;bottom:%?-200?%;width:100%;height:%?200?%;padding:%?20?% %?30?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;font-size:%?24?%;color:#999;border-top:%?1?% solid #c8c7cc;-webkit-transition:all 1s cubic-bezier(0,1,.5,1);transition:all 1s cubic-bezier(0,1,.5,1)}.footer.show[data-v-13f9b698]{bottom:0}.footer .agreement[data-v-13f9b698]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.footer .agreement uni-image[data-v-13f9b698]{width:%?30?%;height:%?30?%;margin-right:%?10?%}.footer uni-button[data-v-13f9b698]{font-size:%?32?%;line-height:3.2}body.?%PAGE?%[data-v-13f9b698]{background-color:#fff}',""]),t.exports=e},fc52:function(t,e,i){"use strict";i.r(e);var n=i("68414"),a=i("3f4a");for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);i("36e0");var r,c=i("f0c5"),s=Object(c["a"])(a["default"],n["b"],n["c"],!1,null,"13f9b698",null,!1,n["a"],r);e["default"]=s.exports}}]);