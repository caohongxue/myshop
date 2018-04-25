<?php

namespace app\admin\validate;
use think\Validate;

class AuthGroup extends Validate{
    protected $rule = [
        'title' => 'require|max:29',
        'sort' => 'require|between:0,99',
    ];
    protected $field = [
        'title' => '用户角色组',
        'sort' => '排序',
    ];
}