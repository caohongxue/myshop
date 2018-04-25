<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\AuthRule as AuthRuleModel;
use think\Session;

    class AuthRule extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $model=new AuthRuleModel();
        $list=$model->order('sort','asc')->paginate(10);
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 按排序显示资源列表
     *
     * @return \think\Response
     */
    public function desc(){
        $model=new AuthRuleModel();
        $list=$model->order('sort','desc')->paginate('10');
        return $this->fetch('index',['list'=>$list,'desc'=>'1']);
    }

    /**
     * 修改保存
     *$id:修改条件
     * @return mixed
     */
    public function save($id=null){//$id : 修改的数据
        $request=request();
        if(is_null($id)){
            $model=new AuthRuleModel();//实例化-添加数据
        }else{
            $model=AuthRuleModel::get($id);//实例化-修改数据
        }

        if($request->isGet()){
            $data=Session::has('data')?Session::get('data'):$model->getData();
            //获取修改数据
            return $this->fetch('save',[
                'message'=>Session::get('message'),
                'data'=>$data //表单中读取要修改的数据
            ]);//得到报错信息的值到模板中
        }elseif ($request->isPost()){
            $data=$request->post();//收集表单数据
            $validate=validate('AuthGroup');
            $ch=$validate->batch()->check($data);
            if(!$ch){
                $this->redirect('save',[],302,[
                    'message'=>$validate->getError(),//得到报错信息
                    'data'=>$data
                ]);
            }
            $model->data($data);//收集表单数据
            $model->save();//保存数据
            $this->redirect('index');//跳转页面
        }
    }
}
