<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', function () {
//    return view('welcome');
//});
Route::any('',function (){
    echo '外卖点餐'.VAE_VERSION.'(商业板)';
});
Route::any('/index/admin/ue_uploads', 'cms\Common@ue_uploads');
//系统安装
Route::group(['prefix'=>'install'], function () {
    Route::get('', 'install\Index@step1');
    Route::get('step2', 'install\Index@step2');
    Route::get('step3', 'install\Index@step3');
    Route::post('create_data', 'install\Index@createData');
});

/**
 * cms
 */
Route::group(['prefix'=>'cms'],function (){
    Route::get('print_order', 'cms\Common@print_order');   //飞蛾打印机打印小票
    Route::get('get_config', 'cms\System@GetConfig');   //获取商城配置信息
    Route::post('edit_config', 'cms\System@edit_config');  //修改配置信息
    Route::post('login','cms\Admin@login');//管理员登录
    Route::get('down_new_version','cms\Upgrade@down_new_version');//下载最新版本(新接口)

    Route::get('back_code','cms\Upgrade@del_zip');//更新回调(新接口)
    Route::post('is_update','cms\Upgrade@is_update');//判断是否可以更新(新接口)
    Route::get('is_update_finish','cms\Upgrade@is_update_finish');//判断是否可以更新完毕(新接口)


    Route::get('get_file_size','cms\Upgrade@get_file_size');//获取文件大小(新接口)
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']],function () {
        Route::get('cms_download','cms\Upgrade@cms_download');//cms下载最新版本(新接口)
        Route::get('clear_cache','cms\Common@clear_cache');//清空缓存
        Route::get('clear_log','cms\Common@clear_log');//清空日志
        Route::get('get_sys_info','cms\Common@systemInfo');//查看系统环境
        Route::post('add_region', 'cms\Common@enterAddress');//批量添加地址
        Route::post('edit_region', 'cms\Common@editAddress');//修改地址地址
        Route::delete('del_region', 'cms\Common@delAddress');//删除地址
        Route::get('get_all_admin','cms\Admin@getAll');//获取所有管理员
        Route::delete('del_admin','cms\Admin@delAdmin');//删除管理员
        Route::post('add_admin','cms\Admin@addAdmin');//添加管理员
        Route::post('edit_psw','cms\Admin@editUserPwd');//添加管理员
    });

    Route::group(['prefix'=>'upgrande','middleware'=>['CheckCms']],function (){
        Route::get('get_new_version','cms\Upgrade@get_new_version');//获取最新版本(新接口)

        Route::get('get_version','cms\Upgrade@getVersion');//获取升级版本(老接口)
        Route::get('systemInstall','cms\Upgrade@systemInstall');//系统升级
        Route::post('download','cms\Upgrade@download');//下载更新包
    });
});
//搜索
Route::group(['prefix'=>'search'], function () {
    Route::get('record', 'common\Search@getSearchRecord');//搜索记录
    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_record', 'common\Search@addSearchGoods');//新增
        Route::put('del_record', 'common\Search@deleteSearchGoods');//删除
    });
});
/**
 * 用户
 */

Route::group(['prefix'=>'user'],function (){
    Route::group(['prefix'=>''],function (){
        Route::post('login', 'user\User@userLogin'); //模拟用户登录
        Route::get('info', 'user\User@getInfo'); //获取用户基础信息
        Route::get('get_points', 'user\UserPoints@getPointsNum');//用户查看积分
        Route::get('sign', 'common\Points@signAddPoints');//签到添加积分
        Route::get('getQrCode','user\User@getQrCode');
    });
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']],function (){
        Route::get('get_all','cms\UserManage@getAllUser');//获取所有用户
        Route::delete('del_user','cms\UserManage@delUser');//删除用户
        Route::post('edit_user', 'cms\UserManage@editUser');//修改用户信息
        Route::get('get_one_user', 'cms\UserManage@getUser');//获取用户详情
    });
});
/**
 * 用户等级
 */
Route::group(['prefix'=>'level'],function () {
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']],function () {
        Route::post('add_level', 'cms\UserLevel@addLevel');//新增用户等级
        Route::get('get_all_level', 'cms\UserLevel@getALLLevel');//获取所有用户等级
        Route::put('del_level', 'cms\UserLevel@delLevel');//删除用户等级
        Route::post('edit_level', 'cms\UserLevel@editLevel');//修改用户等级
    });
});
/**
 * 公共
 */
