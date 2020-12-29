<?php

namespace app\model;

use catcher\base\CatchModel as Model;
use catcher\traits\db\BaseOptionsTrait;
use catcher\traits\db\ScopeTrait;
// 数据库字段映射
class TradeHall extends Model
{
    use BaseOptionsTrait, ScopeTrait;
    // 表名
    public $name = 'trade_hall';
    public $field = array(
        // 大厅ID|read|true|false|false|false
        'id',
        // 大厅代码|input|true|true|true|true
        'code',
        // 大厅logo|image|true|true|true|false
        'hall_img',
        // 大厅中文名称|input|true|true|true|true
        'title_zh',
        // 大厅英文名称|input|true|true|true|true
        'title_en',
        // 大厅状态|switch|true|true|true|true
        'status',
        // 创建时间|read|true|false|false|false
        'created_at',
        // 更新时间|read|true|false|false|false
        'updated_at',
        // 软删除|hide|false|false|false|false
        'deleted_at',
    );
    /**
     * 获取大厅列表
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
