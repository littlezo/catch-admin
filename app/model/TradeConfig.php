<?php

namespace app\model;

use catcher\traits\db\ScopeTrait;
use catcher\base\CatchModel as Model;
use catcher\exceptions\FailedException;
use catcher\traits\db\BaseOptionsTrait;
// 数据库字段映射
class TradeConfig extends Model
{
    use BaseOptionsTrait, ScopeTrait;
    // 表名
    public $name = 'trade_config';
    public $field = array(
        // ID
        'id',
        // 父级配置
        'pid',
        // 配置名称
        'name',
        // tabs组件
        'component',
        // 配置key
        'key',
        // 配置值
        'value',
        // 创建时间
        'created_at',
        // 更新时间
        'updated_at',
        // 软删除
        'deleted_at',
    );
    /**
     *
     * @time 2020年04月17日
     * @return \think\Collection
     *@throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function getParentConfig()
    {
        return $this->where('pid', 0)
            ->field(['id', 'name', 'component'])->select();
    }

    /**
     * 存储配置
     *
     * @time 2020年04月20日
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return bool
     */
    public function storeBy(array $data)
    {
        if (empty($data)) {
            return true;
        }

        $parent = $data['parent'] ?? false;
        if (!$parent) {
            throw new FailedException('父配置丢失');
        }
        unset($data['parent']);

        $parentConfig = $this->where('key', $parent)->find();
        $config = [];
        foreach ($data as $key => $item) {
            foreach ($item as $k => $v) {
                if ($v) {
                    $config[$key . '.' . $v['key']] = [
                        'pid' => $parentConfig['id'],
                        'key' => $key . '.' . $v['key'],
                        'value' => $v['value'],
                        'name' => $v['name'],
                        'created_at' => time(),
                        'updated_at' => time(),
                    ];
                }
            }
        }
        // return $config;

        $this->where('pid', $parentConfig->id)
            ->select()
            ->each(function ($item) use (&$config) {
                if (isset($config[$item['key']])) {
                    if ($config[$item['key']]['value'] != $item->value) {
                        $item['value'] = $config[$item['key']]['value'];
                        $item['name'] = $config[$item['key']]['name'];
                        $item->save();
                    }
                    unset($config[$item['key']]);
                }
            });

        if (count($config)) {
            return $this->insertAll($config);
        }

        return true;
    }

    /**
     * 配置是否存在
     *
     * @time 2020年04月19日
     * @param $key
     * @param int $pid
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return array|Model|null
     */
    public function isExistConfig($key, $pid = 0)
    {
        return $this->where('pid', $pid)
            ->where('key', $key)
            ->find();
    }

    /**
     * 获取子配置
     *
     * @time 2020年04月19日
     * @param int $pid
     * @param array $field
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\Collection
     */
    public function subConfig($pid = 0, array $field = ['*'])
    {
        return $this->where('pid', $pid)
            ->field($field)
            ->select();
    }

    /**
     * 获取配置
     *
     * @time 2020年04月20日
     * @param string $component
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return array|mixed
     */
    public function getConfig(string $component)
    {
        $data = [];
        $configs = $this->where('pid', $this->where('component', $component)->value('id'))
            ->field('id,`key` as k,name,value,pid')
            ->select();

        foreach ($configs as $config) {
            if (strpos($config['k'], '.') !== false) {
                list($object, $key) = explode('.', $config['k']);
                $data[$object][$key]['key'] = $key;
                $data[$object][$key]['value'] = $config['value'];
                $data[$object][$key]['name'] = $config['name'];
            } else {
                $data[$config['k']] =  [
                    'id' =>  $config['id'],
                    'pid' =>  $config['pid'],
                    'key' =>  $config['k'],
                    'name' =>  $config['name'],
                    'value' =>  $config['value']
                ];
            }
        }

        return $data;
    }

    /**
     * 获取配置
     *
     * @time 2020年04月20日
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return array|mixed
     */
    public function getConfigList()
    {
        $parent = $this->where('pid', 0)
            ->field(['id', 'name', 'component'])->select();
        $data = [];
        foreach ($parent as $value) {
            $data[$value['component']] = $this->getConfig($value['component']);
        }
        return $data;
    }
}
