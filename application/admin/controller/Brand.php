<?php
/**
 * Created by PhpStorm.
 * User: MACHENIKE
 * Date: 2018/4/19
 * Time: 13:34
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Image;
use think\Request;
use app\admin\model\Brand as BrandModel;
use think\Session;

class Brand extends Base{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(){
        $model=new BrandModel();
        $list=$model->paginate('10');
        foreach($list as $value){
            $value['category']=Db::table('category')->where('id',$value['b_id'])->value('cat_name');
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
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('brand_logo');
        if($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['ext'=>'jpg,gif','size'=>1000000])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $img=$info->getSaveName();
                $image = Image::open(ROOT_PATH . 'public' . DS .'uploads'.DS.$img);

                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                $path=ROOT_PATH . 'public' . DS .'thumb'.DS.$img;
                $directory=substr($img,0,8);
                if(!file_exists(ROOT_PATH . 'public' . DS .'thumb'.DS.$directory)){
                    mkdir(ROOT_PATH .'public'.DS.'thumb'.DS.$directory);
                }
                $image->thumb(50, 50)->save($path);
                return $img;
            }else{
                $this->redirect('save',[],302,[
                    'message'=>$info->getError(),//得到报错信息
                ]);
            }
        }else{
            $this->error('头像未上传');
        }
    }

    /**
     * 显示资源列表
     *$id:修改条件
     * @return mixed
     */
    public function save($id=null){//$id : 修改的数据
//        dump($id);exit;
        $request=request();
        if(is_null($id)){
            $model=new BrandModel();//实例化-添加数据
        }else{
            $model=BrandModel::get($id);//实例化-修改数据
        }
        $cate=Db::table('category')->select();
        if($request->isGet()){
            $data=Session::has('data')?Session::get('data'):$model->getData();
            //获取修改数据

            return $this->fetch('save',[
                'message'=>Session::get('message'),
                'data'=>$data ,//表单中读取要修改的数据
                'category'=>$cate
            ]);//得到报错信息的值到模板中
        }elseif ($request->isPost()){
            $data=$request->post();//收集表单数据
            if($_FILES['brand_logo']['tmp_name']!=''){
                $data['brand_logo']=$this->upload();
            }
//            dump($data);exit;
            $validate=validate('Brand');
            $ch=$validate->batch()->check($data);
            if(!$ch){
                $this->redirect('save',[],302,[
                    'message'=>$validate->getError(),//得到报错信息
                    'data'=>$data ,
                    'category'=>$cate
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
    public function mutildel()
    {
        BrandModel::destroy(input('selected/a',[]));//删除多条数据
        $this->redirect('index');
    }

}