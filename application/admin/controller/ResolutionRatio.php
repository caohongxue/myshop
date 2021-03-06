<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\ResolutionRatio as ResolutionRatioModel;
use think\Session;

/**
 *class ResolutionRatio
 *分辨率管理控制器
 * @package app\admin\controller
 */
class ResolutionRatio extends Base
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
            $model = new ResolutionRatioModel();//实例化模型-添加数据
        }
        else{
            $model = ResolutionRatioModel::get($id);//修改数据-实例化模型
        }
        $cat=Db::table('category')->select();
        if($request->isGet()){
            // Session::set('data',$data);设置session的值
            $data = Session::has('data')?Session::get('data'):$model->getData();//获取修改的数据

            return $this->fetch('save',[
                'message'=>Session::get('message'),
                'data'=>$data,//表单中读取要修改的数据
                'tab'=>$cat
                ]);//得到报错信息的值在模板中
        }
          
        elseif ($request->isPost()) {

            $data = $request->post();//input('post.')收集表单的数据

            $validate = validate('ResolutionRatio');

            $ch = $validate->batch()->check($data);

            if(!$ch){
                $this->redirect('save',[],302,[
                    'message'=>$validate->getError(),//验证报错信息
                    'data'=>$data,
                    'tab'=>$cat
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
        $limit = 8;
        $model = new ResolutionRatioModel();
        $result = $model->paginate($limit);//分页
        foreach ($result as $value){
            $value['tab']=Db::table('category')->where('id',$value['tab_id'])->value('cat_name');
            $value['is_show']=$value['is_show']==1?'展示':'不展示';
        }
        return $this->fetch('index',['result'=>$result]);

    }


    /**
     * 批量删除数据
     *
     */
    public function mutildel()
    {   #/a:返回的是数组
        ResolutionRatioModel::destroy(input('selected/a',[]));
        $this->redirect('index');//跳转到查看页面
    }

}
