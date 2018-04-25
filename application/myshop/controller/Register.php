<?php
/**
 * Created by PhpStorm.
 * user: 47096
 * Date: 2018/4/17
 * Time: 10:09
 */
namespace app\myshop\controller;
use app\admin\model\Content;
use app\myshop\model\RegisterModel;
use think\Db;
use think\Controller;
use think\Request;

class Register extends Controller{
    function _initialize(){
        $this->model = new RegisterModel();
    }
    public function index(){
        return $this->fetch();
    }
    public function Register()
    {
        if (Request::instance()->isGet()) {
            print(Request::instance()->isGet());
            return $this->fetch('index');
        } else {
            $data = Request::instance()->param();
            if ($data['email']) {
                $data['password'] = md5(md5(Request::instance()->param('password')));
                if (Db::name('user')->insert($data)) {
                    echo 'ok';
                } else {
                    echo 'error';
                }
            }
        }
    }
    public function Registers()
    {

        $data = Request::instance()->param();
        $data['password'] = md5(md5(Request::instance()->param('password')));
        if ($this->model->save($data)) {
            echo 'ok';
        } else {
            echo 'error';
        }


    }

}
