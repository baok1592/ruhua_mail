<?php


namespace App\Http\Controllers\server;

use App\Http\models\Order as OrderModel;
use App\Http\models\Goods as GoodsModel;
use App\Http\models\User as UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class StatisticService
{
    /**
     * 待处理事项统计
     * @return mixed
     */
    public static function remind()
    {
        $shipment = OrderModel::where(['state' => 0, 'payment_state' => 1, 'shipment_state' => 0])->select(DB::raw('count(order_id) as all_num'))->first();
        $refund = OrderModel::where(['state' => -1, 'payment_state' => 1])->select(DB::raw('count(order_id) as all_num'))->first();
        $goods_stock = GoodsModel::getGoodsStock();
        $data['shipment'] = $shipment['all_num'] ? $shipment['all_num'] : 0;
        $data['tui'] = $refund['all_num'] ? $refund['all_num'] : 0;
        $data['goods_stock'] = $goods_stock ? $goods_stock : 0;
        $data['total'] = 0;
        foreach ($data as $v) {
            $data['total'] += $v;
        }
        return $data;
    }

    /**
     * cms首页数据统计
     * @return mixed
     */
    public static function getCmsIndexData()
    {
        $order = new OrderModel();
        $user = new UserModel();
        $GoodsModel=new GoodsModel();
        $shipment = $order->where(['state' => 0, 'payment_state' => 1, 'shipment_state' => 0])->select(DB::raw('count(*) as all_num'))->first();
        $total_order=$order->where([ 'payment_state' => 1])->select(DB::raw('count(*) as total'))->first();
        $refund = $order->where(['state' => -1, 'payment_state' => 1])->select(DB::raw('count(*) as all_num'))->first();
        $yesterday = $order->where(['state' => 1, 'payment_state' => 1])->whereYear('pay_time', date('y'))
            ->select(DB::raw('count(order_id) as yesterday_order','sum(order_money) as yesterday_money'))->first();
        $month_order = $order->where(['state' => 1, 'payment_state' => 1])->whereMonth('pay_time',date('m'))
            ->select(DB::raw('count(order_id) as month_order','sum(order_money) as month_money'))->first();
      //  $today_user = $user->whereDay('created_at',date('d'))->select(DB::raw('count(id) as all_user'))->first();
        $today_user = $user->select(DB::raw('count(id) as all_user'))->first();
        $month_user = $user->whereMonth('created_at',date('m'))->select(DB::raw('count(id) as all_user'))->first();
        $data['shipment'] = $shipment['all_num'] ? $shipment['all_num'] : 0;
        $data['tui'] = $refund['all_num'] ? $refund['all_num'] : 0;
        $data['month_order'] = $month_order['month_order'] ? $month_order['month_order'] : 0;
        $data['month_money'] = $month_order['month_money'] ? $month_order['month_money'] : 0;
        $data['yesterday_order'] = $yesterday['yesterday_order'] ? $yesterday['yesterday_order'] : 0;
        $data['yesterday_money'] = $yesterday['yesterday_money'] ? $yesterday['yesterday_money'] : 0;
        $data['today_user'] = $today_user['all_user'] ? $today_user['all_user'] : 0;
        $data['month_user'] = $month_user['all_user'] ? $month_user['all_user'] : 0;
        $total_money=$order->where(['state' => 1, 'payment_state' => 1])->select(DB::raw('sum(order_money) as sum'))->first();
        $goods=$GoodsModel->select(DB::raw('count(*) as sum'))->first();


        $data['total_order']=$total_order['total'];
        $data['total_money']=$total_money['sum'];
        $data['total_goods']=$goods['sum'];

        return $data;
    }

    /**
     * cms图表统计
     * @return mixed
     */
    public static function getTableData()
    {
        $month = Request::input('month');
        $time = self::getTime($month);
        $order = OrderModel::where('payment_state', 1)
            ->where('state', '>', '-1')
            ->whereMonth('pay_time', $time['time'])
            ->select();
        $user = UserModel::whereMonth('create_time', $time['time'])
            ->select();
        for ($i = 0; strtotime($time['time']) < strtotime($time['last_time']); $i++) {
            $data[$i]['day'] = $time['time'];
            $data[$i]['order_num'] = 0;
            $data[$i]['user_num'] = 0;
            $time['time'] = date('Y-m-d', strtotime('+1 day', strtotime($time['time'])));
        }
        foreach ($order as $k => $v) {
            $day = strtotime(date('Y-m-d', $v['pay_time']));
            foreach ($data as $key => $value) {
                if (strtotime($value['day']) == $day) {
                    $data[$key]['order_num'] += 1;
                }
            }
        }
        foreach ($user as $k => $v) {
            $day = strtotime(date('Y-m-d', strtotime($v['create_time'])));
            foreach ($data as $key => $value) {
                if (strtotime($value['day']) == $day) {
                    $data[$key]['user_num'] += 1;
                }
            }
        }
        return $data;
    }

    /**
     * 统计订单数据
     * @return mixed
     */
    public static function getOrderData()
    {
        $month = Request::input('month');
        $time = self::getTime($month);
        $data['normal_order'] = 0;
        $order = OrderModel::where('payment_state', 1)
            ->where('state', '>=', '1')
            ->whereMonth('pay_time', $time['time'])
            ->select();
        foreach ($order as $k => $v) {
            $data['normal_order'] += 1;
        }
        return $data;
    }

    /**
     * cms图表统计订单
     * @return mixed
     */
    public static function getMoneyData()
    {
        $month = Request::input('month');
        $time = self::getTime($month);
        $order = OrderModel::where('payment_state', 1)
            ->where('state', '>=', '1')
            ->whereMonth('pay_time', $time['time'])
            ->select();
        for ($i = 0; strtotime($time['time']) < strtotime($time['last_time']); $i++) {
            $data[$i]['day'] = $time['time'];
            $data[$i]['total_price'] = 0;
            $data[$i]['total_order'] = 0;
            $data[$i]['profit'] = 0;
            $time['time'] = date('Y-m-d', strtotime('+1 day', strtotime($time['time'])));
        }
        foreach ($order as $k => $v) {
            $day = strtotime(date('Y-m-d', $v['pay_time']));
            foreach ($data as $key => $value) {
                if (strtotime($value['day']) == $day) {
                    $data[$key]['total_price'] += $v['goods_money'];
                    $data[$key]['total_order'] += 1;
                }
            }
        }
        return app('json')->success($data);
    }

    private static function getTime($month)
    {
        if ($month) {
            $start = date('Y-m', $month);
            $end = date('Y-m', strtotime('+1 month', $month));
        } else {
            $start = date('Y-m', time());
            $end = date('Y-m', strtotime('+1 month', time()));
        }

        $date['time'] = $start;
        $date['last_time'] = $end;
        return $date;
    }

}