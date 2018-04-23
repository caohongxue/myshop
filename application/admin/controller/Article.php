<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Article as ArticleModel;
class Article extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $model=new ArticleModel();
        $list=$model->paginate('10');
        foreach ($list as $value){
            if($value['is_show']==1){
                $value['is_show_text']='展示';
            }else{
                $value['is_show_text']='不展示';
            }
        }
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function desc()
    {
        $model=new ArticleModel();
        $list=$model->order('name')->paginate('10');
        foreach ($list as $value){
            if($value['is_show']==1){
                $value['is_show_text']='展示';
            }else{
                $value['is_show_text']='不展示';
            }
        }
        return $this->fetch('index',['list'=>$list,'desc'=>1]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function table($id){
        $table=ArticleModel::get($id)->value('table_name');
        $c=ucfirst($table);
        $this->redirect($c.'/index');

    }


}