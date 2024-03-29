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
          QY外卖点餐安装引导--v:{{VAE_VERSION}}
      </div>
  <div style="border:1px solid #eee;padding:20px;line-height: 25px;">
    <h3>环境检测</h3>
    <table class="layui-table" lay-skin="nob" lay-size="sm">
      <colgroup>
        <col width="150">
        <col width="200">
        <col width="200">
        <col width="100">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th>环境</th>
          <th>最低配置</th>
          <th>当前配置</th>
          <th>是否符合</th>
        </tr> 
      </thead>
      <tbody>
        <tr>
          <td>操作系统</td>
          <td>不限</td>
          <td><?php echo php_uname('s'); ?></td>
          <td class="yes"><i class="layui-icon layui-icon-ok"></i></td>
        </tr>
        <tr>
          <td>php版本</td>
          <td>≥ 7.1</td>
          <td><?php echo PHP_VERSION ?></td>
          <?php $php_version=explode('.', PHP_VERSION); ?>
          <td class="<?php if(($php_version['0']>=7) || ($php_version['0']>=5 && $php_version['1']>=5))echo 'yes'; ?>">
              <?php if (($php_version['0']>=7) || ($php_version['0']>=5 && $php_version['1']>=5)): ?>
                  <i class="layui-icon layui-icon-ok"></i>
              <?php else: ?>
                  <i class="layui-icon layui-icon-close"></i>
              <?php endif ?>
          </td>
        </tr>
      </tbody>
    </table>
    <h3>模块检测</h3>
    <table class="layui-table" lay-skin="nob" lay-size="sm">
      <colgroup>
        <col width="150">
        <col width="200">
        <col width="200">
        <col width="100">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th>环境</th>
          <th>最低配置</th>
          <th>当前配置</th>
          <th>是否符合</th>
        </tr> 
      </thead>
      <tbody>
        <tr>
          <td>session</td>
          <td>支持</td>
          <td> <?php if ($data['session']): ?>
              支持
            <?php else: ?>
            不支持
            <?php endif ?></td>
          <td><?php if ($data['session']):?>
            <i class="layui-icon layui-icon-ok"></i>
            <?php else: ?>
            <i class="layui-icon layui-icon-close"></i>
            <?php endif ?></td>
        </tr>
        <tr>
          <td>PDO</td>
          <td>开启</td>
          <td><?php if ($data['pdo']): ?>
            支持
            <?php else: ?>
            不支持
            <?php endif ?></td>
          <td><?php if ($data['pdo']):?>
            <i class="layui-icon layui-icon-ok"></i>
            <?php else: ?>
            <i class="layui-icon layui-icon-close"></i>
            <?php endif ?></td>
        </tr>
        <tr>
          <td>PDO_Mysql</td>
          <td>开启</td>
          <td><?php if ($data['pdo_mysql']): ?>
            支持
            <?php else: ?>
            不支持
            <?php endif ?></td>
          <td><?php if ($data['pdo_mysql']):?>
            <i class="layui-icon layui-icon-ok"></i>
            <?php else: ?>
            <i class="layui-icon layui-icon-close"></i>
            <?php endif ?></td>
        </tr>
        <tr>
          <td>上传限制</td>
          <td>≥ 2M</td>
          <td><?php if ($data['upload_size']): ?>
            支持
            <?php else: ?>
            不支持
            <?php endif ?></td>
          <td><?php if ($data['upload_size']):?>
            <i class="layui-icon layui-icon-ok"></i>
            <?php else: ?>
            <i class="layui-icon layui-icon-close"></i>
            <?php endif ?></td>
        </tr>
      </tbody>
    </table>
    <h3>目录权限</h3>
    <table class="layui-table" lay-skin="nob" lay-size="sm">
      <colgroup>
        <col width="150">
        <col width="200">
        <col width="200">
        <col width="100">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th>环境</th>
          <th>最低配置</th>
          <th>当前配置</th>
          <th>是否符合</th>
        </tr> 
      </thead>
      <tbody>
        <tr>
            <td>data</td>
            <td>可写</td>
            <td>
                <?php if (is_writable(ROOT . '/data')): ?>
                    可写
                <?php else: ?>
                    不可写
                <?php endif ?>
            </td>
            <td class="<?php if(is_writable(ROOT . '/data'))echo 'yes'; ?>">
                <?php if (is_writable(ROOT. '/data')):?>
                    <i class="layui-icon layui-icon-ok"></i>
                <?php else: ?>
                    <i class="layui-icon layui-icon-close"></i>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <td>/uploads</td>
            <td>可写</td>
            <td>
                <?php if (is_writable('./uploads')): ?>
                    可写
                <?php else: ?>
                    不可写
                <?php endif ?>
            </td>
            <td class="<?php if(is_writable('./uploads'))echo 'yes'; ?>">
                <?php if (is_writable('./uploads')): ?>
                    <i class="layui-icon layui-icon-ok"></i>
                <?php else: ?>
                    <i class="layui-icon layui-icon-close"></i>
                <?php endif ?>
            </td>
        </tr>
      </tbody>
  </table>
    <div style="margin:10px auto;width: 190px;">
      <a href="{{url('install')}}" class="layui-btn  blue">上一步</a>
      <a href="javascript:;" class="layui-btn  blue" id="step2">下一步</a>
    </div>
  </div>
</div>
</div>     
          
<script src="/static/layui/layui.js" charset="utf-8"></script>
<script>
layui.use(['jquery','layer'], function(){
  var $ = layui.jquery,layer = layui.layer;
  
  $('#step2').click(function(){
    if($('.yes').length!=4){
        layer.tips('您的配置或权限不符合要求-',this);
        //alert($('.yes').length);
    }else{
        location.href="{{url('install/step3')}}";
    }
  })

});
</script>

</body>
</html>