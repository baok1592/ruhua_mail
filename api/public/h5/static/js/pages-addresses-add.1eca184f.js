(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-addresses-add"],{"014e":function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-6518ace9]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.address-form[data-v-6518ace9]{margin-top:%?20?%}.address-form .form-item[data-v-6518ace9]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.address-form .form-item .label[data-v-6518ace9]{width:%?160?%}.address-form .form-item uni-input[data-v-6518ace9]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.address-form .form-item .jump-icon[data-v-6518ace9]{width:%?30?%;height:%?48?%}.address-form .form-item .radio[data-v-6518ace9]{display:-webkit-box;display:-webkit-flex;display:flex;margin-right:%?50?%}.address-form .form-item .radio uni-image[data-v-6518ace9]{width:%?40?%;height:%?40?%;margin-right:%?20?%}.save-btn[data-v-6518ace9]{padding:0 %?30?%;margin-top:%?60?%}.save-btn uni-button[data-v-6518ace9]{width:100%;font-size:%?36?%}',""]),t.exports=e},"0706":function(t,e,i){"use strict";var a=i("d5f4"),n=i.n(a);n.a},"19bd":function(t,e,i){"use strict";var a;i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return r})),i.d(e,"a",(function(){return a}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"tui-cell-class tui-list-cell",class:{"tui-cell-last":t.last,"tui-line-left":t.lineLeft,"tui-line-right":t.lineRight,"tui-radius":t.radius},style:{background:t.bgcolor,fontSize:t.size+"rpx",color:t.color,padding:t.padding},attrs:{"hover-class":t.hover?"tui-cell-hover":"","hover-stay-time":150},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleClick.apply(void 0,arguments)}}},[t._t("default"),t.arrow?i("v-uni-image",{staticClass:"arrow",attrs:{src:"/static/images/common/icon_jump_black3.png"}}):t._e()],2)},r=[]},"3c91":function(t,e,i){"use strict";i.r(e);var a=i("756c"),n=i.n(a);for(var r in a)"default"!==r&&function(t){i.d(e,t,(function(){return a[t]}))}(r);e["default"]=n.a},"756c":function(t,e,i){"use strict";var a=i("4ea4");i("7db0"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("8ff1")),r=a(i("7cc0")),s={components:{listCell:n.default},data:function(){return{form:{name:"",mobile:"",detail:"",is_default:0,province:"",city:""},index:0,index1:0,provinces:["请选择"],citys:["请选择"],address:[],idEdit:!1,id:-1}},watch:{index:function(t){var e=this.provinces[t],i=this.address.find((function(t){return t.name==e}));for(var a in this.address)this.address[a].pid==i.id&&this.citys.push(this.address[a].name)}},onLoad:function(t){var e=t.id;this.id=e,this.show_data()},methods:{show_data:function(){var t=this;r.default.get_address().then((function(e){for(var i in t.address=e.data,e.data)1==e.data[i].level&&t.provinces.push(e.data[i].name)})),this.id&&(this.idEdit=!0,r.default.get_one_address(this.id).then((function(e){for(var i in t.form=e.data,t.provinces)if(t.provinces[i]==t.form.province){t.index=i;break}for(var a in t.citys)if(t.citys[a]==t.form.city){t.index1=a;break}})))},bindPickerChange:function(t){this.index=t.target.value,this.form.province=this.provinces[this.index]},bindPickerChange1:function(t){console.log("picker发送选择改变，携带值为",t.target.value),this.index1=t.target.value,this.form.city=this.citys[this.index1]},save:function(){if(this.form.id)r.default.edit_address(this.form).then((function(t){t.data?(uni.showToast({title:"修改成功！",duration:2e3}),uni.navigateBack()):uni.showToast({title:"修改失败！",duration:2e3})}));else{if(!this.form.city||!this.form.detail||!this.form.mobile||!this.form.name||!this.form.province)return void uni.showToast({icon:"none",title:"请填写完整信息"});r.default.add_address(this.form).then((function(t){t.data?(uni.showToast({title:"添加成功！",duration:2e3}),uni.navigateBack()):uni.showToast({title:"添加失败！",duration:2e3})}))}}}};e.default=s},"7cc0":function(t,e,i){"use strict";var a=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("4c1e"));function r(){var t="address/get_default_address";return n.default.get(t).then((function(t){return t}))}function s(){var t="address/get_all_address";return n.default.get(t).then((function(t){return t}))}function d(){var t="index/get_address";return n.default.get(t).then((function(t){return t}))}function o(t){var e="address/get_one_address?id=";return n.default.get(e+t).then((function(t){return t}))}function l(t){var e="address/edit_address";return n.default.post(e,t).then((function(t){return t}))}function u(t){var e="address/add_address";return n.default.post(e,t).then((function(t){return t}))}function c(t){var e="address/del_address";return n.default.put(e,{id:t}).then((function(t){return t}))}function f(t){var e="address/set_default_address";return n.default.post(e,{id:t}).then((function(t){return t}))}var v={get_default_address:r,get_all_address:s,get_address:d,get_one_address:o,edit_address:l,add_address:u,deleteAddress:c,setDefaultAddress:f};e.default=v},"8b72":function(t,e,i){"use strict";i.r(e);var a=i("aa04"),n=i("3c91");for(var r in n)"default"!==r&&function(t){i.d(e,t,(function(){return n[t]}))}(r);i("d881");var s,d=i("f0c5"),o=Object(d["a"])(n["default"],a["b"],a["c"],!1,null,"6518ace9",null,!1,a["a"],s);e["default"]=o.exports},"8ff1":function(t,e,i){"use strict";i.r(e);var a=i("19bd"),n=i("9d9e");for(var r in n)"default"!==r&&function(t){i.d(e,t,(function(){return n[t]}))}(r);i("0706");var s,d=i("f0c5"),o=Object(d["a"])(n["default"],a["b"],a["c"],!1,null,"16e75238",null,!1,a["a"],s);e["default"]=o.exports},"9d9e":function(t,e,i){"use strict";i.r(e);var a=i("d454"),n=i.n(a);for(var r in a)"default"!==r&&function(t){i.d(e,t,(function(){return a[t]}))}(r);e["default"]=n.a},aa04:function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return r})),i.d(e,"a",(function(){return a}));var a={listCell:i("8ff1").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"container",staticStyle:{"font-size":"15px !important"}},[i("v-uni-view",{staticClass:"address-form"},[i("list-cell",{attrs:{padding:"30rpx"}},[i("v-uni-view",{staticClass:"form-item"},[i("v-uni-view",{staticClass:"label"},[t._v("联系人")]),i("v-uni-input",{attrs:{type:"text",placeholder:"请填写收货人的姓名","placeholder-class":"placeholder"},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1)],1),i("list-cell",{attrs:{padding:"30rpx"}},[i("v-uni-view",{staticClass:"form-item"},[i("v-uni-view",{staticClass:"label"},[t._v("手机号")]),i("v-uni-input",{attrs:{type:"text",maxlength:"11",placeholder:"请填写收货手机号码","placeholder-class":"placeholder"},model:{value:t.form.mobile,callback:function(e){t.$set(t.form,"mobile",e)},expression:"form.mobile"}})],1)],1),i("list-cell",{attrs:{padding:"30rpx"}},[i("v-uni-view",{staticClass:"form-item"},[i("v-uni-view",{staticClass:"label"},[t._v("地区")]),i("v-uni-picker",{attrs:{value:t.index,mode:"selector",range:t.provinces},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.bindPickerChange.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"uni-input"},[t._v(t._s(t.provinces[t.index]))])],1)],1)],1),i("list-cell",{attrs:{padding:"30rpx"}},[i("v-uni-view",{staticClass:"form-item"},[i("v-uni-view",{staticClass:"label"},[t._v("街道")]),i("v-uni-picker",{attrs:{mode:"selector",value:t.index1,range:t.citys},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.bindPickerChange1.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"uni-input"},[t._v(t._s(t.citys[t.index1]))])],1)],1)],1),i("list-cell",{attrs:{padding:"30rpx"}},[i("v-uni-view",{staticClass:"form-item"},[i("v-uni-view",{staticClass:"label"},[t._v("详细地址")]),i("v-uni-input",{attrs:{type:"text",placeholder:"例:B座6楼606室","placeholder-class":"placeholder"},model:{value:t.form.detail,callback:function(e){t.$set(t.form,"detail",e)},expression:"form.detail"}})],1)],1)],1),i("v-uni-view",{staticClass:"save-btn"},[i("v-uni-button",{attrs:{type:"info"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.save()}}},[t._v("保存")])],1)],1)},r=[]},d0a3:function(t,e,i){var a=i("014e");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("5889ecb8",a,!0,{sourceMap:!1,shadowMode:!1})},d454:function(t,e,i){"use strict";i("a9e3"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a={name:"ListCell",props:{arrow:{type:Boolean,default:!1},hover:{type:Boolean,default:!1},lineLeft:{type:Boolean,default:!0},lineRight:{type:Boolean,default:!1},padding:{type:String,default:"30rpx"},last:{type:Boolean,default:!1},radius:{type:Boolean,default:!1},bgcolor:{type:String,default:"#fff"},size:{type:Number,default:28},color:{type:String,default:"#343434"},index:{type:Number,default:0}},methods:{handleClick:function(){this.$emit("click",{index:this.index})}}};e.default=a},d5f4:function(t,e,i){var a=i("e02e");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("c5ad2bb0",a,!0,{sourceMap:!1,shadowMode:!1})},d881:function(t,e,i){"use strict";var a=i("d0a3"),n=i.n(a);n.a},e02e:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是app内置的常用样式变量\n *\n * app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */.uni-mask[data-v-16e75238]{z-index:0!important}\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/* coolc-coupon 插件 */.tui-list-cell[data-v-16e75238]{position:relative;width:100%;-webkit-box-sizing:border-box;box-sizing:border-box;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tui-radius[data-v-16e75238]{-webkit-border-radius:%?12?%;border-radius:%?12?%;overflow:hidden}.tui-cell-hover[data-v-16e75238]{background:#f7f7f9!important}.tui-list-cell[data-v-16e75238]::after{content:"";position:absolute;border-bottom:%?1?% solid rgba(200,199,204,.3);bottom:0;right:0;left:0}.tui-line-left[data-v-16e75238]::after{left:%?30?%!important}.tui-line-right[data-v-16e75238]::after{right:%?30?%!important}.tui-cell-last[data-v-16e75238]::after{border-bottom:0!important}.arrow[data-v-16e75238]{width:%?20?%;height:%?32?%;position:relative;-webkit-flex-shrink:0;flex-shrink:0;margin-left:%?10?%}',""]),t.exports=e}}]);