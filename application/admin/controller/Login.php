<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;
use app\admin\model\Login as LoginModel;
class Login extends Controller
{
    /**
     * 登录及验证资源列表
     *
     * @return \think\Response
     */
    public function login(){
        if(request()->isGet()){
            return $this->fetch('login',[
                'message'=>Session::get('message')
            ]);
        }
        elseif(request()->isPost()){
            $username=input('username');
            $admin=LoginModel::get(['user_name'=>$username]);
            if($admin){
                if($admin->password == md5(md5(input('password')).$admin->salt)){
                    $admin->save(['last_login'=>time()]);
                    Session::set('userInfo',$admin);
                    $this->success('登录成功','Home/index');
                }
                $this->redirect('login',[],302,[
                    'message'=>'密码错误'
                ]);
            }
            $this->redirect('login',[],302,[
                'message'=>'用户不存在'
            ]);
        }
    }


}
