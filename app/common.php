<?php
// 应用公共文件

/**
 * 常用的正则运算
 *
 * 验证数字：^[0-9]*$
 * 验证n位的数字：^\d{n}$
 * 验证至少n位数字：^\d{n,}$
 * 验证m-n位的数字：^\d{m,n}$
 * 验证零和非零开头的数字：^(0|[1-9][0-9]*)$
 * 验证有两位小数的正实数：^[0-9]+(.[0-9]{2})?$
 * 验证有1-3位小数的正实数：^[0-9]+(.[0-9]{1,3})?$
 * 验证非零的正整数：^\+?[1-9][0-9]*$
 * 验证非零的负整数：^\-[1-9][0-9]*$
 * 验证非负整数（正整数 + 0）  ^\d+$
 * 验证非正整数（负整数 + 0）  ^((-\d+)|(0+))$
 * 验证长度为3的字符：^.{3}$
 * 验证由26个英文字母组成的字符串：^[A-Za-z]+$
 * 验证由26个大写英文字母组成的字符串：^[A-Z]+$
 * 验证由26个小写英文字母组成的字符串：^[a-z]+$
 * 验证由数字和26个英文字母组成的字符串：^[A-Za-z0-9]+$
 * 验证由数字、26个英文字母或者下划线组成的字符串：^\w+$
 * 验证用户密码:^[a-zA-Z]\w{5,17}$ 正确格式为：以字母开头，长度在6-18之间，只能包含字符、数字和下划线。
 * 验证是否含有 ^%&‘,;=?$\” 等字符：[^%&‘,;=?$\x22]+
 * 验证汉字：^[\u4e00-\u9fa5],{0,}$
 * 验证Email地址：^\w+[-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$
 * 验证InternetURL：^http://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?$ ；^[a-zA-z]+://(w+(-w+)*)(.(w+(-w+)*))*(?S*)?$
 * 验证电话号码：^(\(\d{3,4}\)|\d{3,4}-)?\d{7,8}$：–正确格式为：XXXX-XXXXXXX，XXXX-XXXXXXXX，XXX-XXXXXXX，XXX-XXXXXXXX，XXXXXXX，XXXXXXXX。
 * 验证身份证号（15位或18位数字）：^\d{15}|\d{}18$
 * 验证一年的12个月：^(0?[1-9]|1[0-2])$ 正确格式为：“01”-“09”和“1”“12”
 * 验证一个月的31天：^((0?[1-9])|((1|2)[0-9])|30|31)$    正确格式为：01、09和1、31。
 * 整数：^-?\d+$
 * 非负浮点数（正浮点数 + 0）：^\d+(\.\d+)?$
 * 正浮点数   ^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$
 * 非正浮点数（负浮点数 + 0） ^((-\d+(\.\d+)?)|(0+(\.0+)?))$
 * 负浮点数  ^(-(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*)))$
 * 浮点数  ^(-?\d+)(\.\d+)?
 * 是数字和数字字符串 is_numeric ( mixed $var ) and intval(mixed $var )
 * 判断是否为布尔型 is_bool();
 * 判断是否为浮点型 is_float();
 * 判断是否为整型 is_int();
 * 判断是否为数值型 is_numeric();
 * 判断是否为字符串 is_string();
 * 判断是否为数组 is_array();
 * 判断是否为对象 is_object();
 **/
if (!function_exists('request')) {
    /**
     * 获取当前Request对象实例
     * @return Request
     */
    function request(): \app\Request
    {
        return app('request');
    }
}
if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        $forwarded = request()->header("x-forwarded-for");
        if ($forwarded) {
            $ip = explode(',', $forwarded)[0];
        } else {
            $ip = request()->ip();
        }
        return $ip;
    }
}

/**
 * 成功的响应
 *
 * @time 2019年12月02日
 * @param array $data
 * @param $msg
 * @param int $code
 * @return array
 */
if (!function_exists('success')) {
    function success($data = [], $msg = 'success', $code = 200): array
    {
        return ([
            'code'    => $code,
            'message' => $msg,
            'data'    => $data,
        ]);
    }
}
/**
 * 错误的响应
 *
 * @time 2019年12月02日
 * @param string $msg
 * @param int $code
 * @return array
 */
if (!function_exists('fail')) {
    function fail($msg = '', $code = 40003): array
    {
        return ([
            'code' => $code,
            'message'  => $msg,
        ]);
    }
}
/**
 * 是否是手机号
 */
