<?php
// 应用公共文件


/**
 * 成功的响应
 *
 * @time 2019年12月02日
 * @param array $data
 * @param $msg
 * @param int $code
 * @return array
 */
function success($data = [], $msg = 'success', $code = 200): array
{
    return ([
        'code'    => $code,
        'message' => $msg,
        'data'    => $data,
    ]);
}
/**
 * 错误的响应
 *
 * @time 2019年12月02日
 * @param string $msg
 * @param int $code
 * @return array
 */
function fail($msg = '', $code = 40003): array
{
    return ([
        'code' => $code,
        'message'  => $msg,
    ]);
}
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
