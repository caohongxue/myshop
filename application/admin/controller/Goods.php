<?php

namespace app\admin\controller;

use app\admin\model\Correlation;
use think\Controller;
use think\Db;
use think\Image;
use think\Request;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Correlation as CorrelationModel;
use think\Session;

class Goods extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $model=new GoodsModel();
        $list=$model->where('is_delete',0)->select();
        foreach ($list as $value){
            if($value['is_show']==1){
                $value['is_show']='上架';
            }else{
                $value['is_show']='下架';
            }
        }
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 图像上传
     *
     * @return \think\Response
     */
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        if($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['ext'=>'jpg,gif','size'=>1000000])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $img=$info->getSaveName();
                $image = Image::open(ROOT_PATH . 'public' . DS .'uploads'.DS.$img);

                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                $path=ROOT_PATH . 'public' . DS .'thumb'.DS.'small'.DS.$img;
                $path2=ROOT_PATH . 'public' . DS .'thumb'.DS.'big'.DS.$img;
                $directory=substr($img,0,8);
                if(!file_exists(ROOT_PATH . 'public' . DS .'thumb'.DS.'small'.DS.$directory)){
                    mkdir(ROOT_PATH .'public'.DS.'thumb'.DS.'small'.DS.$directory);
                    mkdir(ROOT_PATH .'public'.DS.'thumb'.DS.'big'.DS.$directory);
                }
                $image->thumb(400, 400)->save($path);
                $image->thumb(450, 450)->save($path2);
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
        $request=request();
        if(is_null($id)){
            $model=new GoodsModel();//实例化-添加数据
            $cmodel=new CorrelationModel();
        }else{
            $model=GoodsModel::get($id);//实例化-修改数据
            $cmodel=Db::table('correlation')->where('goods_id',$id);
        }

        if($request->isGet()){
            $data=Session::has('data')?Session::get('data'):$model->getData();
            $brand=Db::table('brand')->select();
            $category=Db::table('category')->select();
            $processor=Db::table('processor')->select();
            $running=Db::table('running_memory')->select();
            $memory=Db::table('memory')->select();
            $host=Db::table('host')->select();
            $battery=Db::table('battery')->select();
            $system=Db::table('system')->select();
            $size=Db::table('size')->select();
            $bare_weight=Db::table('bare_weight')->select();
            $video_card=Db::table('video_card')->select();
            $resolution_ratio=Db::table('resolution_ratio')->select();
            //获取修改数据
            return $this->fetch('save',[
                'message'=>Session::get('message'),
                'data'=>$data,
                'brand'=>$brand,
                'category'=>$category,
                'processor'=>$processor,
                'running'=>$running,
                'memory'=>$memory,
                'host'=>$host,
                'battery'=>$battery,
                'system'=>$system,
                'size'=>$size,
                'bare_weight'=>$bare_weight,
                'video_card'=>$video_card,
                'resolution_ratio'=>$resolution_ratio
            ]);//得到报错信息的值到模板中
        }elseif ($request->isPost()){
            $data=[
                      'goods_name' => input('goods_name'),
                      'brand_id' =>input('brand_id'),
                      'cat_id' =>input('cat_id'),
                      'goods_model' =>input('goods_model'),
                      'shop_price' =>input('shop_price'),
                      'stock' =>input('stock'),
                      'goods_color' =>input('goods_color'),
                      'shipping' =>input('shipping'),
                      'runme_id' =>input('runme_id'),
                      'pro_id' =>input('pro_id'),
                      'memory_id' =>input('memory_id'),
                      'title_des' =>input('title_des'),
                      'is_show' =>input('is_show'),
                      'sort_order' =>input('sort_order'),
                      'goods_img'=>$this->upload()
            ];//收集表单数据
            $data2=[
                'host_id'=>input('host_id'),
                'battery_id'=>input('battery_id'),
                'system_id'=>input('system_id'),
                'size_id'=>input('size_id'),
                'bareweight'=>input('bareweight'),
                'videocard_id'=>input('videocard_id'),
                'resotio_id'=>input('resotio_id')
            ];
            $validate=validate('Goods');
            $ch=$validate->batch()->check($data);
            if(!$ch){
//                dump($validate->getError());exit;
                $this->redirect('save',[],302,[
                    'message'=>$validate->getError(),//得到报错信息
                    'data'=>$data
                ]);
            }
            $model->data($data);//收集表单数据
            $model->save();//保存数据
            if(is_null($id)){
                $goods_id=$model->where($data)->value('goods_id');
                $data2['goods_id']=$goods_id;
            }
            $cmodel->save($data2);
            $this->redirect('index');//跳转页面
        }
    }

    /**
     * 商品加入回收站
     *
     * @param  int  $id
     * @return mixed
     */
    public function multidel()
    {
        $goods_id=input('selected/a',[]);
        $model=new GoodsModel();
        foreach ($goods_id as $value){
            $model->where('goods_id',$value)->update(['is_delete'=>1]);
        }
        $this->redirect('index');
    }
    /**
     * goods回收站资源
     *
     * @param  int  $id
     * @return mixed
     */
    public function recycle(){
        $model=new GoodsModel();
        $list=$model->where('is_delete',1)->select();
        foreach ($list as $value){
            if($value['is_show']==1){
                $value['is_show']='上架';
            }else{
                $value['is_show']='下架';
            }
        }
        return $this->fetch('recycle',['list'=>$list]);
    }
    /**
     * 回收站删除指定资源
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete(){
        GoodsModel::destroy(input('selected/a',[]));//删除多条数据
        $goods_id=input('selected/a',[]);
        foreach ($goods_id as $value){
//            $img=Db::table('goods')->where('goods_id',$value)->value('goods_img');
//            unlink(ROOT_PATH . 'public' . DS .'thumb'.DS.'big'.DS.$img);
//            unlink(ROOT_PATH . 'public' . DS .'thumb'.DS.'small'.DS.$img);
//            unlink(ROOT_PATH . 'public' . DS .'uploads'.$img);
            Db::table('correlation')->where('goods_id',$value)->delete();
        }
        $this->redirect('recycle');
    }
    /**
     * 商品查找
     *
     * @param  int  $id
     * @return mixed
     */
    public function search(){
        $model=new GoodsModel();
        $list=$model->whereOr('goods_name','like','%'.input('filter_name').'%')
              ->whereOr('shop_price','>',input('filter_price'))
              ->whereOr('is_show','like','%'.input('filter_status').'%')
              ->where('is_delete',0)
              ->select();
        foreach ($list as $value){
            if($value['is_show']==1){
                $value['is_show']='上架';
            }else{
                $value['is_show']='下架';
            }
        }
        return $this->fetch('index',['list'=>$list]);
    }

    public function sear(){
        $model=new GoodsModel();
        $list=$model->whereOr('goods_name','like','%'.input('filter_name').'%')
            ->whereOr('shop_price','>',input('filter_price'))
            ->whereOr('is_show','like','%'.input('filter_status').'%')
            ->where('is_delete',1)
            ->select();
        foreach ($list as $value){
            if($value['is_show']==1){
                $value['is_show']='上架';
            }else{
                $value['is_show']='下架';
            }
        }
        return $this->fetch('recycle',['list'=>$list]);
    }

}
