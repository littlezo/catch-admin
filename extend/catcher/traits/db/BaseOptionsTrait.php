<?php

declare(strict_types=1);

namespace catcher\traits\db;

use catcher\Utils;
use think\Collection;
use catcher\CatchModelCollection;

trait BaseOptionsTrait
{

    /**
     * 查询CURD布局
     *
     * @time 2020年04月28日
     * @return mixed
     */
    public function getLayout()
    {
        // $reflectObj = new ReflectionClass('Member');
        // $file_name = $reflectObj->getFileName();
        // $file1 = glob('Member.php');
        // var_dump($file_name);
        // $model = app('\\app\\model\\' . 'Member');
        // return json($model);
        $fields =  $this->getFields();
        $table = [];
        $add_form = [];
        $edit_form = [];
        $add_rules = [];
        $edit_rules = [];
        $filter = [];
        $items = [];
        // 正常
        // 字段中文名|字段类型|行编辑|创建|更新|筛选
        // 更新时间|data|false|false|false|false
        // 关联查
        // 字段中文名|关联类型|关联模型|关联外键|options字段 value,label
        // 会员等级|hasOne|Level|id|id,level_title
        foreach ($fields as $field) {
            $item = explode('|', $field['comment']);
            $items[] = count($item);
            if (count($item) === 1 || $item[1] == 'hide') {
                continue;
            }
            if (count($item) >= 2) {
                // 表头
                if (isset($item[2]) && !is_empty($item[2])) {
                    if ($field['name'] == 'password' || $field['name'] == 'pay_password') {
                        continue;
                    }
                    $array = [
                        'label' => $item[0],
                        'sortable' => true,
                        'type' => tableType($item[1]),
                    ];
                    if ($item[1] == "hasOne" || $item[1] == "hasMany") {
                        $class = '\\app\\model\\' . $item[6];
                        $model = new  $class;
                        $list = $model->field([$item[7], $item[8]])->select();
                        $array['options'] = [];
                        // $options_field = explode(',', $item[8]);
                        foreach ($list as $val) {
                            $array['options'][] = [
                                'value' => $val[$item[7]],
                                'text' => $val[$item[8]],
                            ];
                        }
                    }
                    if ($item[1] == "option") {
                        $options_list = explode(',', $item[6]);
                        foreach ($options_list as $val) {
                            $options_field = explode(':', $val);
                            $array['options'][] = [
                                'value' => $options_field[0],
                                'text' => $options_field[1],
                            ];
                        }
                    }
                    $table[$field['name']] = $array;
                }
                // 增加表单
                if (isset($item[3]) && !is_empty($item[3]) && $item[1] != 'read') {
                    $array = [
                        'label' => $item[0],
                        'type' => formType($item[1]),
                    ];
                    $add_rules[$field['name']] = [
                        'message' => $item[0],
                        'required' => $item[1] == "pay_password" || $item[1] == "status" || $item[1] == "switch" || $item[1] == "yesno" ? false : $field['notnull'],
                    ];

                    if ($item[1] == "hasOne" || $item[1] == "hasMany") {
                        $class = '\\app\\model\\' . $item[6];
                        $model = new  $class;
                        $list = $model->field([$item[7], $item[8]])->select();
                        $array['options'] = [];
                        // $options_field = explode(',', $item[8]);
                        foreach ($list as $val) {
                            $array['options'][] = [
                                'value' => $val[$item[7]],
                                'text' => $val[$item[8]],
                            ];
                        }
                    }

                    // if (formType($item[1]) == "input") {
                    //     $array['labelWidth'] = 200;
                    // }
                    $add_form[$field['name']] = $array;
                }
                // 修改表单
                if (isset($item[4]) && !is_empty($item[4]) && $item[1] != 'read') {
                    $array = [
                        'label' => $item[0],
                        'type' => formType($item[1]),
                    ];
                    $edit_rules[$field['name']] = [
                        'message' => $item[0],
                        'required' => $item[1] == "password" || $item[1] == "pay_password" || $item[1] == "status" || $item[1] == "switch" || $item[1] == "yesno" ? false : $field['notnull'],
                    ];
                    if ($item[1] == "hasOne" || $item[1] == "hasMany") {
                        $class = '\\app\\model\\' . $item[6];
                        $model = new  $class;
                        $list = $model->field([$item[7], $item[8]])->select();
                        $array['options'] = [];
                        // $options_field = explode(',', $item[8]);
                        foreach ($list as $val) {
                            $array['options'][] = [
                                'value' => $val[$item[7]],
                                'text' => $val[$item[8]],
                            ];
                        }
                    }
                    $edit_form[$field['name']] = $array;
                }
                // 筛选
                if (isset($item[5]) && !is_empty($item[5])) {
                    $array = [
                        'label' =>    $item[0],
                        'type' => filterType($item[1]),
                        'value' =>    $field['name'],
                    ];
                    if ($item[1] == "hasOne" || $item[1] == "hasMany") {
                        $class = '\\app\\model\\' . $item[6];
                        $model = new  $class;
                        $list = $model->field([$item[7], $item[8]])->select();
                        $array['options'] = [];
                        // $options_field = explode(',', $item[8]);
                        foreach ($list as $val) {
                            $array['options'][] = [
                                'value' => $val[$item[7]],
                                'text' => $val[$item[8]],
                            ];
                        }
                    }
                    if ($item[1] == "status" || $item[1] == "switch" || $item[1] == "yesno") {
                        $array['options'] = [
                            [
                                'text' => "否",
                                'type' => "danger",
                                'value' => 0,
                            ], [
                                'text' => "是",
                                'type' => "success",
                                'value' => 1,
                            ]
                        ];
                    }
                    $filter[] = $array;
                }
            }
        }
        $layout = [
            'filterRule' => $filter, // 筛选
            'tableTabs' => [], // 头部菜单
            'tableConfig' => [
                'isShowTopDelete' => false,
                'isShowRightDelete' => true,
                'header' =>  $table
            ], // 表头
            'addConfig' => [
                'inline' => true,
                // 'isShowResetBtn' => true,
                // 'isShowCancelBtn' => true,
                'submitBtnText' => "提交",
                'formDesc' => $add_form, // 新增数据字段
                'rules' => $add_rules, // 验证规则
            ], // 表格
            'editConfig' => [
                'inline' => true,
                // 'isShowResetBtn' => true,
                // 'isShowCancelBtn' => true,
                'submitBtnText' => "提交",
                'formDesc' => $edit_form, // 更新数据字段
                'rules' => $edit_rules, // 验证规则
            ], // 表格
            'topOptions' => [], //头部操作
            'rowActions' => [], // 行内操作
        ];
        return $layout;
    }
    /**
     * 查询列表
     *
     * @time 2020年04月28日
     * @return mixed
     */
    public function getList()
    {
        // ->catchJoin(Level::class, 'id', 'vip_level_id', ['level_title'])
        // $fields =  $this->getFields();

        // 不分页
        if (property_exists($this, 'paginate') && $this->paginate === false) {
            return $this->catchSearch()
                ->field('*')
                ->catchOrder()
                ->creator()
                ->select();
        }

        // 分页列表
        // return $this->catchJoin(\app\model\Level::class, 'id', 'min_vip_level', ['level_title']);

        return $this->catchSearch()
            ->field('*')
            ->catchOrder()
            ->hasJoin()
            ->creator()
            ->paginate();
    }

