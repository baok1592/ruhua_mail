<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QY外卖点餐</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../../static/layui/css/layui.css" media="all">
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
        <div style="border:1px solid #eee;padding:20px;line-height: 25px;">
  

            <h3>数据库配置</h3><br>
            <form class="layui-form" action="" id="form">
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库类型</label>
                    <div class="layui-input-inline">
                        <input type="text" name="DB_TYPE" required lay-verify="required" autocomplete="off"
                               class="layui-input" value="mysql" disabled="disabled">
                    </div>
                    <div class="layui-form-mid layui-word-aux">固定为mysql</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库地址</label>
                    <div class="layui-input-inline">
                        <input type="text" name="DB_HOST" required lay-verify="required" autocomplete="off"
                               class="layui-input" value="127.0.0.1">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库端口</label>
                    <div class="layui-input-inline">
                        <input type="text" name="DB_PORT" required lay-verify="required" autocomplete="off"
                               class="layui-input" value="3306">
                    </div>
                    <div class="layui-form-mid layui-word-aux">数据库端口，一般为3306</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="DB_USER" required lay-verify="required" autocomplete="off"
                               class="layui-input" value="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="DB_PWD" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">数据库名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="DB_NAME" required lay-verify="required" autocomplete="off"
                               class="layui-input" value="">
                    </div>
                    <div class="layui-form-mid layui-word-aux">不能有特殊符号</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">表前缀</label>
                    <div class="layui-input-inline">
                        <input type="text" name="DB_PREFIX" required lay-verify="required" autocomplete="off"
                               class="layui-input" value="rh_">
                    </div>
                    <div class="layui-form-mid layui-word-aux">建议使用默认</div>
                </div>

                <hr>

                <h3>管理员配置</h3><br>
                <div class="layui-form-item">
                    <label class="layui-form-label">账户</label>
                    <div class="layui-input-block" style="max-width: 500px;">
                        <input type="text" name="username" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" lay-verify="required" autocomplete="off"
                               class="layui-input">
                    </div>
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password_confirmation" lay-verify="required" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>
                <br>

                <div class="layui-progress layui-progress-big" lay-showpercent="true" lay-filter="demo"
                     style="display: none;" id="progress">
                    <div class="layui-progress-bar layui-bg-blue" lay-percent="0%"></div>
                </div>

                <div class="layui-form-item">
                    <div style="margin:10px auto;width: 190px;">
                        <a href="{{url('install/step2')}}" class="layui-btn" style="background: #C0C0C0">上一步</a>
                        <button class="layui-btn blue" lay-submit="" lay-filter="formDemo">创建数据</button>
                    </div>
                </div>
            </form>
            <div style="display: none;text-align: center;" id="complete">
                <h1>安装完成!</h1><br><br><br>
                <p>手机端访问地址：{{$_SERVER['HTTP_HOST']}}/h5/index.html</p>
                <a href="/cms" class="layui-btn blue">访问后台</a>
            </div>
        </div>
    </div>
</div>

<script src="../../static/layui/layui.js" charset="utf-8"></script>
<script>
    layui.use(['element', 'jquery', 'layer', 'form'], function () {
        var $ = layui.jquery, layer = layui.layer, form = layui.form, element = layui.element;

        var n = 0;

        //监听提交
        form.on('submit(formDemo)', function (data) {
            $('#progress').css('display', 'block');
            var timer = setInterval(function () {
                n = n + Math.random() * 10 | 0;
                if (n > 99) {
                    n = 99;
                    clearInterval(timer);
                }
                element.progress('demo', n + '%');
            }, 30 + Math.random() * 100);

            $.ajax({
                url: "{{url('install/create_data')}}",
                type: "post",
                data: data.field,
                beforeSend: function () {
                    // 禁用按钮防止重复提交
                    $("#formDemo").attr({disabled: "disabled"});
                    $('#formDemo').html('创建中...');
                },
                success: function (res) {
                    if (res.status != 200) {
                        $('#progress').css('display', 'none');
                        layer.msg(res.msg);
                    } else {
                        if (n == 99) {
                            element.progress('demo', 100 + '%');
                            $('#form').hide();
                            $('#complete').show();
                            return false;
                        } else if (n < 99) {
                            var ref = setInterval(function () {
                                if (n == 99) {
                                    clearInterval(ref);
                                    element.progress('demo', 100 + '%');
                                    $('#form').hide();
                                    $('#complete').show();
                                }
                            }, 500)
                        }
                    }
                },
                complete: function () {
                    $("#formDemo").removeAttr("disabled");
                    $('#formDemo').html('提交');
                }
            })
            return false;
        });

    });
</script>

</body>
</html>