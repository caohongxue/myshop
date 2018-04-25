<?php

namespace app\admin\controller;


use app\admin\model\AuthGroupRule;
use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthGroupRule as AuthGroupRuleModel;
use think\Session;

use think\Controller;
use think\Request;
use app\admin\model\AuthGroup as AuthGroupModel;


class AuthGroup extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $model=new AuthGroupModel();
        $list=$model->order('sort','asc')->paginate(10);
        foreach ($list as $value){
            if($value['is_super']==0){
                $value['is_super_man']='普通管理员';
            }elseif ($value['is_super']==1){
                $value['is_super_man']='super-man';
            }
        }
        return $this->fetch('index',['list'=>$list]);
    }
    /**
     * 按排序显示资源列表
     *
     * @return \think\Response
     */
    public function desc(){
        $model=new AuthGroupModel();
        $list=$model->order('sort','desc')->paginate('10');
        foreach ($list as $value){
            if($value['is_super']==0){

                $value['is_super_man']='普通管理员';
            }elseif ($value['is_super']==1){
                $value['is_super_man']='super-man';
            }elseif ($value['is_super']==2){
                $value['is_super_man']='禁权';
            }
        }
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
            $model=new AuthGroupModel();//实例化-添加数据
        }else{
            $model=AuthGroupModel::get($id);//实例化-修改数据
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
    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return mixed
     */
    public function multidel()
    {
        AuthGroupModel::destroy(input('id/a',[]));//删除多条数据
        $this->redirect('index');
    }
    /*
    /**
     * 查看权限
     *
     * @param  int  $id
     * @return mixed
     */
    public function manage($id){
        $group = AuthGroupModel::get($id);//获取当前组
        $auth_group = Db::table('auth_group_rule')->where(['group_id' => $id])->column('rule_id');
//        dump($auth_group);exit;
        if (request()->isGet()) {
            $rules = Db::table('auth_rule')->select();//获取所有权限
            return $this->fetch('manage', [
                'group' => $group->getData(),
                'rules' => $rules,
                'auth_group' => $auth_group
            ]);
        } elseif (request()->isPost()) {
            $rules = input('rules/a', []);//从复选框中获取权限
            $deletes=array_diff($auth_group,$rules);//获取删除权限rule_id
            $inserts=array_diff($rules,$auth_group);//获取添加rule_id
            Db::table('auth_group_rule')->where(['group_id' => $id,'rule_id'=>['in',$deletes]])->delete();
            $authGroupRule = new AuthGroupRuleModel();//实例化权限用户关联表
            $row = [];
            foreach ($inserts as $rule_id) {
                $row[] = [
                    'group_id' => $id,//添加组id
                    'rule_id' => $rule_id//添加权限id
                ];
            }
            $authGroupRule->saveAll($row);
            $this->redirect('index');
        }
    }

}
