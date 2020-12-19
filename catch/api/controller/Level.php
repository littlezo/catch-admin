<?php

namespace catchAdmin\api\controller;

use catcher\base\CatchRequest as Request;
use catcher\CatchResponse;
use catcher\base\CatchController;
use app\model\Level as LevelModel;

class Level extends CatchController
{
    protected $model;

    public function __construct(LevelModel $model)
    {
        $this->model = $model;
    }

    /**
     * 获取等级列表
     * @time 2020年12月16日 17:28
     * @param Request $request 
     */
    public function index(Request $request): \think\Response
    {
        return CatchResponse::success($this->model->getLevelList());
    }

    /**
     * 获取等级信息
     * @time 2020年12月16日 17:28
     * @param $id 
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->model->findBy($id));
    }

    /**
     * 等级购买
     * @time 2020年12月16日 17:28
     * @param Request $request 
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->model->updateBy($id, $request->post()));
    }
}
