<?php

namespace catchAdmin\api\controller;

use app\model\Member;
use app\model\TradeHall;
use app\model\TradeConfig;
use catchAdmin\api\service\BaseService;
use catcher\CatchResponse;
use catcher\base\CatchController;
use catcher\base\CatchRequest as Request;
use think\response\Json;

class Config extends CatchController
{
    protected $user;
    protected $service;
    protected $config;
    protected $hall;

    public function __construct(BaseService $service, Member $user, TradeHall $tradeHall, TradeConfig $config)
    {
        $this->service = $service;
        $this->user = $user;
        $this->config = $config;
        $this->hall = $tradeHall;
    }

    /**
     *   获取验证码
     * @time 2020年12月16日 17:28
     * @param string $mobile 
     * @var think\facade\Cache $cache
     * 
     */
    public function getCode($mobile, $skip = false): \think\Response
    {
        if (!isset($mobile) && empty($mobile))
            return CatchResponse::fail('手机号不能为空', 40003);
        if (!$skip) {
            $user = $this->user->where('mobile', $mobile)->value('id');
            if (is_empty($user))
                return CatchResponse::fail('非法请求，账号不存在', 40003);
        }
        $send = $this->service->getCode($mobile);
        if ($send['code'] === 200) {
            return CatchResponse::success(true, '发送成功，切勿泄露验证码给他人', 40003);
        }
        return CatchResponse::fail($send['message'], $send['code']);
    }

    /**
     *  获取配置
     * @time 2020年12月16日 17:28
     * @param Request $request 
     */
    public function index(): \think\Response
    {
        // return CatchResponse::success();
        return CatchResponse::success($this->config->getConfigList());
    }

    /**
     * 获取条配置
     * @time 2020年12月16日 17:28
     * @param $id 
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->model->findBy($id));
    }
    /**
     * 获取任务大厅列表
     *
     * @time 2020年04月17日
     * @param \think\Request $request
     * @return Json
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function getHall(Request $request): \think\Response\Json
    {
        return CatchResponse::success($this->hall->getAppList());
    }
}
