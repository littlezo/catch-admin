<?php

namespace app\model;

use catcher\base\CatchModel as Model;
use catcher\traits\db\BaseOptionsTrait;
use catcher\traits\db\ScopeTrait;

// 数据库字段映射
class TradeGoods extends Model
{
    use BaseOptionsTrait;
    // 表名
    public $name = 'trade_goods';
    public $field = array(
        // ID|text|||input
        'id',
        // 佣金|text|input|input
        'commission',
        // 执行方法|text|input|input
        'exec_method',
        // 执行参数|text|input|input
        'exec_param',
        // 任务完成总量|text|input
        'fulfil_total',
        // 商品简介|text|input|input|input
        'goods_brief',
        // 商品详情|text|input|input
        'goods_detail',
        // 商品图片|upload-image|image-uploader|image-uploader
        'goods_img',
        // 商品标题|text|input|input|input
        'goods_title',
        // 最低会员等级|text|select|select|select
        'min_vip_level',
        // 库存总量|text|input|input|input
        'stock_total',
        // 任务代码|text|input|input|input
        'task_code',
        // 任务标题|text|input|input|input
        'task_title',
        // 创建时间|text|||date
        'created_at',
        // 更新时间|text|||date
        'updated_at',
        // 软删除
        'deleted_at',
    );

    /**
     * 获取APP列表
     * @time 2020年04月17日
     * @return \think\Collection
     *@throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function getAppList()
    {
        $list = [];
        $this->catchSearch()
            ->field('*')
            ->catchOrder('asc')
            ->select()->each(function ($item) use (&$list) {
                unset($item['created_at']);
                unset($item['creator_id']);
                unset($item['deleted_at']);
                $list[$item['id']] = $item;
            });
        return $list;
    }
}
