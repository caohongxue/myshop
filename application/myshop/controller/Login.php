<?php

namespace app\myshop\controller;

use think\Controller;
use think\Request;
use app\myshop\model\User as UserModel;
use app\myshop\model\Session as SessionModel;
use think\Session;
use think\Db;

class Login extends Controller
{


    /**
     * 显示登录页面
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch('login/login');
    }

    /**
     * 登录
     *m ..kk
     * @return \think\Response
     */
    public function login(){
        if(request()->isGet()){
            return $this->fetch('login',[
                'message1'=>Session::get('message1'),
                'message2'=>Session::get('message2'),
            ]);
        }
        elseif (request()->isPost()){
            $username = input('user_name');
            $user = UserModel::get(['user_name'=>$username] || ['email'=>$username] || ['mobile_phone'=>$username]);
            if($user){
                if($user->password == md5(md5(input('password')))){
                    $data = $user->getData();
//                    dump($data);die;
                    Session::set('user_name,user_id',$data,'think');
//                    dump(session_id());die;
                    $info = [
                        'session_id'=>session_id(),
                        'user_id'=>$data['user_id'],
                        'last_time'=>time(),
                        'status'=>1,
                    ];
                    $model = new SessionModel();
                    $model->save($info);
                    return '<script>window.history.go(-2)</script>';
                }else{
                    $this->redirect('login',[],302,[
                        'message2'=>'密码错误,请重新输入!',
                    ]);
                }

            }
            $this->redirect('login',[],302,[
                'message1'=>'邮箱/手机/用户名错误,请重新输入!',
            ]);
        }
    }


    /**
     * qq登录
     *m ..kk
     * @return \think\Response
     */
    public function qqlogin(){
        if(request()->isGet()){
            return $this->fetch('qqlogin',[
                'message1'=>Session::get('message1'),
                'message2'=>Session::get('message2'),
            ]);
        }
        elseif (request()->isPost()){
            $qq = input('qq');
            $user = UserModel::get(['qq'=>$qq]);
            if($user){
                if($user->password == md5(md5(input('password')))){
                    $data = $user->getData();
                    Session::set('user_name',$data,'think');
                    $info = [
                        'session_id'=>session_id(),
                        'user_id'=>$data['user_id'],
                        'last_time'=>time(),
                        'status'=>1,
                    ];
                    $model = new SessionModel();
                    $model->save($info);
                    echo '登录成功';die;
                    return '<script>window.history.go(-3)</script>';
                }else{
                    $this->redirect('qqlogin',[],302,[
                        'message2'=>'密码错误,请重新输入!',
                    ]);
                }

            }
            $this->redirect('qqlogin',[],302,[
                'message1'=>'QQ号输入有误,请重新输入!',
            ]);
        }
    }


    /**
     * 注销用户
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function out()
    {
        $id = Session::get('user_id','think');
        $session = Db::name('Session')->where(['user_id'=>$id])->find();
        $model = new SessionModel();
        $model->where(['id'=>$session['id']])->delete();
        Session::delete('user_name','think');
        $this->success('注销成功','index');
    }

}

