<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>QY外卖点餐</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">
    <style type="text/css">
        .js-box{
            border:1px solid #eee;padding:20px;line-height: 25px;
        }
        .js-box a{
            color:#3E8BFD;
        }
        .head-box{
            height:60px;line-height: 60px;text-indent: 25px;font-size:18px;
        }
        .blue{
            color:#fff !important;
            background-color:#3E8BFD;
        }
    </style>
</head>
<body>
<div style="width:800px;margin: 100px auto;">
  <div class="layui-layout layui-layout-admin">
  <div class="blue head-box">
  QY外卖点餐安装引导--v{{VAE_VERSION}}
  </div>
  <div class="js-box">
    <p>
        欢迎使用QY外卖点餐系统，采用laravel+VUE开发的三端分离商城系统。<br>
        您在使用中如有任何问题都可以登录 <a href="http://www.ruhuashop.com" target="_blank">如花官方网站</a> 获取帮助。<br><br>
        <h3>免费版使用须知：</h3>
        1.允许用于个人学习、毕业设计、教学案例、公益事业;<br>
        2.免费版不合适商用，商用请购买商业版;<br>
        3.禁止将如花商城系统的代码进行任何形式的出售，产生的一切任何后果责任由侵权者自负。<br>
        4.使用免费版请务必保留官方版权标识和链接，免费版只有基础的功能。<br><br>

      <h3>免责声明：</h3>
        1、使用外卖点餐系统构建的程序，任何商品内容、信息内容导致的纠纷和法律争议及后果，如花商城官方不承担任何责任。<br>
        2、您一旦安装使用外卖商城，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制

    </p>
    <div style="margin:10px auto;width: 90px;">
      <a href="{{ url('install/step2') }}" class="layui-btn blue">接受协议</a>
    </div>
  </div>
</div>
</div>     
          
<script src="/static/layui/layui.js" charset="utf-8"></script>

</body>
</html>