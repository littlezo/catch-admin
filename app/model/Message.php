<?php

namespace app\model;

use catcher\base\CatchModel as Model;
// 数据库字段映射
class Message extends Model
{
    // 表名
    public $name = 'message';
    public $field = array(
        // 消息ID|read|false|false|false|false
        'id',
        // 消息标题|input|true|true|true|false
        'title',
        // 消息内容|textarea|true|true|true
        'desc',
        // 创建时间|read|false|false|false|false
        'created_at',
        // 更新时间|read|false|false|false|false
        'updated_at',
        // 软删除|hide|false|false|false|false
        'deleted_at',
    );
}
