<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class TaskMemberVip extends Migrator
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
        $table = $this->table('member_vip', ['engine' => 'InnoDB', 'collation' => 'utf8mb4_0900_ai_ci', 'comment' => '会员等级表' ,'id' => 'id','signed' => true ,'primary_key' => ['id']]);
        $table->addColumn('level_code', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '等级代码|input|true|true|true|true',])
			->addColumn('next_level_code', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => true,'signed' => true,'comment' => '下一等级代码|input|true|true|true|true',])
			->addColumn('level_title_zh', 'char', ['limit' => 16,'null' => false,'default' => '','signed' => true,'comment' => '等级中文名称|input|true|true|true|true',])
			->addColumn('level_title_en', 'char', ['limit' => 16,'null' => false,'default' => '','signed' => true,'comment' => '等级英文名称|input|true|true|true|true',])
			->addColumn('min_factor', 'decimal', ['precision' => 10,'scale' => 0,'null' => false,'default' => 0,'signed' => true,'comment' => '最低条件|input|true|true|true|false',])
			->addColumn('max_factor', 'decimal', ['precision' => 10,'scale' => 0,'null' => false,'default' => 0,'signed' => true,'comment' => '最高条件|input|true|true|true|false',])
			->addColumn('one_level_reward', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '一级奖励|input|true|true|true|false',])
			->addColumn('tow_level_reward', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '二级奖励|input|true|true|true|false',])
			->addColumn('three_level_reward', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '三级奖励|input|true|true|true|false',])
			->addColumn('task_price', 'decimal', ['precision' => 10,'scale' => 2,'null' => true,'signed' => true,'comment' => '任务单价|input|true|true|true|false',])
			->addColumn('join_price', 'decimal', ['precision' => 10,'scale' => 2,'null' => true,'signed' => true,'comment' => '开通价格|input|true|true|true|false',])
			->addColumn('icon', 'string', ['limit' => 255,'null' => true,'signed' => true,'comment' => '会员图标|image|true|true|true|false',])
			->addColumn('index_bg', 'string', ['limit' => 255,'null' => true,'signed' => true,'comment' => '首页背景|image|true|true|true|false',])
			->addColumn('card_bg', 'string', ['limit' => 255,'null' => true,'signed' => true,'comment' => 'VIP背景|image|true|true|true|false',])
			->addColumn('top_bg', 'string', ['limit' => 255,'null' => true,'signed' => true,'comment' => '头部背景|image|true|true|true|false',])
			->addColumn('expire_day', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => -1,'signed' => true,'comment' => '有效期|input|true|true|true|false',])
			->addColumn('valid_invite', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '有效推荐|input|true|true|true|false',])
			->addColumn('reward_count', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '每日抢单数|input|true|true|true|false',])
			->addColumn('created_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '创建时间|hide|false|false|false|false',])
			->addColumn('updated_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '更新时间|hide|false|false|false|false',])
			->addColumn('deleted_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '软删除|hide|false|false|false|false',])
			->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 1,'signed' => true,'comment' => '状态|hide',])
			->addIndex(['level_code'], ['unique' => true,'name' => 'unique_level_code'])
            ->create();
    }
}
