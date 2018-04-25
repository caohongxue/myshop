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
        'shop_price' =>'require|number',
        'stock' =>'require',
        'goods_color' =>'require',
        'shipping' =>'require',
        'runme_id' =>'require',
        'pro_id' =>'require',
        'memory_id' =>'require',
        'title_des' =>'require',
        'is_show' =>'require',
        'sort_order' =>'require|number|between:1,120',
        'goods_img'=>'require'
    ];
    //验证字段中文名
    protected $field = [
        'goods_name' => '商品名称',
        'goods_model' =>'require',
        'shop_price' =>'商品价格',
        'stock' =>'库存',
        'goods_color' =>'商品颜色',
        'title_des' =>'商品描述',
        'sort_order' =>'商品排序',
    ];
}