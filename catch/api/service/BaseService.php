<?php

namespace catchAdmin\api\service;

use think\helper\Str;
use catchAdmin\sms\Sms;
use think\facade\Cache;

class BaseService
{

    /**
     *   获取验证码
     * @time 2020年12月16日 17:28
     * @param string $mobile 
     * @var think\facade\Cache $cache
     * 
     */
    public static function getCode($mobile)
    {
        if (!isset($mobile) && empty($mobile))
            return fail('手机号不能为空', 40003);
        if (Cache::store('redis')->get('local_' . $mobile))
            return fail('请勿重复发送，1分支之内只能获取一条', 40003);
        Cache::delete('code_' . $mobile);
        Cache::store('redis')->set('code_' . $mobile, Str::random(6, 1), 300);
        $code = Cache::store('redis')->get('code_' . $mobile);
        try {
            $sms = Sms::aliyun();
            $sms->template('verify_code');
            $aliyun = $sms->send($mobile, ['code' => $code])['aliyun'];
        } catch (\Exception $e) {
            $data = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'tree' => $e->getTrace(),
                'TraceAs' => $e->getTraceAsString(),
            ];
            return fail('当天发送次数超限，请明天再试', 40003);
        }
        Cache::store('redis')->set('local_' . $mobile, $code, 60);
        Cache::store('redis')->set('code_' . $mobile, $code, 300);
        Cache::store('redis')->set('verify_' . $mobile, 6, 300);
        if (isset($aliyun['status']) && $aliyun['status'] === 'success') {
            return success(true, '发送成功，切勿泄露验证码给他人', 20000);
        }
        return fail('发送失败请稍后再试', 40003);
    }

    /**
     * 验证验证码
     * @time 2020年12月16日 17:28
     * @param number $mobile
     * @param number $code
     * @return json
     */
    public function checkCode($mobile, $code)
    {
        if (!$mobile && !$code) {
            return fail('参数错误');
        }
        if (!Cache::store('redis')->dec('verify_' . $mobile)) {
            Cache::store('redis')->delete('local_' . $mobile);
            Cache::store('redis')->delete('verify_' . $mobile);
            Cache::store('redis')->delete('code_' . $mobile);
            return fail('验证无效，请重新获取');
        }
        if ((int)Cache::store('redis')->get('code_' . $mobile) === (int)$code) {
            Cache::store('redis')->delete('local_' . $mobile);
            Cache::store('redis')->delete('verify_' . $mobile);
            return success(Cache::store('redis')->delete('code_' . $mobile));
        }
        if (!Cache::store('redis')->get('code_' . $mobile))
            return fail('验证码无效，请重新获取');
        else
            return fail('验证码错误');
    }
}
