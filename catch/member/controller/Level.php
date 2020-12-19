<?php

namespace catchAdmin\member\controller;

use catcher\CatchResponse;
use catcher\base\CatchController;
use app\model\Level as levelModel;
use catcher\base\CatchRequest as Request;

class Level extends CatchController
{
    protected $levelModel;

    public function __construct(LevelModel $levelModel)
    {
        $this->levelModel = $levelModel;
    }
    /**
     * 获取布局
     * @time 2020年11月27日 06:13
     * @param Request $request
     */
    public function layout(): \think\Response
    {
        return CatchResponse::success($this->levelModel->getLayout());
    }
    /**
     * 列表
     * @time 2020年11月27日 06:13
     * @param Request $request
     */
    public function index(): \think\Response
    {
        return CatchResponse::paginate($this->levelModel->getList());
    }

    /**
     * 保存信息
     * @time 2020年11月27日 06:13
     * @param Request $request
     */
    public function save(Request $request): \think\Response
    {
        return CatchResponse::success($this->levelModel->storeBy($request->post()));
    }

    /**
     * 读取
     * @time 2020年11月27日 06:13
     * @param $id
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->levelModel->findBy($id));
    }

    /**
     * 更新
     * @time 2020年11月27日 06:13
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->levelModel->updateBy($id, $request->post()));
    }

    /**
     * 删除
     * @time 2020年11月27日 06:13
     * @param $id
     */
    public function delete($id): \think\Response
    {
        return CatchResponse::success($this->levelModel->deleteBy($id));
    }
}
