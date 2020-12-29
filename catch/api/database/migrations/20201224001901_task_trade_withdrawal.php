<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class TaskTradeWithdrawal extends Migrator
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
        $table = $this->table('trade_withdrawal', ['engine' => 'InnoDB', 'collation' => 'utf8mb4_0900_ai_ci', 'comment' => '会员提现流水' ,'id' => 'id','signed' => true ,'primary_key' => ['id']]);
        $table->addColumn('member_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '会员ID|read|true|false|false|false',])
			->addColumn('nick_name', 'char', ['limit' => 32,'null' => false,'default' => '','signed' => true,'comment' => '会员昵称|read|true|false|false|false',])
			->addColumn('real_name', 'char', ['limit' => 32,'null' => false,'default' => '','signed' => true,'comment' => '真实姓名|read|true|false|false|false',])
			->addColumn('bank_account', 'char', ['limit' => 32,'null' => false,'default' => '','signed' => true,'comment' => '收款账号|read|true|false|false|false',])
			->addColumn('bank_name', 'char', ['limit' => 32,'null' => false,'default' => '','signed' => true,'comment' => '账号名称|read|true|false|false|false',])
			->addColumn('account_type', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => true,'signed' => true,'comment' => '账号类型|hide|true|false|false|false|1:支付宝,2:微信,3:银行卡,4:其他',])
			->addColumn('member_mobile', 'char', ['limit' => 11,'null' => false,'default' => '','signed' => true,'comment' => '提现人手机号|read|true|false|false|false',])
			->addColumn('money', 'decimal', ['precision' => 8,'scale' => 2,'null' => false,'default' => 0,'signed' => true,'comment' => '提现金额|read|true|false|false|false',])
			->addColumn('pay_amount', 'decimal', ['precision' => 8,'scale' => 2,'null' => false,'default' => 0,'signed' => true,'comment' => '实付金额|read|true|false|false|false',])
			->addColumn('fee_rate', 'decimal', ['precision' => 8,'scale' => 2,'null' => false,'default' => 0,'signed' => true,'comment' => '手续费|read|true|false|false|false',])
			->addColumn('rate', 'decimal', ['precision' => 8,'scale' => 3,'null' => false,'default' => 0,'signed' => true,'comment' => '费率|read|true|false|false|false',])
			->addColumn('remark', 'char', ['limit' => 64,'null' => true,'signed' => true,'comment' => '备注|read|true|false|false|false',])
			->addColumn('order_id', 'char', ['limit' => 32,'null' => false,'default' => '','signed' => true,'comment' => '订单号|read|true|false|false|false',])
			->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '处理状态|option|true|false|false|false|0:等待审核,1:提现成功,2:提现失败',])
			->addColumn('creator_id', 'char', ['limit' => 10,'null' => true,'signed' => true,'comment' => '操作者ID|read|true|false|false|false',])
			->addColumn('created_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '创建时间|read|true|false|false|false',])
			->addColumn('updated_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '更新时间|read|true|false|false|false',])
			->addColumn('deleted_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '软删除|hide|true|false|false|false',])
            ->create();
    }
}
