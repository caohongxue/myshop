<?php

namespace app\myshop\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use app\myshop\model\Address as AddressModel;

class Address extends Controller
{

    public function create()
    {
        //
    }

    /**
     * 新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add()
    {
        $id = Session::get('user_id','think');
       if (request()->isPost()){
           $model = new AddressModel();
           $data = input();
           $data['user_id']=$id;
           $re = $model->save($data);
           if($re){
               $this->success('添加成功','Person/address');
           }else{
               $this->error('添加失败');
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
    public function delete($name)
    {
        $model = new AddressModel();
        $model->where(['consignee'=>$name])->delete();
        $this->success('删除成功','Person/address');
    }
}
