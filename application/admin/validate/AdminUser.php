<?php

namespace app\admin\validate;
use think\Validate;

class AdminUser extends Validate{
    protected $rule = [
         'user_name' => 'require|max:29',
         'email' => 'require|email|max:45',
         'password' => 'require'
    ];
    protected $field = [
        'user_name' => '用户名',
        'email' => '邮箱地址',
        'password' => '密码'
    ];
}