<?php

namespace app\model;

use catcher\base\CatchModel as Model;
use catcher\traits\db\BaseOptionsTrait;
use catcher\traits\db\ScopeTrait;
// 数据库字段映射
class TradeWithdrawal extends Model
{
    use BaseOptionsTrait, ScopeTrait;
    // 表名
    public $name = 'trade_withdrawal';
    public $field = array(
        // ID|read|true|false|false|false
        'id',
        // 会员ID|read|true|false|false|false
        'member_id',
        // 会员昵称|read|true|false|false|false
        'nick_name',
        // 真实姓名|read|true|false|false|false
        'real_name',
        // 收款账号|read|true|false|false|false
        'bank_account',
        // 账号名称|read|true|false|false|false
        'bank_name',
        // 账号类型|hide|true|false|false|false|1:支付宝,2:微信,3:银行卡,4:其他
        'account_type',
        // 提现人手机号|read|true|false|false|false
        'member_mobile',
        // 提现金额|read|true|false|false|false
        'money',
        // 实付金额|read|true|false|false|false
        'pay_amount',
        // 手续费|read|true|false|false|false
        'fee_rate',
        // 费率|read|true|false|false|false
        'rate',
        // 备注|read|true|false|false|false
        'remark',
        // 订单号|read|true|false|false|false
        'order_id',
        // 处理状态|option|true|false|false|false|0:等待审核,1:提现成功,2:提现失败
        'status',
        // 操作者ID|read|true|false|false|false
        'creator_id',
        // 创建时间|read|true|false|false|false
        'created_at',
        // 更新时间|read|true|false|false|false
        'updated_at',
        // 软删除|hide|true|false|false|false
        'deleted_at',
    );
}
