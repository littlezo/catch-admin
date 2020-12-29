<?php

namespace catchAdmin\api\controller;

use catcher\base\CatchRequest as Request;
use catcher\CatchResponse;
use catcher\base\CatchController;
use app\model\TradeGoods;

class Goods extends CatchController
{
    protected $model;

    public function __construct(TradeGoods $goods)
    {
        $this->model = $goods;
    }
    /**
     * 列表
     * @time 2020年12月16日 17:21
     * @param Request $request 
     */
    public function list(): \think\Response
    {
        $this->model->paginate = false;
        return CatchResponse::success($this->model->getAppList());
    }
    /**
     * 列表
     * @time 2020年12月16日 17:21
     * @param Request $request 
     */
    public function index(Request $request): \think\Response
    {
        return CatchResponse::paginate($this->model->getList());
    }

    /**
     * 保存信息
     * @time 2020年12月16日 17:21
     * @param Request $request 
     */
    public function save(Request $request): \think\Response
    {
        return CatchResponse::success($this->model->storeBy($request->post()));
    }

    /**
     * 读取
     * @time 2020年12月16日 17:21
     * @param $id 
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->model->findBy($id));
    }

    /**
     * 更新
     * @time 2020年12月16日 17:21
     * @param Request $request 
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->model->updateBy($id, $request->post()));
    }

    /**
     * 删除
     * @time 2020年12月16日 17:21
     * @param $id
     */
    public function delete($id): \think\Response
    {
        return CatchResponse::success($this->model->deleteBy($id));
    }
}
