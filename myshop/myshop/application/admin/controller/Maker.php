<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Maker extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function table()
    {
        return $this->fetch();
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function infor()
    {
        $table = input('table');
        $table_schema = config('database.database');
        $table_name = config('database.prefix').$table;
        $sql = "select table_comment from information_schema.tables where table_schema=? and table_name=?";
        $row = Db::query($sql,[$table_schema,$table_name]);
        $table_comment = $row[0]['table_comment'];
        $sql = "select column_name,column_comment from information_schema.columns where table_schema=? and table_name=?";
        $fields =  Db::query($sql,[$table_schema,$table_name]);
        return [
            'comment'=>$table_comment,
            'fields'=>$fields,
        ];
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    //代码生成
    public function generate()
    {
       $table = input('table');
       $comment = input('comment');
       $fields = input('fields/a');
       $this->makeController($table,$comment);
       $this->makeModel($table);
       $this->makeValidate($table,$comment);
       $this->makeIndexView($table,$comment,$fields);
       $this->makeSaveView($table,$comment,$fields);;
    }

    /**
     * 控制器生成
     *
     * @param  int  $id
     * @return \think\Response
     */
   private function makeController($table,$comment){
       $templage = file_get_contents(APP_PATH.'admin/view/codeTemplate/controller.tpl');
       //读取模板内容
       $controller = $model = implode(array_map('ucfirst',explode('_',$table)));
       $title = $comment;
       $search = ['%controller%','%title%','%model%'];
       $replace = [$controller,$title,$model];
       $content = str_replace($search,$replace,$templage);
       $file = APP_PATH."admin/controller/".$controller.".php";
       file_put_contents($file,$content);
       echo '控制器生成成功:'.$file.'<br>';
   }



    private function makeModel($table){
        $templage = file_get_contents(APP_PATH.'admin/view/codeTemplate/model.tpl');
        //读取模板内容
        $model = implode(array_map('ucfirst',explode('_',$table)));
        $search = ['%model%'];
        $replace = [$model];
        $content = str_replace($search,$replace,$templage);
        $file = APP_PATH."admin/model/".$model.".php";
        file_put_contents($file,$content);
        echo '模型生成成功:'.$file.'<br>';
    }

    private function makeValidate($table,$comment){
        $templage = file_get_contents(APP_PATH.'admin/view/codeTemplate/validate.tpl');
        //读取模板内容
        $validate = implode(array_map('ucfirst',explode('_',$table)));
        $title = $comment;
        $search = ['%model%','%title%'];
        $replace = [$validate,$title,];
        $content = str_replace($search,$replace,$templage);
        $file = APP_PATH."admin/validate/".$validate.".php";
        file_put_contents($file,$content);
        echo '验证器生成成功:'.$file.'<br>';
    }

    private function makeIndexView($table,$comment,$fields){
//        dump($fields);exit;
        $list_head_template = file_get_contents(APP_PATH.'admin/view/codeTemplate/list_head.tpl');
        $list_body_template = file_get_contents(APP_PATH.'admin/view/codeTemplate/list_body.tpl');
        //读取模板内容
        $list_head = $list_body = '';
        foreach ($fields as $field){
            $search = ['%field_comment%','%field_name%'];
            $replace = [$field['comment'],$field['name']];
            $list_head .= str_replace($search,$replace,$list_head_template);
            $list_body .= str_replace($search,$replace,$list_body_template);
        }

        $template = file_get_contents(APP_PATH.'admin/view/codeTemplate/list.tpl');
        $search = ['%title%','%list_head%','%list_body%'];
        $replace = [$comment,$list_head,$list_body];
        $content = str_replace($search,$replace,$template);
        if(!is_dir(APP_PATH."admin/view/".$table)){
            mkdir(APP_PATH."admin/view/".$table);
        }
        $file = APP_PATH."admin/view/".$table."/index.html";
        file_put_contents($file,$content);
        echo '视图生成成功:'.$file.'<br>';
    }


    private function makeSaveView($table,$comment,$fields){
        $template = file_get_contents(APP_PATH.'admin/view/codeTemplate/set_list.tpl');
        //读取模板内容
        $field_list = '';
        foreach ($fields as $field){
            $search = ['%field_comment%','%field_name%'];
            $replace = [$field['comment'],$field['name']];
            $field_list .= str_replace($search,$replace,$template);
        }

        $template = file_get_contents(APP_PATH.'admin/view/codeTemplate/set.tpl');
        $search = ['%title%','%field_list%'];
        $replace = [$comment,$field_list];
        $content = str_replace($search,$replace,$template);
        if(!is_dir(APP_PATH."admin/view/".$table)){
            mkdir(APP_PATH."admin/view/".$table);
        }
        $file = APP_PATH."admin/view/".$table."/save.html";
        file_put_contents($file,$content);
        echo '视图编辑器生成成功:'.$file.'<br>';
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
