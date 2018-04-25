<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/24
 * Time: 15:10
 */
namespace app\myshop\controller;


use think\Controller;
use think\Db;
use think\Session;

class Order extends Controller{

    public function index(){
        $id = Session::get('user_id','think');
        $add=Db::table('user_address')->where('user_id',$id)->select();

        return $this->fetch('pay',['add'=>$add]);

    }
    function editadd(){
        return $this->fetch('address');
    }




}