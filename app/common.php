<?php
// 应用公共文件


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
if (!function_exists('is_mobile')) {
    function is_mobile($mobile)
    {
        return preg_match("/^1[3-9]\d{9}$/", $mobile);
    }
}
if (!function_exists('is_qq')) {
    function is_qq($qq)
    {
        return preg_match("/^[1-9]\d{4,10}$/", $qq);
    }
}
if (!function_exists('is_password')) {
    function is_password($password)
    {
        return preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]+\S{5,32}$/", $password);
    }
}
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
