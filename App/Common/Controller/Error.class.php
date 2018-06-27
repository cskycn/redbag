<?php

namespace Common\Controller;
class Error
{
    const ERR_ILLEGAL_REQUEST = -1;
    const ERR_OK = 200;
    const ERR_FATAL = 1001;
    const ERR_GENERAL = 1002;
    const ERR_NOT_IMPLEMENTED_YET = 1000;
    const ERR_KEY_ERROR = 1003;
    const ERR_TOKEN_ERROR = 1004;
    const ERR_MISS_PARAMETERS = 1005;
    const ERR_ACCOUNT_OR_PASSWD_ERROR = 1006;
    const ERR_RECODE_NOT_FOUND_ERROR = 1007;
    const ERR_REGISTER_ERROR = 1008;
    const ERR_UPDATE_ERROR = 1009;
    const ERR_LOGIN_PASSWD_ERROR = 1010;
    const ERR_VERCODE_CHECK_ERROR = 1011;
    const ERR_TEL_EXIST_ERROR = 1012;
    const ERR_TEL_NOTEXIST_ERROR = 1013;
    const ERR_PARAMETERS_ERROR = 1014;
    const ERR_NO_SYSTEM_UPDATE = 1015;
    const ERR_NO_FIND_USER_BY_AUDIENCE = 1016;
    const ERR_INFO_MISMATCH_ERROR = 1017;

    private static $MESSAGE
        = array(
            '-1' => '非法请求',
            '200' => '请求成功',
            '1001' => '未知错误，请检查服务器日志',
            '1002' => '一般性错误',
            '1000' => '暂未实现',
            '1003' => '密钥错误',
            '1004' => 'TOKEN验证错误',
            '1005' => '缺少参数',
            '1006' => '用户名或密码错误',
            '1007' => '记录不存在',
            '1008' => '注册失败',
            '1009' => '数据更新失败',
            '1010' => '登录密码错误',
            '1011'=>'验证码输入不正确',
            '1012'=>'手机号码已存在',
           '1013'=>'手机号码不存在',
            '1014'=>'参数不正确',
            '1015'=>'已是最新',
            '1016'=>'cannot find user by this audience',
            '1017'=>'信息不匹配,请检查学生信息'
        );

    public static function getMessage($code, $args = array())
    {
        $msg = 'Message is undefined : ' . $code;
        if (!is_integer($code)) return 'Illegal Code : ' . print_r($code, true);
        if (isset(self::$MESSAGE[$code])) {
            $msg = self::$MESSAGE[$code];
        }
        return $msg;
    }
}