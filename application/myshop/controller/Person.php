<?php

namespace app\myshop\controller;

use think\Controller;
use think\Request;
use app\myshop\model\Person as PersonModel;
use think\Session;
use think\Db;

class Person extends Controller
{


    /**
     * 显示个人信息页面
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 显示优惠券页面
     *
     * @return \think\Response
     */
    public function coupon()
    {
        return $this->fetch();
    }

    /**
     * 显示钱包页面
     *
     * @return \think\Response
     */
    public function bill()
    {
        return $this->fetch();
    }

    /**
     * 显示账单明细页面
     *
     * @return \think\Response
     */
    public function billlist()
    {
        return $this->fetch();
    }


    /**
     * 显示个人信息页面
     *
     * @return \think\Response
     */
    public function information()
    {
        $list = Db::name('user')->select();
        $name = Session::get('user_name','think');
        return $this->fetch('Person/information',['list'=>$list,'name'=>$name]);
    }

    /**
     * 显示安全设置页面
     *
     * @return \think\Response
     */
    public function safety()
    {
        return $this->fetch();
    }

    /**
     * 显示收货地址页面
     *
     * @return \think\Response
     */
    public function address()
    {
        $id = Session::get('user_id','think');
        $list = Db::name('user_address')->where(['user_id'=>$id])->select();
        return $this->fetch('Person/address',['list'=>$list]);
    }

    /**
     * 显示订单管理页面
     *
     * @return \think\Response
     */
    public function order()
    {
        return $this->fetch();
    }

    /**
     * 显示退款售后页面
     *
     * @return \think\Response
     */
    public function change()
    {
        return $this->fetch();
    }

    /**
     * 显示收藏页面
     *
     * @return \think\Response
     */
    public function collection()
    {
        return $this->fetch();
    }

    /**
     * 显示足迹页面
     *
     * @return \think\Response
     */
    public function foot()
    {
        return $this->fetch();
    }


    /**
     * 显示评价页面
     *
     * @return \think\Response
     */
    public function comment()
    {
        $list = Db::name('comment')->select();
        return $this->fetch('Person/comment',['list'=>$list]);
    }

    /**
     * 显示消息页面
     *
     * @return \think\Response
     */
    public function news()
    {
        return $this->fetch();
    }


    /**
     * 显示阅读全文页面
     *
     * @return \think\Response
     */
    public function blog()
    {
        return $this->fetch();
    }

    /**
     * 显示钱款去向页面
     *
     * @return \think\Response
     */
    public function record()
    {
        return $this->fetch();
    }

    /**
     * 显示修改密码页面
     *
     * @return \think\Response
     */
    public function password()
    {
        return $this->fetch();
    }

    /**
     * 显示启用支付密码功能页面
     *
     * @return \think\Response
     */
    public function setpay()
    {
        return $this->fetch();
    }

    /**
     * 显示手机验证换绑页面
     *
     * @return \think\Response
     */
    public function bindphone()
    {
        return $this->fetch();
    }

    /**
     * 显示邮箱验证换绑页面
     *
     * @return \think\Response
     */
    public function email()
    {
        return $this->fetch();
    }

    /**
     * 显示实名认证页面
     *
     * @return \think\Response
     */
    public function idcard()
    {
        return $this->fetch();
    }

    /**
     * 显示安全问题页面
     *
     * @return \think\Response
     */
    public function question()
    {
        return $this->fetch();
    }
}

