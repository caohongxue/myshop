<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/3/16
 * Time: 19:26
 */
namespace app\admin\validate;
use think\Validate;

class Category extends Validate{
    //验证规则
    protected $rule= [
        'cat_name'=>'require'
    ];
    //验证字段中文名
    protected $field=[
        'cat_name'=>'分类名称'
    ];
}