Route::group(['prefix'=>'index'],function () {
    Route::group(['prefix'=>''],function () {
        Route::get('verify_token','common\Common@verifyToken');//验证token
        Route::get('get_address', 'common\Common@getAddress');  //获取地址列表
        Route::get('get_all_zz', 'cms\Zhgl@getAllZZ');//获取所有桌子
         Route::get('get_zz_num', 'cms\Zhgl@get_url');//获取桌子小程序码
    });
    //用户
    Route::group(['prefix'=>'user'], function () {
        Route::get('sys_config', 'common\Common@getSysConfig');//前端获取部分配置信息
        Route::get('get_merchant', 'common\Common@getMerchant');//前端获取商家信息
    });
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']],function () {
        Route::post('add_zz', 'cms\Zhgl@addZZ');//添加桌子
        Route::get('get_all_zz', 'cms\Zhgl@getAllZZ');//获取所有桌子
        Route::delete('del_zz', 'cms\Zhgl@delZZ');//删除桌子
        Route::post('edit_zz', 'cms\Zhgl@editZZ');//修改桌子信息
    });

});
/**
 * 微信
 */
Route::group(['prefix'=>'weixin'],function () {
    Route::post('get_xcx_token','user\Xcx@XcxLogin');//微信登录获取token
    Route::post('upinfo', 'user\Xcx@xcx_upinfo');   //更新用户昵称、头像
    Route::get('gzh_code','user\Xcx@getcode');//公众号获取code
    Route::get('get_gzh_token','user\Xcx@gzhLogin');//公众登录获取token
});
//商品
Route::group(['prefix'=>'product'], function () {
    //用户
    Route::group(['prefix'=>''], function () {
        Route::get('get_product', 'common\Product@getProduct');//获取某商品详情
        Route::get('get_recent', 'common\Product@getRecent');//获取最新商品
        Route::get('get_products', 'common\Product@getProducts');//获取所有菜品
        Route::get('get_cate_pros', 'common\Product@getCatePros');//获取某分类下所有商品
        Route::get('get_evaluate', 'common\Product@getEvaluate');//获取某个商品的所有评价
        Route::get('search', 'common\Search@searchGoods');//搜索菜品
    });

    //采集商品
//        Route::group('copy', function () {
//            Route::post('get_info', 'cms.ProductManage/getCopyProductInfo');//采集商品
//        });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_product', 'cms\ProductManage@addProduct');//添加商品
        Route::post('edit_product', 'cms\ProductManage@editProduct');//修改商品
        Route::put('del_product', 'cms\ProductManage@deleteProduct');//删除商品
        Route::post('set_sort', 'cms\ProductManage@setSort');//商品排序
        Route::post('set_good', 'cms\ProductManage@editGood');//设置商品属性
        Route::get('get_product', 'cms\ProductManage@getProduct');//获取所有上架商品，包含分页
        Route::get('get_products_down', 'cms\ProductManage@getProductsDown');//获取所有下架商品，包含分页
        Route::get('all_goods_info', 'cms\ProductManage@all_goods_info');//获取所有商品简略信息
        Route::get('all_goods_name', 'cms\ProductManage@allGoodsName');//获取所有商品id+名称
    });
});
//导航
Route::group(['prefix'=>'nav'], function () {
    //公共
    Route::group(['prefix'=>''], function () {
        Route::get('get_nav', 'cms\NavManage@getNav');//获取X级导航信息

    });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_nav', 'cms\NavManage@addNav');//新增导航
        Route::post('edit_nav', 'cms\NavManage@editNav');//修改导航
        Route::put('del_nav', 'cms\NavManage@deleteNav');//删除导航
        Route::get('all_nav', 'cms\NavManage@getNav');//cms 获取所有导航
        Route::post('set_sort', 'cms\NavManage@setSort');//更新排序导航
    });
});
//评价Rate
Route::group(['prefix'=>'rate'], function () {
    //公共
    Route::group(['prefix'=>''], function () {
        Route::get('goods_rate', 'common\Common@getGoodsRate');//获取某个商品的所有评价
        Route::get('get_all_rate', 'cms\RateManage@getAllRate');//获取所有评价
    });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_rate', 'cms\RateManage@addRate');//添加评价
        Route::post('add_reply', 'cms\RateManage@addReply');//回复
        Route::put('del_rate', 'cms\RateManage@deleteRate');//删除评价
        Route::get('get_all_rate', 'cms\RateManage@getAllRate');//获取所有评价
    });
});
//图片
Route::group(['prefix'=>'img_category'], function () {
    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_category', 'cms\ImageManage@addImageCategory');//添加图片分类
        Route::put('del_category', 'cms\ImageManage@deleteImageCategory');//删除图片分类
        Route::get('get_category', 'cms\ImageManage@getImageCategory');//获取所有分类
        Route::get('get_all_img', 'cms\ImageManage@getAllImage');//获取所有图片
        Route::post('edit_image', 'cms\ImageManage@editImage');//隐藏图片
        Route::post('/upload/img', 'cms\Common@uploadImg');   //上传图片
    });
    Route::post('/upload/img', 'cms\Common@uploadImg');   //上传图片
});
//视频
Route::group(['prefix'=>'video'], function () {
    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_video', 'cms\Common@uploadVideo');   //上传视频
        Route::get('get_all_video', 'cms\VideoManage@getAllVideo');//获取所有视频
        Route::post('edit_video', 'cms\VideoManage@editVideo');//隐藏视频
    });
});
//广告banner
Route::group(['prefix'=>'banner'], function () {
    //公共
    Route::group(['prefix'=>''], function () {
        Route::get('get_banner', 'common\Banner@getBannerItem');//获取某个广告
        Route::get('get_all_banner', 'common\Banner@getAllBanner');//获取所有广告位
        Route::get('banner_all_item', 'common\Banner@banner_all_item');//获取所有广告
        Route::get('get_banner_content', 'common\Banner@get_banner_content');//获取所有广告详情
        Route::get('get_member_equity', 'common\Banner@get_member_equity');//获取会员权限
    });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::get('banner_all_item', 'cms\BannerManage@adminAllBanner');//cms获取所有广告
        Route::post('add_banner', 'cms\BannerManage@addBanner');//添加广告
        Route::post('edit_banner', 'cms\BannerManage@editBanner');//修改广告
        Route::put('del_banner', 'cms\BannerManage@deleteBanner');//删除广告
        Route::post('set_sort', 'cms\BannerManage@setSort');//更新广告排序

    });
});
//优惠卷
Route::group(['prefix'=>'coupon'], function () {

    Route::group(['prefix'=>''], function () {
        Route::get('get_coupon', 'user\UserCoupon@getCoupon');//用户查看优惠券
        Route::get('add_coupon', 'user\UserCoupon@addUserCoupon');//用户领取优惠券
    });

    //用户
    Route::group(['prefix'=>'user'], function () {
        Route::get('get_coupon', 'user\UserCoupon@selectUserCoupon');//用户查看自己的优惠券
        Route::post('order_coupon', 'user\UserCoupon@selectStatusCoupon');//用户查看订单可用优惠券
    });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_coupon', 'cms\CouponManage@addCoupon');//创建优惠券
        Route::put('del_coupon', 'cms\CouponManage@deleteCoupon');//删除优惠券
        Route::get('get_coupon', 'cms\CouponManage@getCoupon');//获取优惠券

    });
});
//满减活动
Route::group(['prefix'=>'reduction'], function () {

    Route::group(['prefix'=>''], function () {
        Route::get('get_all_reduction', 'cms\Reduction@getReduction');//获取所有满减活动
        Route::get('get_one_reduction', 'cms\Reduction@getOneReduction');//查看某个满减活动的所有商品
        Route::get('get_reduction_goods', 'cms\Reduction@getReductionGoods');//获取满减活动的所有商品
    });
    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_reduction', 'cms\Reduction@addReduction');//创建满减
        Route::post('edit_reduction', 'cms\Reduction@editReduction');//修改满减
        Route::get('get_no_goods', 'cms\Reduction@getNoGoods');//获取没有满减的商品
        Route::put('del_reduction', 'cms\Reduction@deleteReduction');//删除满减
        Route::get('get_all_reduction', 'cms\Reduction@getReduction');//获取所有满减活动

    });
});
//统计
Route::group(['prefix'=>'statistic'], function () {

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::get('get_index_data', 'cms\Statistic@getCmsIndexData');//获取首页数据
        Route::post('get_table', 'cms\Statistic@getTableData');//获取首页图表数据
        Route::post('get_money', 'cms\Statistic@getMoneyData');//cms订单统计销售额
        Route::post('get_order', 'cms\Statistic@getOrderData');//cms统计订单数据
        Route::get('remind', 'cms\Statistic@remind');//获取首页图表数据
    });
});
//分类Category
Route::group(['prefix'=>'category'], function () {
    //公共
    Route::group(['prefix'=>''], function () {
        Route::get('get_category', 'common\Category@getCateLevel');//获取X级分类信息
        Route::get('all_category', 'common\Category@getAllCategory');//获取所有分类信息
        Route::get('category_cid', 'common\Category@getCateChildImg');//获取分类下所有子类与广告图
    });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::post('add_category', 'cms\CategoryManage@addCategory');//添加分类
        Route::post('edit_category', 'cms\CategoryManage@editCategory');//修改分类
        Route::put('del_category', 'cms\CategoryManage@deleteCategory');//删除分类
        Route::get('all_category', 'cms\CategoryManage@getCateSort');//cms 获取所有分类并排好序，包括隐藏
        Route::post('set_sort', 'cms\CategoryManage@setSort');//更新分类排序
    });
});
//文章
Route::group(['prefix'=>'article'], function () {
    //公共
    Route::group(['prefix'=>''], function () {
        Route::get('get_all_article', 'common\Article@getAllArticle');//获取所有的文章
        Route::get('get_article', 'common\Article@getArticle');//获取一篇公告
        Route::get('get_one_article', 'common\Article@getOneArticle');//获取文章详情
        Route::get('user_article', 'common\Article@userArticle');//用户获取文章
        Route::get('type_article', 'common\Article@getTypeArticle');//用户获取某个类型的文章
        Route::get('getPersonArtical', 'common\Article@getPersonArtical');//获取个人中心文章
    });

    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::get('get_all_article', 'cms\ArticleManage@adminGetAllArticle');//获取所有的文章
        Route::get('all_article_name', 'cms\ArticleManage@allArticleName');//获取所有的文章
        Route::post('add_article', 'cms\ArticleManage@addArticle');//添加文章
        Route::post('edit_article', 'cms\ArticleManage@editArticle');//修改文章
        Route::delete('del_article', 'cms\ArticleManage@deleteArticle');//删除文章

    });
});
//用户地址Address
Route::group(['prefix'=>'address'], function () {
    Route::post('add_address', 'user\UserAddress@addAddress');//添加地址
    Route::post('edit_address', 'user\UserAddress@editAddress');//修改地址
    Route::put('del_address', 'user\UserAddress@deleteAddress');//删除地址
    Route::get('get_all_address', 'user\UserAddress@getAllAddress');//获取用户所有的地址
    Route::get('get_one_address', 'user\UserAddress@getOneAddress');//获取用户某个地址详情
    Route::get('get_default_address', 'user\UserAddress@getAddressDefault');//获取默认地址
    Route::post('set_default_address', 'user\UserAddress@setUserAddressDefault');//设置默认地址
});
//收藏favorite
Route::group(['prefix'=>'favorite'], function () {
    Route::post('get_one_fav', 'user\UserFavorites@scFavGood'); //查询商品是否被某用户收藏
    Route::get('get_all_fav', 'user\UserFavorites@getFavorite');   //查询某用户收藏的所有商品
    Route::post('add_fav', 'user\UserFavorites@addFavorite');  //添加收藏商品
    Route::put('del_fav', 'user\UserFavorites@deleteFavorite');  //删除收藏，参数为id
});
//订单
Route::group(['prefix'=>'order'], function () {

    Route::group(['prefix'=>''], function () {
        Route::post('create', 'common\Order@CreateXcxOrder'); //小程序商品下单
        Route::post('/pay/pre_order', 'common\Pay@getPreOrder');//小程序支付
        Route::post('get_order_money', 'common\Common@get_Order_Money'); //计算订单总价
        Route::any('/pay/notify', 'common\Pay@receiveNotify');//小程序支付回调
        Route::post('/create_cart', 'common\Order@CreateCartOrder');//公众号下单
        Route::post('/second_pay', 'common\Pay@gzhPaySecond');   //公众号第二次支付
        Route::post('/gzh_pay', 'common\Pay@gzhPaySecond');   //公众号支付
        //Route::post('/vipsecond_pay', 'common.Pay/gzhVipPaySecond');   //公众号第二次支付开通会员
        Route::post('/back', 'common\Pay@gzh_back'); //公众号支付回调
        Route::get('close_order','common\Pay@CloseOrder'); //关闭订单


    });

    Route::group(['prefix'=>'user'], function () {
        Route::get('/all_order', 'user\UserOrder@getUserOrderAll'); //获取已完成订单信息
        Route::get('not_order', 'user\UserOrder@getUserOrder'); //获取未完成订单信息
        Route::post('/order_date', 'user\UserOrder@getOrderDate'); //统计订单数据
        Route::get('/get_order_one', 'user\UserOrder@getUserOrderOne'); //获取用户指定的一条订单信息
        Route::put('/del_order', 'user\UserOrder@deleteOrder'); //删除一条自己未支付的订单
        Route::post('/search', 'user\UserOrder@SearchOrder'); //搜索订单
        Route::post('/set_pj', 'user\UserOrder@set_pj'); //提交评价
        Route::post('/tui_kuan', 'user\UserOrder@tuikuan_approve'); //提交退款申请
        Route::post('/tui_back', 'cms\TuiManage@tui_back'); //提交退款申请
        Route::put('/receive', 'user\UserOrder@receive'); //确认收货
    });
    //管理员
    Route::group(['prefix'=>'admin','middleware'=>['CheckCms']], function () {
        Route::get('code_order', 'common\Common@addCode'); //扫码点餐
        Route::put('/del_order', 'cms\OrderManage@deleteOrder'); //cms删除订单
        Route::post('/get_order', 'cms\OrderManage@getOrderAll'); //CMS获取所有订单简要
        Route::post('/order_stats', 'cms\OrderManage@order_stats'); //CMS商品销售统计
        Route::post('/get_order_one', 'cms\OrderManage@GetOrderOne'); //获取指定订单详细--CMS
        Route::get('edit_courier', 'cms\OrderManage@editCourier'); //更新订单配送信息
        Route::post('/edit_remark', 'cms\OrderManage@editRemark'); //添加订单备注信息
        Route::post('/edit_price', 'cms\OrderManage@edit_price'); //修改订单价格
        Route::get('/get_tui_all', 'cms\TuiManage@getTuiAll'); //cms 获取所有退款信息
        Route::get('/get_zbzf_all', 'cms\EditOrder@getAll'); //cms 获取暂不支付订单
        Route::get('/edit_pay', 'cms\EditOrder@editPay'); //cms 修改支付状态
        Route::post('/tui_money', 'cms\TuiManage@TuiMoney'); //微信退款
        Route::post('/tui_bohui', 'cms\TuiManage@TuiBoHui'); //退款申请驳回
        Route::put('/update', 'cms\Common@upValue');   //更新某模型下的某布尔字段,如上下级架
    });
});




//分销
Route::group(['prefix'=>'fx'], function () {
    Route::get('get_fx_goods', 'cms\FxGoods@get_fx_goods');   //获取分销商品
    //管理员
    Route::group(['prefix'=>'admin'], function () {
        Route::post('add_fx_goods', 'cms\FxGoods@add_fxgoods');   //添加分销商品
        Route::post('update_fx_goods', 'cms\FxGoods@update_fx_goods');   //更新分销商品
        Route::post('del_fx_goods', 'cms\FxGoods@del_fx_goods');   //删除分销商品
        Route::get('get_no_fx_goods', 'cms\FxGoods@get_no_fx_goods');   //获取未参加分销的商品
        Route::get('get_fx_record', 'common\FxRecord@get_fx_record');   //获取分销记录

    });

    //user
    Route::group(['prefix'=>'user'], function () {
        Route::get('user_get_record', 'common\FxRecord@user_get_record');   //添加分销商品

    });
});