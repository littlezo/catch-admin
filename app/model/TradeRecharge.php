<?php

namespace app\model;

use catcher\base\CatchModel as Model;
use catcher\traits\db\BaseOptionsTrait;
use catcher\traits\db\ScopeTrait;
// 数据库字段映射
class TradeRecharge extends Model
{
    use BaseOptionsTrait, ScopeTrait;
    // 表名
    public $name = 'trade_recharge';
    public $field = array(
        // ID|read|true|false|false|false
        'id',
        // 收款人|read|true|false|false|false
        'enter_nane',
        // 收款账号|read|true|false|false|false
        'enter_account',
        // 账号名称|read|true|false|false|false
        'account_name',
        // 账号类型|option|true|false|false|false|1:支付宝,2:微信,3:银行卡,4:其他
        'account_type',
        // 充值金额|read|true|false|false|false
        'recharge_money',
        // 充值方式|read|true|false|false|false
        'recharge_method',
        // 交易凭证|read|true|false|false|false
        'payment_voucher',
        // 充值人姓名|read|true|false|false|false
        'recharge_name',
        // 充值人手机号|read|true|false|false|false
        'recharge_mobile',
        // 备注|read|true|false|false|false
        'remark',
        // 订单号|read|true|false|false|false
        'order_id',
        // 订单状态|read|true|false|false|false
        'status',
        // 会员ID|read|true|false|false|false
        'member_id',
        // 操作者ID|read|true|false|false|false
        'creator_id',
        // 创建时间|read|true|false|false|false
        'created_at',
        // 更新时间|read|true|false|false|false
        'updated_at',
        // 软删除|hide
        'deleted_at',
    );
}
