<?php

namespace app\model;

use catcher\base\CatchModel as Model;
use catcher\traits\db\BaseOptionsTrait;
use catcher\traits\db\ScopeTrait;
// 数据库字段映射
class Level extends Model
{
    use BaseOptionsTrait, ScopeTrait;
    // 表名
    public $name = 'member_vip';
    public $field = array(
        // VIP ID|read|true|false|false|false
        'id',
        // 等级代码|input|true|true|true|true
        'level_code',
        // 下一等级代码|input|true|true|true|true
        'next_level_code',
        // 等级中文名称|input|true|true|true|true
        'level_title_zh',
        // 等级英文名称|input|true|true|true|true
        'level_title_en',
        // 最低条件|input|true|true|true|false
        'min_factor',
        // 最高条件|input|true|true|true|false
        'max_factor',
        // 一级奖励|input|true|true|true|false
        'one_level_reward',
        // 二级奖励|input|true|true|true|false
        'tow_level_reward',
        // 三级奖励|input|true|true|true|false
        'three_level_reward',
        // 任务单价|input|true|true|true|false
        'task_price',
        // 开通价格|input|true|true|true|false
        'join_price',
        // 会员图标|image|true|true|true|false
        'icon',
        // 首页背景|image|true|true|true|false
        'index_bg',
        // VIP背景|image|true|true|true|false
        'card_bg',
        // 头部背景|image|true|true|true|false
        'top_bg',
        // 有效期|input|true|true|true|false
        'expire_day',
        // 有效推荐|input|true|true|true|false
        'valid_invite',
        // 每日抢单数|input|true|true|true|false
        'reward_count',
        // 创建时间|hide|false|false|false|false
        'created_at',
        // 更新时间|hide|false|false|false|false
        'updated_at',
        // 软删除|hide|false|false|false|false
        'deleted_at',
        // 状态|hide
        'status',
    );
    /**
     * 获取等级列表
     * @time 2020年04月17日
     * @return \think\Collection
     *@throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function getLevelList()
    {
        $list = [];
        $this->catchSearch()
            ->field('*')
            ->catchOrder('asc')
            ->select()->each(function ($item) use (&$list) {
                unset($item['created_at']);
                unset($item['creator_id']);
                unset($item['deleted_at']);
                $list[$item['level_code']] = $item;
            });
        return $list;
    }
}
