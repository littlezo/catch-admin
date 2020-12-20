<?php

namespace catchAdmin\api\controller;

use catcher\Code;
use app\model\Member;
use catcher\CatchAuth;
use app\model\TradeConfig;
use catcher\CatchResponse;
use thans\jwt\facade\JWTAuth;
use catcher\base\CatchController;
use catchAdmin\api\service\BaseService;
use catcher\base\CatchRequest as Request;

class User extends CatchController
{
    protected $user;
    protected $service;

    public function __construct(BaseService $service, Member $user)
    {
        $this->user = $user;
        $this->service = $service;
    }

    /**
     * 登录
     * @time 2020年12月16日 17:21
     * @param Request $request 
     */
    public function login(Request $request, CatchAuth $auth): \think\Response
    {
        $condition = $request->param();
        try {
            $token = $auth->guard('member')->username('mobile')->attempt($condition);
            $user = $auth->guard('member')->user();
            return CatchResponse::success([
                'token' => $token,
                'user' => $user,
            ], '登录成功');
        } catch (\Exception $exception) {
            $code = $exception->getCode();
            return CatchResponse::fail($code == Code::USER_FORBIDDEN ?
                '该账户已被禁用，请联系管理员' : '登录失败,请检查用户名和密码', Code::LOGIN_FAILED);
        }
    }

    /**
     * 用户登录成功后
     *
     * @time 2020年09月09日
     * @param $user
     * @param $token
     * @return void
     */
    protected function afterLoginSuccess($user)
    {
    }

    /**
     * 退出登录
     *
     * @time 2019年11月28日
     * @return \think\response\Json
     */
    public function logout(): \think\response\Json
    {
        return CatchResponse::success();
    }

    /**
     * 刷新 token
     *
     * @author JaguarJack
     * @email njphper@gmail.com
     * @time 2020/5/18
     * @return \think\response\Json
     */
    public function refreshToken()
    {
        return CatchResponse::success([
            'token' => JWTAuth::refresh()
        ], 'success', 30001);
    }

    /**
     * 注册
     * @time 2020年12月16日 17:21
     * @param Request $request 
     */
    public function register(Request $request): \think\Response
    {
        $data = $request->post();
        if (isset($data['invite_code']) && is_empty($data['invite_code']) || mb_strlen($data['invite_code'], "utf-8") !== 8) {
            return CatchResponse::fail("请输入正确的邀请码", 40003);
        }
        $inviter = $this->user->where('invite_code', $data['invite_code'])->find();
        if (!$inviter) {
            return CatchResponse::fail("推荐人不存在，请联系推荐人获取邀请码后重试", 40003);
        }
        if (isset($data['mobile']) && !is_mobile($data['mobile'])) {
            return CatchResponse::fail("请输入正确的手机号", 40003);
        } else {
            if ($this->user->where('mobile', $data['mobile'])->value('id'))
                return CatchResponse::fail("手机号已存在", 40003);
        }

        if (isset($data['nickname']) && is_empty($data['nickname']) || mb_strlen($data['nickname'], 'utf-8') < 3 || mb_strlen($data['nickname'], 'utf-8') > 10) {
            return CatchResponse::fail("用户名不能为空，且长度在3-10位之间" . mb_strlen($data['nickname'], "utf-8"), 40003);
        } else {
            if ($this->user->where('nickname', $data['nickname'])->value('id'))
                return CatchResponse::fail("用户名已存在", 40003);
        }
        $config = new TradeConfig;
        $register_config = $config->getConfig('trade');
        if (
            isset($register_config['register']['force_qq']['value']) &&
            (int)$register_config['register']['force_qq']['value'] &&
            isset($data['qq']) && !is_qq($data['qq'])
        ) {
            return CatchResponse::fail("请输入QQ号", 40003);
        }
        if (isset($data['password']) && !is_password($data['password'])) {
            return CatchResponse::fail("密码需同时含有字母和数字且以字母开头，长度在8-32之间", 40003);
        }
        if (isset($data['password_confirm']) && $data['password'] !== $data['password_confirm']) {
            return CatchResponse::fail("两次输入密码不一致", 40003);
        }
        if (isset($data['verify_code']) && is_empty($data['verify_code'])) {
            return CatchResponse::fail("请输入验证码", 40003);
        }
        $verify = $this->service->checkCode($data['mobile'], $data['verify_code']);
        if ($verify['code'] !== 200) {
            return CatchResponse::fail($verify['message'], $verify['code']);
        }
        $data['parent_id'] = $inviter['id'];
        $data['register_ip'] = getClientIp();
        return CatchResponse::success($this->user->register($data));
    }

    /**
     * 获取用户信息
     *
     * @time 2020年01月07日
     * @param CatchAuth $auth
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\response\Json
     */
    public function read(CatchAuth $auth): \think\Response
    {
        try {
            $id = $auth->guard('member')->user()->id;
            // 用户数据权限
            // return CatchResponse::success($id);
            return CatchResponse::success($this->user->findBy($id));
        } catch (\Exception $exception) {
            return CatchResponse::success();
        }
    }

    /**
     * 修改个人资料
     * @time 2020年12月16日 17:21
     * @param Request $request 
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->model->updateBy($id, $request->post()));
    }

    /**
     * 找回密码
     * @time 2020年12月16日 17:21
     * @param Request $request
     */
    public function retrieve(Request $request): \think\Response
    {
        $param = $request->param();
        if (
            isset($param['mobile']) && is_empty($param['mobile']) ||
            isset($param['verify_code']) && is_empty($param['verify_code']) ||
            isset($param['password']) && is_empty($param['password'])
        ) {
            return CatchResponse::fail("参数错误缺少必要参数", 40003);
        }
        $verify = $this->service->checkCode($param['mobile'], $param['verify_code']);
        if ($verify['code'] !== 200) {
            return CatchResponse::fail($verify['message'], $verify['code']);
        }
        $user_id = $this->user->where('mobile', $param['mobile'])->value('id');
        if (is_empty($user_id))
            return CatchResponse::fail("用户不存在", 40003);
        return CatchResponse::success($this->user->updateBy($user_id, ['password' => $param['password']]), '修改成功', 20000);
    }

    /**
     * 修改密码
     * @time 2020年12月16日 17:21
     * @param Request $request 
     * @param string $id
     */
    public function modifyPassword(Request $request, $type): \think\Response
    {
        return CatchResponse::success($this->model->updateBy($type, $request->post()));
    }
}
