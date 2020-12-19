<?php

namespace catchAdmin\trade\controller;

use think\Request;
use catcher\CatchResponse;
use catcher\base\CatchController;
use app\model\TradeConfig as tradeConfigModel;
use app\model\PayConfig;

class TradeConfig extends CatchController
{
    protected $configModel;
    protected $payConfig;

    public function __construct(TradeConfigModel $configModel, PayConfig $payConfig)
    {
        $this->configModel = $configModel;
        $this->payConfig = $payConfig;
    }

    /**
     * 布局
     * @time 2020年11月30日 21:06
     * @param Request $request
     */
    public function layout(Request $request): \think\Response
    {
        return CatchResponse::success($this->configModel->getLayout());
    }

    /**
     * 获取父级别配置
     *
     * @time 2020年04月17日
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return Json
     */
    public function parent()
    {
        return CatchResponse::success($this->configModel->getParentConfig());
    }

    /**
     * 存储配置
     *
     * @time 2020年04月17日
     * @param $parent
     * @param Request $request
     * @return Json
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function save(Request $request)
    {
        // , Request $request
        // return CatchResponse::success($request->param());
        return CatchResponse::success([
            'id' => $this->configModel->storeBy($request->param()),
            'parents' => $this->configModel->getParentConfig(),
        ]);
    }

    /**
     * 获取配置
     *
     * @time 2020年04月20日
     * @param $parent
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return Json
     */
    public function read($parent)
    {
        return CatchResponse::success($this->configModel->getConfig($parent));
    }

    /**
     * 存储支付配置
     *
     * @time 2020年04月17日
     * @param \think\Request $request
     * @return Json
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function getHall(Request $request)
    {
        return CatchResponse::success($this->tradeHallModel->getList());
    }

    /**
     * 获取配置
     *
     * @time 2020年04月20日
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return Json
     */
    public function payRead()
    {
        return json(1231231);
        return CatchResponse::success($this->payConfig->getConfig());
    }
}
