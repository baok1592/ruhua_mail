<?php


namespace App\ruhua\bases;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DateTimeInterface;

abstract class BaseModel extends Model
{
    /**
     * 返回表名，不用处理单数复数
     */
    //use DateTimeInterface;
    public function getTable()
    {

        return $this->table ?? Str::snake(class_basename($this));

    }
    //格式化模型输出时间
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}