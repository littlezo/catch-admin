<?php

namespace catchAdmin\api\controller;

use app\model\Member;
use catcher\CatchAuth;
use app\model\TradeConfig;
use catcher\CatchResponse;
use catcher\base\CatchController;
use catcher\base\CatchRequest as Request;
use app\model\TradeWithdrawal as tradeWithdrawalModel;

class Withdrawal extends CatchController
{
    protected $tradeWithdrawalModel;

    protected $auth;
    protected $user;
    protected $config;
    public function __construct(TradeWithdrawalModel $tradeWithdrawalModel, CatchAuth $auth, Member $user, TradeConfig $config)
    {
        $this->tradeWithdrawalModel = $tradeWithdrawalModel;
        $this->auth = $auth;
        $this->user = $user;
        $this->config = $config;
    }

    /**
     * 列表
     * @time 2020年12月24日 00:24
     * @param Request $request
     */
    public function index(Request $request): \think\Response
    {
        return CatchResponse::paginate($this->tradeWithdrawalModel->getList());
    }

    /**
     * 保存信息
     * @time 2020年12月24日 00:24
     * @param Request $request
     */
    public function save(Request $request): \think\Response
    {
        $param = $request->param();
        // 验证必要参数
        if (
            isset($param['number']) && is_empty($param['number']) ||
            isset($param['pay_password']) && is_empty($param['pay_password'])
        ) {
            return CatchResponse::fail("参数错误缺少必要参数", 40003);
        }
        // 获取提现配置
        $config = $this->config->getConfig('trade')['sys'];
        // 校验金额 withdraw_money_min withdraw_money_fee_rate
        if (
            (float)$config['withdraw_money_min']['value'] > $param['number']
        ) {
            return CatchResponse::fail("请输入正确提现金额，提现金额应大于 " . (float)$config['withdraw_money_min']['value'] . '元', 40003);
        }
        // 获取用户信息
        $user = $this->user->findBy($this->auth->guard('member')->user()->id);
        // 获取提现中金额
        (float)$in_amount = $this->tradeWithdrawalModel->where('member_id', $user->id)->where('status', 0)->sum('money');
        // 可提现金额
        (float)$may_amount = (float)$user->balance_total - $in_amount;
        // 判断可提现金额是否足够
        if ($may_amount < (float)$param['number']) {
            return CatchResponse::fail("可以余额不足，可提现金额最多 " . $may_amount  . '元', 40003);
        }
        // 验证支付密码
        if (!password_verify($param['pay_password'], $user->pay_password)) {
            return CatchResponse::fail('支付密码不正确', 40003);
        }
        // 组装数据
        $data = [
            'member_id' => (int) $user->id,
            'nick_name' =>  $user->nickname,
            'real_name' =>  $user->real_name,
            'bank_account' =>  $user->bank_account,
            'bank_name' => $user->bank_name,
            'member_mobile' => (int) $user->mobile,
            'money' => (float) $param['number'],
            'pay_amount' => (float) $param['number'] - ((float) $param['number'] * (float)$config['withdraw_money_fee_rate']['value']),
            'fee_rate' => (float) $param['number'] * (float)$config['withdraw_money_fee_rate']['value'],
            'rate' => (float)$config['withdraw_money_fee_rate']['value'],
            'order_id' => 'TX' . date("YmdHisU", time()),
            'status' => 0,
            'in_amount' => $in_amount,
            'may_amount' => $may_amount,
        ];
        return CatchResponse::success($this->tradeWithdrawalModel->storeBy($data));
    }

    /**
     * 读取
     * @time 2020年12月24日 00:24
     * @param $id
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->tradeWithdrawalModel->findBy($id));
    }

    /**
     * 更新
     * @time 2020年12月24日 00:24
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success();
    }

    /**
     * 删除
     * @time 2020年12月24日 00:24
     * @param $id
     */
    public function delete($id): \think\Response
    {
        return CatchResponse::success();
    }
}
