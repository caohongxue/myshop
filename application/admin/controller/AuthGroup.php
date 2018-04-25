<?php

namespace app\admin\controller;

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
                $value['is_super']='普通管理员';
            }elseif ($value['is_super']==1){
                $value['is_super']='super-man';
            }
        }
        return $this->fetch('index',['list'=>$list]);
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function desc(){
        $model=new AuthGroupModel();
        $list=$model->order('sort','desc')->paginate('10');
        foreach ($list as $value){
            if($value['is_super']==0){
                $value['is_super']='普通管理员';
            }elseif ($value['is_super']==1){
                $value['is_super']='super-man';
            }
        }
        return $this->fetch('index',['list'=>$list,'desc'=>'1']);
    }
}
