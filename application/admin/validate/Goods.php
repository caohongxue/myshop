<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/3/16
 * Time: 19:26
 */
namespace app\admin\validate;
use think\Validate;

class Goods extends Validate{
    //验证规则
    protected $rule= [
        'goods_name' => 'require',
        'brand_id' =>'require',
        'cat_id' =>'require',
        'goods_model' =>'require',
        'shop_price' =>'require',
        'stock' =>'require',
        'goods_color' =>'require',
        'shipping' =>'require',
        'runme_id' =>'require',
        'pro_id' =>'require',
        'memory_id' =>'require',
        'title_des' =>'require',
        'is_show' =>'require',
        'sort_order' =>'require',
        'goods_img'=>'require'
    ];
    //验证字段中文名
}