    /**
     *
     * @time 2019年12月03日
     * @param array $data
     * @return bool
     */
    public function storeBy(array $data)
    {
        if ($this->allowField($this->field)->save($data)) {
            return $this->{$this->getPk()};
        }

        return false;
    }

    /**
     * 用于循环插入
     *
     * @time 2020年04月21日
     * @param array $data
     * @return mixed
     */
    public function createBy(array $data)
    {
        $model = parent::create($data, $this->field, true);

        return $model->{$this->getPk()};
    }
    /**
     *
     * @time 2019年12月03日
     * @param $id
     * @param $data
     * @param string $field
     * @return bool
     */
    public function updateBy($id, $data, $field = ''): bool
    {
        if (static::update($data, [$field ?: $this->getPk() => $id], $this->field)) {
            return true;
        }

        return false;
    }

    /**
     *
     * @time 2019年12月03日
     * @param $id
     * @param array $field
     * @param bool $trash
     * @return mixed
     */
    public function findBy($id, array $field = ['*'], $trash = false)
    {
        if ($trash) {
            return static::onlyTrashed()->find($id);
        }


        return static::where($this->getPk(), $id)->field($field)->find();
    }

    /**
     *
     * @time 2019年12月03日
     * @param $id
     * @param $force
     * @return mixed
     */
    public function deleteBy($id, $force = false)
    {
        return static::destroy(is_array($id) ? $id : Utils::stringToArrayBy($id), $force);
    }

    /**
     * 批量插入
     *
     * @time 2020年04月19日
     * @param array $data
     * @return mixed
     */
    public function insertAllBy(array $data)
    {
        $newData = [];
        foreach ($data as $item) {
            foreach ($item as $field => $value) {
                if (!in_array($field, $this->field)) {
                    unset($item[$field]);
                }

                if (in_array('created_at', $this->field)) {
                    $item['created_at'] = time();
                }

                if (in_array('updated_at', $this->field)) {
                    $item['updated_at'] = time();
                }
            }
            $newData[] = $item;
        }
        return $this->insertAll($newData);
    }

    /**
     * @time 2019年12月07日
     * @param $id
     * @return mixed
     */
    public function recover($id)
    {
        return static::onlyTrashed()->find($id)->restore();
    }

    /**
     * 获取删除字段
     *
     * @time 2020年01月13日
     * @return mixed
     */
    public function getDeleteAtField()
    {
        return $this->deleteTime;
    }

    /**
     * 别名
     *
     * @time 2020年01月13日
     * @param $field
     * @return string
     */
    public function aliasField($field): string
    {
        return sprintf('%s.%s', $this->getTable(), $field);
    }

    /**
     * 禁用/启用
     *
     * @time 2020年06月29日
     * @param $id
     * @param string $field
     * @return mixed
     */
    public function disOrEnable($id, $field = 'status')
    {
        $model = $this->findBy($id);

        $status = $model->{$field} == self::DISABLE ? self::ENABLE : self::DISABLE;

        $model->{$field} = $status;

        return $model->save();
    }

    /**
     * rewrite collection
     *
     * @time 2020年10月20日
     * @param array|iterable $collection
     * @param string|null $resultSetType
     * @return CatchModelCollection|mixed
     */
    public function toCollection(iterable $collection = [], string $resultSetType = null): Collection
    {
        $resultSetType = $resultSetType ?: $this->resultSetType;

        if ($resultSetType && false !== strpos($resultSetType, '\\')) {
            $collection = new $resultSetType($collection);
        } else {
            $collection = new CatchModelCollection($collection);
        }

        return $collection;
    }
}
