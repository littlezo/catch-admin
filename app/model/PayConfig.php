<?php

namespace app\model;

use catcher\base\CatchModel as Model;
// 数据库字段映射
class PayConfig extends Model
{
    // 表名
    public $name = 'pay_config';
    protected $pk = 'id';

    public $field = array(
        'id',
        // 配置key
        'key',
        // 配置值
        'valve',
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
        $config = [];
        foreach ($data as $key => $item) {
            foreach ($item as $k => $value) {
                if ($value) {
                    $config[$key . '.' . $k] = [
                        'key' => $key . '.' . $k,
                        'value' => $value,
                    ];
                }
            }
        }
        // return $config;
        $update = [];
        $this->select()->each(function ($item) use (&$config) {
            if (isset($config[$item['key']])) {
                if ($config[$item['key']]['value'] != $item->value) {
                    $item['value'] = $config[$item['key']]['value'];
                    $item->save();
                }
                unset($config[$item['key']]);
            }
        });
        if (count($config)) {
            return $this->insertAll($config);
        }
        return $update;
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
    public function isExistConfig($key)
    {
        return $this->where('key', $key)->find();
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
    public function subConfig(array $field = ['*'])
    {
        return $this->field($field)
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
    public function getConfig()
    {
        $data = [];
        $configs = $this->field('id,`key` as k,value')->select();
        foreach ($configs as $config) {
            if (strpos($config['k'], '.') !== false) {
                list($object, $key) = explode('.', $config['k']);
                $data[$object][$key] = $config['value'];
            }
        }

        return $data;
    }
}
