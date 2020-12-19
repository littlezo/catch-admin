<?php

declare(strict_types=1);

namespace catcher\base;

use catcher\CatchQuery;
use catcher\traits\db\BaseOptionsTrait;
use catcher\traits\db\TransTrait;
use think\model\concern\SoftDelete;
use catcher\traits\db\ScopeTrait;

/**
 *
 * @mixin CatchQuery
 * Class CatchModel
 * @package catcher\base
 */
abstract class CatchModel extends \think\Model
{
    use SoftDelete, TransTrait, BaseOptionsTrait, ScopeTrait;

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    protected $deleteTime = 'deleted_at';

    protected $defaultSoftDelete = 0;

    protected $autoWriteTimestamp = true;

    public const LIMIT = 10;

    // 开启
    public const ENABLE = 1;
    // 禁用
    public const DISABLE = 2;
    /**
     * 是否有 field
     *
     * @time 2020年11月23日
     * @param string $field
     * @return bool
     */
    public function hasField(string $field)
    {
        return property_exists($this, 'field') ? in_array($field, $this->field) : false;
    }

    /**
     * 更新事件
     */
    public static function onBeforeUpdate($data)
    {
        $fields =  self::getFields();
        $allow_field = [];
        foreach ($fields as $field) {
            $item = explode('|', $field['comment']);
            if (isset($item[3]) && $item[3] == 'false') {
                $allow_field[] =  $field['name'];
            }
        }
        if (!is_empty($allow_field)) {
            $data->readonly($allow_field);
        }
    }
}
