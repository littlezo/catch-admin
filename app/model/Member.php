<?php

namespace app\model;

use think\helper\Str;
use catcher\traits\db\ScopeTrait;
use catcher\base\CatchModel as Model;
use catcher\traits\db\BaseOptionsTrait;
// 数据库字段映射
class Member extends Model
{
    use BaseOptionsTrait, ScopeTrait;
    // 表名
    public $name = 'member';
    public $field = array(
        // 用户ID|read|true|false|false
        'id',
        // 会员头像|image|true|true|true|false
        'avatar',
        // 余额合计|read|true|false|false
        'balance_total',
        // 冻结余额|read|true|false|false
        'diff_total',
        // 邀请码|read|true|false|false
        'invite_code',
        // 最后登录时间|datetime|true|false|false|true
        'last_login_time',
        // 登录密码|password|true|true|true|false
        'password',
        // 手机号|input|true|true|true|true
        'mobile',
        // 昵称|read|true|false|false|true
        'nickname',
        // 个性签名|read|true|false|false
        'profile',
        // 会员QQ|read|true|false|false
        'qq',
        // 注册IP|read|true|false|false
        'register_ip',
        // 备注|input|true|true|true|true
        'remark',
        // uuid|read|false|false|false
        'uuid',
        // 会员到期时间|datetime|false|false|true
        'vip_expired_time',
        // 会员等级|hasOne|true|true|true|true|Level|vip_level_code|level_title
        'vip_level_code',
        // 是否冻结|switch|true|true|false|true
        'is_frozen',
        // 支付密码|password|true|true|true|false
        'pay_password',
        // 会员状态|switch|true|true|false|true
        'status',
        // 是否内部用户|switch|true|true|false|false
        'is_inside',
        // 渠道|hide
        'channel',
        // 真实名字|read|true|false|true
        'real_name',
        // 身份证号码|read|false|false|true
        'id_card',
        // 收款资料ID|read|false|false|true
        'collect_id',
        // 推荐人ID|read|true|false|true|true
        'parent_id',
        // 注册时间|datetime|true|false|false|false
        'created_at',
        // 更新时间|datetime|true|false|false|false
        'updated_at',
        // 软删除|hide
        'deleted_at',
    );
    /**
     * 查询列表
     *
     * @time 2020年04月28日
     * @return mixed
     */
    public function getList($inside = 0)
    {
        return $this->withoutField(['password', 'pay_password'], true)
            ->where('is_inside', $inside)
            ->catchSearch()
            ->catchJoin(Level::class, 'level_code', 'vip_level_code', ['level_title_zh'])
            // ->order($this->aliasField('id'), 'desc')
            ->paginate();
    }

    /**
     * set password
     *
     * @time 2019年12月07日
     * @param $value
     * @return false|string
     */
    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_ARGON2ID);
    }

    /**
     * set password
     *
     * @time 2019年12月07日
     * @param $value
     * @return false|string
     */
    public function setPayPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_ARGON2ID);
    }

    /**
     * 新增数据
     *
     * @time 2019年12月07日
     * @param $data
     */
    public static  function onBeforeInsert($data)
    {
        $data['uuid'] =  Str::upper(uuid_create(4));
        $data['invite_code'] = Str::random(8);
    }

    /**
     * 用户注册
     * @param array $data
     * @return object
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     *
     */
    public function register($data)
    {
        return $this->storeBy($data);
    }
}
