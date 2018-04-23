<?php

namespace app\myshop\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\myshop\model\User as UserModel;

class User extends Controller
{


    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch('Person/information');
    }

    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
       if (request()->isPost()){
           $model = new UserModel();
           $data = input();
           $data['password']=md5(md5($data['password']));
           $re = $model->save($data);
           if($re){
               $this->success('修改成功','Person/index');
           }else{
               $this->error('修改失败');
           }
//           $this->redirect('index');
       }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
