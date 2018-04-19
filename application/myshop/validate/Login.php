<?php

namespace app\myshop\validate;
use think\Validate;

class Login extends Validate{
    protected $rule = [
        'user_name'  => 'require|max:25 | unique:user_name',
        'password'=>'require',
    ];
    protected $field = [
        'user_name'=>'用户名',
        'password'=>'密码',
    ];
}