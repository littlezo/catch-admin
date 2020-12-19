<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class TaskMember extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('member', ['engine' => 'InnoDB', 'collation' => 'utf8mb4_0900_ai_ci', 'comment' => '会员表流水' ,'id' => 'id','signed' => true ,'primary_key' => ['id']]);
        $table->addColumn('avatar', 'char', ['limit' => 255,'null' => true,'signed' => true,'comment' => '会员头像|image|true|true|true|false',])
			->addColumn('balance_total', 'decimal', ['precision' => 8,'scale' => 2,'null' => true,'signed' => true,'comment' => '余额合计|read|true|false|false',])
			->addColumn('diff_total', 'decimal', ['precision' => 8,'scale' => 2,'null' => false,'default' => 0,'signed' => true,'comment' => '冻结余额|read|true|false|false',])
			->addColumn('invite_code', 'char', ['limit' => 8,'null' => false,'default' => 0,'signed' => true,'comment' => '邀请码|read|true|false|false',])
			->addColumn('last_login_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => true,'signed' => true,'comment' => '最后登录时间|datetime|true|false|false|true',])
			->addColumn('password', 'char', ['limit' => 255,'null' => false,'default' => 0,'signed' => true,'comment' => '登录密码|password|true|true|true|false',])
			->addColumn('mobile', 'char', ['limit' => 11,'null' => false,'default' => '','signed' => true,'comment' => '手机号|input|true|true|true|true',])
			->addColumn('nickname', 'char', ['limit' => 32,'null' => true,'signed' => true,'comment' => '昵称|read|true|false|false|true',])
			->addColumn('profile', 'char', ['limit' => 255,'null' => true,'signed' => true,'comment' => '个性签名|read|true|false|false',])
			->addColumn('qq', 'char', ['limit' => 11,'null' => true,'signed' => true,'comment' => '会员QQ|read|true|false|false',])
			->addColumn('register_ip', 'char', ['limit' => 32,'null' => false,'default' => '','signed' => true,'comment' => '注册IP|read|true|false|false',])
			->addColumn('remark', 'char', ['limit' => 32,'null' => true,'signed' => true,'comment' => '备注|input|true|true|true|true',])
			->addColumn('uuid', 'char', ['limit' => 36,'null' => false,'default' => '','signed' => true,'comment' => 'uuid|read|false|false|false',])
			->addColumn('vip_expired_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => -1,'signed' => true,'comment' => '会员到期时间|datetime|false|false|true',])
			->addColumn('vip_level_code', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '会员等级|hasOne|true|true|true|true|Level|vip_level_code|level_title',])
			->addColumn('is_frozen', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '是否冻结|switch|true|true|false|true',])
			->addColumn('pay_password', 'char', ['limit' => 255,'null' => false,'default' => '','signed' => true,'comment' => '支付密码|password|true|true|true|false',])
			->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 1,'signed' => true,'comment' => '会员状态|switch|true|true|false|true',])
			->addColumn('is_inside', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '是否内部用户|switch|true|true|false|false',])
			->addColumn('channel', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '渠道|hide',])
			->addColumn('real_name', 'char', ['limit' => 8,'null' => false,'default' => '','signed' => true,'comment' => '真实名字|read|true|false|true',])
			->addColumn('id_card', 'char', ['limit' => 18,'null' => false,'default' => '','signed' => true,'comment' => '身份证号码|read|false|false|true',])
			->addColumn('collect_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => true,'signed' => true,'comment' => '收款资料ID|read|false|false|true',])
			->addColumn('parent_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '推荐人ID|read|true|false|true|true',])
			->addColumn('created_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '注册时间|datetime|true|false|false|false',])
			->addColumn('updated_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '更新时间|datetime|true|false|false|false',])
			->addColumn('deleted_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '软删除|hide',])
			->addIndex(['uuid'], ['unique' => true,'name' => 'unique_uuid'])
            ->create();
    }
}
