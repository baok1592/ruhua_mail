(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-64f7eae4"],{"7bee":function(e,t,n){"use strict";var l=n("981f");function i(){var e="user/admin/get_all";return l["a"].get(e).then((function(e){return e}))}function a(){var e="level/admin/get_all_level";return l["a"].get(e).then((function(e){return e}))}function r(e){var t="level/admin/add_level";return l["a"].post_show(t,e).then((function(e){return e}))}function s(e){var t="level/admin/del_level";return l["a"].put_show(t+"?id="+e).then((function(e){return e}))}function o(e){var t="user/admin/edit_user";return l["a"].post_show(t,e).then((function(e){return e}))}function u(e){var t="user/admin/get_one_user";return l["a"].get(t+"?id="+e).then((function(e){return e}))}function d(e){var t="user/admin/del_user?id=";return l["a"].Del(t+e).then((function(e){return e}))}var c=function(e){var t="level/admin/edit_level";return l["a"].post_show(t,e).then((function(e){return e}))};t["a"]={del_level:s,get_all_user:i,get_all_level:a,add_level:r,edit_userinfo:o,get_user_log:u,del_user:d,editUser:c}},"8b28":function(e,t,n){"use strict";n.r(t);var l=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"user_level"},[n("el-container",{staticClass:"container"},[n("el-main",{staticClass:"main"},[n("el-breadcrumb",{attrs:{"separator-class":"el-icon-arrow-right"}},[n("el-breadcrumb-item",{attrs:{to:{path:"/"}}},[e._v("首页")]),n("el-breadcrumb-item",[e._v("管理员")])],1),n("div",{staticClass:"H10"}),n("div",{staticClass:"zhang",staticStyle:{"text-align":"left"}},[n("el-button",{staticStyle:{"margin-bottom":"10px"},attrs:{type:"primary",size:"medium"},on:{click:e.add_level}},[e._v("新增管理员")]),n("el-table",{staticStyle:{width:"100%"},attrs:{data:e.list,border:""}},[n("el-table-column",{attrs:{type:"index",label:"序号",width:"80"}}),n("el-table-column",{attrs:{prop:"username",label:"用户名"}}),n("el-table-column",{attrs:{prop:"description",label:"描述"}}),n("el-table-column",{attrs:{label:"所属分组"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("span",[e._v(e._s(t.row.group.name))])]}}])}),n("el-table-column",{attrs:{label:"操作",width:"300px"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("el-button",{attrs:{type:"danger",size:"mini"},on:{click:function(n){return e.del(t.row.id)}}},[e._v("删除")])]}}])})],1)],1)],1)],1),n("el-dialog",{attrs:{title:"新增管理员",visible:e.dialogVisible,width:"30%","before-close":e.handleClose},on:{"update:visible":function(t){e.dialogVisible=t}}},[n("el-form",{ref:"form",attrs:{model:e.form,"label-width":"80px"}},[n("el-form-item",{attrs:{label:"用户名"}},[n("el-input",{attrs:{placeholder:"请输入用户名..."},model:{value:e.form.username,callback:function(t){e.$set(e.form,"username",t)},expression:"form.username"}})],1),n("el-form-item",{attrs:{label:"密码"}},[n("el-input",{attrs:{placeholder:"请输入密码...","show-password":""},model:{value:e.form.password,callback:function(t){e.$set(e.form,"password",t)},expression:"form.password"}})],1),n("el-form-item",{attrs:{label:"描述"}},[n("el-input",{attrs:{placeholder:"请输入描述..."},model:{value:e.form.description,callback:function(t){e.$set(e.form,"description",t)},expression:"form.description"}})],1)],1),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(t){e.dialogVisible=!1}}},[e._v("取 消")]),n("el-button",{attrs:{type:"primary"},on:{click:e.sub_add}},[e._v("确 定")])],1)],1)],1)},i=[],a=(n("7bee"),{components:{},data:function(){return{dialogVisible:!1,form:{group_id:1,state:1},sort:0,list:[]}},watch:{dialogVisible:function(e,t){e||(this.form={username:"",group_id:1,password:"",description:""})}},mounted:function(){this.get_all_admin()},methods:{get_all_admin:function(){var e=this;this.http.get("cms/admin/get_all_admin").then((function(t){console.log(t),e.list=t.data}))},on_edit:function(e){this.dialogVisible=!0,this.form=e},sub_add:function(){var e=this;this.form.id||this.http.post_show("cms/admin/add_admin",this.form).then((function(t){e.dialogVisible=!1,e.get_all_admin()}))},add_level:function(){this.dialogVisible=!0},del:function(e){var t=this;this.http.Del("cms/admin/del_admin?id="+e).then((function(e){t.$message({message:"操作成功",type:"success"}),t.get_all_admin()}))},handleClose:function(){this.dialogVisible=!1}}}),r=a,s=n("5d22"),o=Object(s["a"])(r,l,i,!1,null,null,null);t["default"]=o.exports}}]);