if (!function_exists('is_mobile')) {
    function is_mobile($value)
    {
        return preg_match("/^1[3-9]\d{9}$/", $value);
    }
}
/**
 * 是否是数字密码
 */
if (!function_exists('is_number_password')) {
    function is_number_password($value, $len = 6)
    {
        return preg_match("/^\d{" . $len . "}$/", $value);
    }
}
/**
 * 是否是QQ
 */
if (!function_exists('is_qq')) {
    function is_qq($value)
    {
        return preg_match("/^[1-9]\d{4,10}$/", $value);
    }
}
/**
 * 验证密码强度
 */
if (!function_exists('is_password')) {
    function is_password($value)
    {
        return preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]+\S{5,32}$/", $value);
    }
}
/**
 * 验证是否为空
 */
if (!function_exists('is_empty')) {
    function is_empty($value)
    {
        if ($value == '') {
            return true;
        }
        if ($value == "") {
            return true;
        }
        if ($value == null) {
            return true;
        }
        if ($value == false) {
            return true;
        }
        if ($value == "false") {
            return true;
        }
        if ($value == 'false') {
            return true;
        }
        if (empty($value)) {
            return true;
        }
        if (isset($value) == false) {
            return true;
        }
        if ($value == ' ') {
            return true;
        }
        if ($value == " ") {
            return true;
        }
        if ($value == "[]") {
            return true;
        }
        if ($value == "()") {
            return true;
        }
        if ($value == "{}") {
            return true;
        }
        return false;
    }
}

// 获取表格字段类型 option
if (!function_exists('tableType')) {
    function tableType($type): String
    {
        switch ($type) {
            case "read":
                $result = 'text';
                break;
            case "image":
                $result = "upload-image";
                break;
            case "preview":
                $result = "image";
                break;
            case "input":
                $result = "input";
                break;
            case "textarea":
                $result = "textarea";
                break;
            case "select":
                $result = "select";
                break;
            case "number":
                $result = "number";
                break;
            case "radio":
                $result = "radio";
                break;
            case "checkbox":
                $result = "checkbox";
                break;
            case "datetime":
                $result = "datetime";
                break;
            case "datetime-text":
                $result = "datetime-text";
                break;
            case "status":
                $result = "switch";
                break;
            case "yesno":
                $result = "switch";
                break;
            case "switch":
                $result = "switch";
                break;
            case "url":
                $result = "url";
                break;
            case "color":
                $result = "color";
                break;
            case "hasOne":
                $result = "select";
                break;
            case "hasMany":
                $result = "select";
                break;
            default:
                $result = 'text';
        }

        return $result;
    }
}
// 获取表单字段类型
if (!function_exists('formType')) {
    function formType($type): String
    {
        switch ($type) {
            case "read":
                $result = 'text';
                break;
            case "image":
                $result = "image-uploader";
                break;
            case "preview":
                $result = "image";
                break;
            case "input":
                $result = "input";
                break;
            case "textarea":
                $result = "textarea";
                break;
            case "number":
                $result = "number";
                break;
            case "radio":
                $result = "radio";
                break;
            case "checkbox":
                $result = "checkbox";
                break;
            case "datetime":
                $result = "datetime";
                break;
            case "datetimes":
                $result = "datetimerange";
                break;
            case "yesno":
                $result = "yesno";
                break;
            case "status":
                $result = "yesno";
                break;
            case "switch":
                $result = "switch";
                break;
            case "password":
                $result = "password";
                break;
            case "url":
                $result = "url";
                break;
            case "color":
                $result = "color";
                break;
            case "hasOne":
                $result = "select";
                break;
            case "hasMany":
                $result = "select";
                break;
            case "quill":
                $result = "quill-editor";
                break;
            case "tag":
                $result = "tag";
                break;
            default:
                $result = 'text';
        }
        return $result;
    }
}
// 获取搜索字段类型
if (!function_exists('filterType')) {
    function filterType($type): String
    {
        switch ($type) {
            case "input":
                $result = "input";
                break;
            case "select":
                $result = "select";
                break;
            case "radio":
                $result = "select";
                break;
            case "checkbox":
                $result = "checkbox";
                break;
            case "datetime":
                $result = "datetime";
                break;
            case "status":
                $result = "select";
                break;
            case "switch":
                $result = "select";
                break;
            case "yesno":
                $result = "select";
                break;
            case "hasOne":
                $result = "select";
                break;
            case "hasMany":
                $result = "select";
                break;
            default:
                $result = "input";
        }
        return $result;
    }
}
