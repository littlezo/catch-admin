<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class TaskTradeHall extends Migrator
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
        $table = $this->table('trade_hall', ['engine' => 'InnoDB', 'collation' => 'utf8mb4_0900_ai_ci', 'comment' => '任务大厅表' ,'id' => 'id','signed' => true ,'primary_key' => ['id']]);
        $table->addColumn('code', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => true,'signed' => true,'comment' => '大厅代码|input|true|true|true|true',])
			->addColumn('hall_img', 'char', ['limit' => 255,'null' => true,'signed' => true,'comment' => '大厅logo|image|true|true|true|false',])
			->addColumn('title_zh', 'char', ['limit' => 32,'null' => true,'signed' => true,'comment' => '大厅中文名称|input|true|true|true|true',])
			->addColumn('title_en', 'char', ['limit' => 32,'null' => true,'signed' => true,'comment' => '大厅英文名称|input|true|true|true|true',])
			->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 1,'signed' => true,'comment' => '大厅状态|switch|true|true|true|true',])
			->addColumn('created_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '创建时间|read|true|false|false|false',])
			->addColumn('updated_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '更新时间|read|true|false|false|false',])
			->addColumn('deleted_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '软删除|hide|false|false|false|false',])
			->addIndex(['code'], ['unique' => true,'name' => 'unique_code'])
            ->create();
    }
}
