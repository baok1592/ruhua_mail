(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-pay-remark"],{"70c2":function(a,t,e){"use strict";e.r(t);var n=e("f355"),r=e.n(n);for(var i in n)"default"!==i&&function(a){e.d(t,a,(function(){return n[a]}))}(i);t["default"]=r.a},"8d0d":function(a,t,e){"use strict";var n=e("eab2"),r=e.n(n);r.a},"8fe6":function(a,t,e){var n=e("24fb");t=n(!1),t.push([a.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-e3dfa664]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.container[data-v-e3dfa664]{background-color:#fff;padding:%?40?%}.remarks[data-v-e3dfa664]{margin-bottom:%?40?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?26?%}.remarks .remark[data-v-e3dfa664]{color:#999;padding:%?10?% %?26?%;border:%?1?% solid rgba(200,199,204,.6);margin-right:%?20?%}.remarks .remark.active[data-v-e3dfa664]{color:#343434;border-color:#343434}.textarea-box .textarea[data-v-e3dfa664]{width:100%;border:%?1?% solid rgba(200,199,204,.6);padding:%?20?%;font-size:%?28?%}',""]),a.exports=t},b223:function(a,t,e){"use strict";var n;e.d(t,"b",(function(){return r})),e.d(t,"c",(function(){return i})),e.d(t,"a",(function(){return n}));var r=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("v-uni-view",{staticClass:"container"},[e("v-uni-view",{staticClass:"mb-40 font-size-medium"},[a._v("快捷标签")]),e("v-uni-view",{staticClass:"remarks"},a._l(a.remarks,(function(t,n){return e("v-uni-view",{key:n,staticClass:"remark",class:{active:t.active},on:{click:function(t){arguments[0]=t=a.$handleEvent(t),a.choose(n)}}},[a._v(a._s(t.label))])})),1),e("v-uni-view",{staticClass:"textarea-box"},[e("v-uni-textarea",{staticClass:"textarea",attrs:{"placeholder-class":"placeholder",maxlength:50},on:{input:function(t){arguments[0]=t=a.$handleEvent(t),a.handleTextareaInput.apply(void 0,arguments)}},model:{value:a.remark,callback:function(t){a.remark=t},expression:"remark"}}),e("v-uni-view",{staticClass:"tips"},[a._v(a._s(a.remark.length)+" / 50")])],1),e("v-uni-button",{staticClass:"w-100 font-size-extra-lg border-radius-lg",staticStyle:{"margin-top":"50rpx"},attrs:{type:"info"},on:{click:function(t){arguments[0]=t=a.$handleEvent(t),a.submit.apply(void 0,arguments)}}},[a._v("提交")])],1)},i=[]},eab2:function(a,t,e){var n=e("8fe6");"string"===typeof n&&(n=[[a.i,n,""]]),n.locals&&(a.exports=n.locals);var r=e("4f06").default;r("542642d6",n,!0,{sourceMap:!1,shadowMode:!1})},edf1:function(a,t,e){"use strict";e.r(t);var n=e("b223"),r=e("70c2");for(var i in r)"default"!==i&&function(a){e.d(t,a,(function(){return r[a]}))}(i);e("8d0d");var s,o=e("f0c5"),c=Object(o["a"])(r["default"],n["b"],n["c"],!1,null,"e3dfa664",null,!1,n["a"],s);t["default"]=c.exports},f355:function(a,t,e){"use strict";e("4160"),e("159b"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n={data:function(){return{remarks:[{label:"打包",active:0},{label:"不打包",active:0},{label:"放在前台",active:0}],remark:""}},onShow:function(){var a=this;this.remark=this.$store.state.remark,this.remarks.forEach((function(t){return t.label==a.remark&&(t.active=1)}))},methods:{choose:function(a){this.remarks.forEach((function(a){return a.active=0})),this.remarks[a].active=1,this.remark=this.remarks[a].label},handleTextareaInput:function(a){a.detail.value.length>=50&&uni.showToast({icon:"none",title:"最多备注50个字符"})},submit:function(){this.$store.commit("SET_REMARK",this.remark),uni.navigateBack()}}};t.default=n}}]);