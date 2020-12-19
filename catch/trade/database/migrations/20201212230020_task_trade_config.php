<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class TaskTradeConfig extends Migrator
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
        $table = $this->table('trade_config', ['engine' => 'InnoDB', 'collation' => 'utf8mb4_0900_ai_ci', 'comment' => '财务配置表' ,'id' => 'id','signed' => true ,'primary_key' => ['id']]);
        $table->addColumn('pid', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '父级配置',])
			->addColumn('name', 'char', ['limit' => 255,'null' => false,'default' => '','signed' => true,'comment' => '配置名称',])
			->addColumn('component', 'char', ['limit' => 255,'null' => false,'default' => '','signed' => true,'comment' => 'tabs组件',])
			->addColumn('key', 'char', ['limit' => 255,'null' => false,'default' => '','signed' => true,'comment' => '配置key',])
			->addColumn('value', 'string', ['limit' => 1024,'null' => false,'default' => '','signed' => true,'comment' => '配置值',])
			->addColumn('created_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '创建时间',])
			->addColumn('updated_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => false,'comment' => '更新时间',])
			->addColumn('deleted_at', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'null' => false,'default' => 0,'signed' => true,'comment' => '软删除',])
			->addIndex(['key'], ['unique' => true,'name' => 'key'])
            ->create();
    }
}
