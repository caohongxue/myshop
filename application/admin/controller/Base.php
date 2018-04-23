<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/4/3
 * Time: 18:53
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Session;

class Base extends Controller{
    protected $beforeActionList = [
        'first'
   ];
    public function first(){
        $userInfo=Session::get('userInfo');
//        dump(session_id());
//        dump($userInfo);exit;
        if(!$userInfo){
            $this->redirect('Login/login');
        }
//        echo 'pathinfo: ' . $this->request->path() . '<br/>';
//        if('pathinfo: ' . $this->request->path()!='admin/home/add'){
//            $this->error('me');
//        }
        $user=Db::table('admin_user')->find($userInfo['user_id']);
        Session::set('user',$user);
    }

}