<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\AdminUser as AdminUserModel;
use think\Session;

class AdminUser extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $model=new AdminUserModel();
        $list=$model->paginate(10);
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 显示资源列表
     *$id:修改条件
     * @return mixed
     */
    public function save($id=null){//$id : 修改的数据
        $request=request();
        if(is_null($id)){
            $model=new AdminUserModel();//实例化-添加数据
        }else{
            $model=AdminUserModel::get($id);//实例化-修改数据
        }
        $group=Db::table('auth_group')->select();
        if($request->isGet()){
            $data=Session::has('data')?Session::get('data'):$model->getData();
            //获取修改数据
            return $this->fetch('save',[
                'message'=>Session::get('message'),
                'data'=>$data ,//表单中读取要修改的数据
                'group'=>$group
            ]);//得到报错信息的值到模板中
        }elseif ($request->isPost()){
            $data=$request->post();//收集表单数据
            $data['add_time']=time();
            $data['salt']=mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
            $data['password']=md5(md5(input('password')).$data['salt']);
            if(! is_null($id)){
                if($data['password']!=$model['password']){
                    $data['password']=md5(md5(input('password')).$data['salt']);
                }
            }
            $validate=validate('AdminUser');
            $ch=$validate->batch()->check($data);
            if(!$ch){
                $this->redirect('save',[],302,[
                    'message'=>$validate->getError(),//得到报错信息
                    'data'=>$data,
                    'group'=>$group
                ]);
            }
            $model->data($data);//收集表单数据
            $model->save();//保存数据
            $this->redirect('index');//跳转页面
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return mixed
     */
    public function multidel()
    {
        AdminUserModel::destroy(input('id/a',[]));//删除多条数据
        $this->redirect('index');
    }
    /**
     * 查看权限
     *
     * @param  int  $id
     * @return mixed
     */
    public function manage(){
        echo '等我一会';
    }
}
