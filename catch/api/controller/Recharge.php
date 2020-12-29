<?php

namespace catchAdmin\api\controller;

use app\model\Member;
use catcher\CatchAuth;
use app\model\TradeConfig;
use catcher\CatchResponse;
use catcher\base\CatchController;
use catcher\base\CatchRequest as Request;
use app\model\TradeRecharge as tradeRechargeModel;

class Recharge extends CatchController
{
    protected $tradeRechargeModel;
    protected $auth;
    protected $user;
    protected $config;

    public function __construct(TradeRechargeModel $tradeRechargeModel, CatchAuth $auth, Member $user, TradeConfig $config)
    {
        $this->tradeRechargeModel = $tradeRechargeModel;
        $this->auth = $auth;
        $this->user = $user;
        $this->config = $config;
    }

    /**
     * 列表
     * @time 2020年12月24日 00:22
     * @param Request $request
     */
    public function index(Request $request): \think\Response
    {
        return CatchResponse::paginate($this->tradeRechargeModel->getList());
    }

    /**
     * 保存信息
     * @time 2020年12月24日 00:22
     * @param Request $request
     */
    public function save(Request $request): \think\Response
    {
        $data = $request->post();
        return CatchResponse::success($data);
        return CatchResponse::success($this->tradeRechargeModel->storeBy($data));
    }

    /**
     * 读取
     * @time 2020年12月24日 00:22
     * @param $id
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->tradeRechargeModel->findBy($id));
    }

    /**
     * 更新
     * @time 2020年12月24日 00:22
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->tradeRechargeModel->updateBy($id, $request->post()));
    }

    /**
     * 删除
     * @time 2020年12月24日 00:22
     * @param $id
     */
    public function delete($id): \think\Response
    {
        return CatchResponse::success($this->tradeRechargeModel->deleteBy($id));
    }
}
