(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-588f5190"],{6691:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"root"},[a("div",{staticClass:"top-title"},[t._v("应用管理")]),a("el-menu",{staticClass:"el-menu-vertical-demo",attrs:{"default-active":t.act},on:{open:t.handleOpen,close:t.handleClose}},[a("el-menu-item",{attrs:{index:"3"},on:{click:t.jump_to_ad}},[a("span",{attrs:{slot:"title"},slot:"title"},[t._v("广告")])]),a("el-menu-item",{attrs:{index:"4"},on:{click:t.jump_article}},[a("span",{attrs:{slot:"title"},slot:"title"},[t._v("文章")])]),a("el-menu-item",{attrs:{index:"5"},on:{click:t.jump_address}},[a("span",{attrs:{slot:"title"},slot:"title"},[t._v("地址")])])],1)],1)},s=[],l={data:function(){return{act:""}},props:{ac:String},mounted:function(){console.log(this.ac),this.act=this.ac},methods:{jump_address:function(){this.$router.push({path:"/extend/address"})},jump_Nav:function(){this.$router.push({path:"/extend/Nav"})},jump_article:function(){this.$router.push({path:"/extend/article"})},jump_to_ad:function(){this.$router.push({path:"/extend/ad"})},jump_to_c:function(){this.$router.push({path:"/extend/pt"})},jump_to_d:function(){this.$router.push({path:"/extend/discount"})},handleOpen:function(t,e){console.log(t,e)},handleClose:function(t,e){console.log(t,e)},handleselect:function(t,e){this.act=t,localStorage.setItem("act",t)}}},i=l,o=a("5d22"),r=Object(o["a"])(i,n,s,!1,null,null,null);e["a"]=r.exports},bb0f:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"root"},[a("el-container",[a("el-aside",{staticClass:"not-print bg-white erbian",attrs:{width:"160px"}},[a("Nav",{attrs:{ac:"5"}})],1),a("el-main",[a("el-row",{staticStyle:{"text-align":"left","margin-bottom":"10px"}},[a("el-col",{attrs:{span:3}},[a("el-select",{attrs:{placeholder:"请选择地址等级"},model:{value:t.add_form.pid,callback:function(e){t.$set(t.add_form,"pid",e)},expression:"add_form.pid"}},[a("el-option",{attrs:{label:"顶级",value:0}}),t._l(t.options,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})}))],2)],1),a("el-col",{attrs:{span:5}},[a("el-input",{attrs:{placeholder:"请输入二级地址,如 一栋@二栋@三栋"},model:{value:t.add_form.name,callback:function(e){t.$set(t.add_form,"name",e)},expression:"add_form.name"}})],1),a("el-col",{attrs:{span:2}},[a("el-button",{staticStyle:{"margin-left":"20px"},attrs:{type:"primary",size:"medium"},on:{click:t.sub_add}},[t._v("提交")])],1)],1),a("el-table",{staticStyle:{width:"100%"},attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{type:"index",label:"序号",width:"180"}}),a("el-table-column",{attrs:{prop:"name",label:"名称"},scopedSlots:t._u([{key:"default",fn:function(e){return[1==e.row.level?[t._v(t._s(e.row.name))]:[a("span",[t._v("  |---  ")]),t._v(t._s(e.row.name))]]}}])}),a("el-table-column",{attrs:{label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"success",size:"mini"},on:{click:function(a){return t.edit_address(e.row)}}},[t._v("修改")]),a("el-button",{attrs:{type:"danger",size:"mini"},on:{click:function(a){return t.del_address(e.row.id)}}},[t._v("删除")])]}}])})],1)],1)],1),a("el-dialog",{attrs:{title:"修改地址",visible:t.dialogVisible,width:"30%","before-close":t.handleClose},on:{"update:visible":function(e){t.dialogVisible=e}}},[a("el-form",{ref:"form",attrs:{model:t.edit_form,"label-width":"80px"}},[a("el-form-item",{attrs:{label:"地址"}},[a("el-input",{model:{value:t.edit_form.name,callback:function(e){t.$set(t.edit_form,"name",e)},expression:"edit_form.name"}})],1)],1),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:t.cancel}},[t._v("取 消")]),a("el-button",{attrs:{type:"primary"},on:{click:t.sub_edit}},[t._v("确 定")])],1)],1)],1)},s=[],l=(a("a450"),a("d22d")),i=a("6691"),o={components:{Nav:i["a"]},data:function(){return{edit_form:{id:"",name:"",level:"",pid:""},dialogVisible:!1,add_form:{pid:"",name:""},value:"",options:[],tableData:[]}},mounted:function(){this.get_all_address()},methods:{handleClose:function(){this.dialogVisible=!1},cancel:function(){this.dialogVisible=!1},sub_edit:function(){var t=this;l["a"].edit_address(this.edit_form).then((function(e){t.$message({message:"修改成功",type:"success"}),t.get_all_address(),t.dialogVisible=!1}))},edit_address:function(t){console.log(t),this.dialogVisible=!0,this.edit_form=t},del_address:function(t){var e=this;l["a"].del_address(t).then((function(t){e.get_all_address()}))},sub_add:function(){var t=this;l["a"].add_address(this.add_form).then((function(e){t.get_all_address(),t.add_form.pid="",t.add_form.name=""}))},get_all_address:function(){var t=this;this.options=[],l["a"].get_all_address().then((function(e){var a={};for(var n in t.tableData=e.data,e.data){var s=e.data[n];1==s.level&&(a={label:s.name,value:s.id},t.options.push(a))}}))}}},r=o,d=a("5d22"),u=Object(d["a"])(r,n,s,!1,null,null,null);e["default"]=u.exports},d22d:function(t,e,a){"use strict";var n=a("981f");function s(){var t="banner/admin/banner_all_item";return n["a"].get(t).then((function(t){return t}))}function l(t){console.log(t);var e="banner/admin/add_banner";return n["a"].post_show(e,t).then((function(t){return t}))}function i(t){var e="banner/admin/del_banner?id="+t;return n["a"].put_show(e,t).then((function(t){return t}))}function o(){var t="index/get_address";return n["a"].get(t).then((function(t){return t}))}function r(t){var e="cms/admin/add_region";return n["a"].post_show(e,t).then((function(t){return t}))}function d(t){var e="/cms/admin/del_region";return n["a"].Del(e+"?id="+t).then((function(t){return t}))}function u(t){var e="/cms/admin/edit_region";return n["a"].post_show(e,t).then((function(t){return t}))}e["a"]={edit_address:u,del_address:d,add_address:r,get_all_address:o,get_all_ad:s,add_ad:l,del_ad:i}}}]);