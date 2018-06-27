<?php
namespace Common\Service;

use Think\Model;

class MembersService extends BaseService
{
    public static function checkUserTelUnique($tel, $flag = false, $userId = 0)
    {
        $where = "is_deleted=0 and tel='" . $tel . "'";
        if ($flag) {
            $where .= ' and member_id <> ' . $userId;
        }
        $userInfo = M("Members")->where($where)->find();
        if ($userInfo) {
            return true;
        } else {
            return false;
        } 
    }
}