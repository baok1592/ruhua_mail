<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\Controllers\server\StatisticService;

class Statistic extends BaseController
{
    /**
     * cms首页数据
     * @return mixed
     */
    public function getCmsIndexData(){
        $res= StatisticService::getCmsIndexData();
        return $this->go($res);
    }

    /**
     * cms图表统计
     * @return mixed
     */
    public function getTableData(){
       $res= StatisticService::getTableData();
       return $this->go($res);
    }
    /**
     * cms订单统计销售额
     * @return mixed
     */
    public function getMoneyData(){
        return StatisticService::getMoneyData();
    }
    /**
     * cms订单统计订单数据
     * @return mixed
     */
    public function getOrderData(){
        return StatisticService::getOrderData();
    }
    /**
     * 待处理事项统计
     * @return mixed
     */
    public function remind(){
        return StatisticService::remind();
    }

}