<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\%model% as %model%Model;
use think\Session;

/**
 *class %controller%
 *%title%管理控制器
 * @package app\admin\controller
 */
class %controller% extends Controller
{
    /**
     * 品牌添加,修改数据
     * $id：修改的条件
     * @return mixed
     */
    public function save($id=null)//$id：修改的条件
    {
        $request = request();

        if(is_null($id)){
            $model = new %model%Model();//实例化模型-添加数据
        }
        else{
            $model = %model%Model::get($id);//修改数据-实例化模型
        }
        
        if($request->isGet()){
            // Session::set('data',$data);设置session的值
            $data = Session::has('data')?Session::get('data'):$model->getData();//获取修改的数据

            return $this->fetch('save',[
                'message'=>Session::get('message'),
                'data'=>$data,//表单中读取要修改的数据
                ]);//得到报错信息的值在模板中
        }
          
        elseif ($request->isPost()) {

            $data = $request->post();//input('post.')收集表单的数据

            $validate = validate('%model%');

            $ch = $validate->batch()->check($data);

            if(!$ch){
                $this->redirect('save',[],302,[
                    'message'=>$validate->getError(),//验证报错信息
                    'data'=>$data,
                    ]);
            }

            $model->data($data);//收集表单的数据

            $model->save();//保存数据

            $this->redirect('index');//跳转到查看页面

        }
    }

    /**
     * 查看品牌的数据
     *
     * @return mix
     */
    public function index()
    {
        $limit = 3;
        $model = new %model%Model();
        $result = $model->paginate($limit);//分页
        return $this->fetch('index',['result'=>$result]);

    }


    /**
     * 批量删除数据
     *
     */
    public function mutildel()
    {   #/a:返回的是数组
        %model%Model::destroy(input('selected/a',[]));
        $this->redirect('index');//跳转到查看页面
    }

}
