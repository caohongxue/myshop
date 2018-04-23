<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/3/16
 * Time: 19:26
 */
namespace app\admin\validate;
use think\Validate;

class Brand extends Validate{
    //验证规则
    protected $rule= [
        'brand_name'=>'require|max:25',
        'brand_des'=>'require|max:95',
        'sort_order'=>'require|number|between:1,120'
    ];
    //验证字段中文名
    protected $field=[
        'brand_name'=>'品牌名称',
        'brand_des'=>'品牌描述',
        'sort_order'=>'排序'
    ];
}