<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Db;

class Database extends Controller
{
    /*    protected $beforeActionList = [
        'dandian'=>['only'=>'qqlogin']
    ];

    function dandian(){
        Session::has('user_name','think');
        $session = session_id();
        dump($session);
        $info = Db::name('session')->where(['session_id'=>$session])->find();
        if(!$info){
            $this->redirect('Login/out');
        }

    }*/
    function hasLogin(){
        return Session::has('user_name','think');
    }
    function database(){
        if(!$this->hasLogin()){
            $this->redirect('Login/index');
        }
    }
    protected $beforeActionList = [
        'database',
    ];
}
