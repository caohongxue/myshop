<?php

namespace app\myshop\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Article extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $iphone=Db::table('goods')
            ->where(['cat_id'=>2,'is_show'=>1])
            ->limit(8)
            ->select();
        $brand=Db::table('brand')
            ->where(['is_show'=>1,'b_id'=>2])
            ->limit(6)
            ->select();
        $content=Db::table('article')->where(['is_show'=>1])->select();
        foreach ($content as & $v) {
            $v['tab_name'] = Db::table($v['table_name'])->where('id',1)->select();
            $v['caputer']=Db::table($v['table_name'])->where('id',2)->select();
        }
        $brands=Db::table('brand')
            ->where(['b_id'=>1,'is_show'=>1])
            ->select();
        $computer=Db::table('goods')
            ->where(['cat_id'=>1,'is_show'=>1])
            ->limit(8)
            ->select();
        $brandss=Db::table('brand')
            ->where(['b_id'=>4,'is_show'=>1])
            ->select();
        $iphone_s=Db::table('goods')
            ->where(['cat_id'=>4,'is_show'=>1])
            ->limit(8)
            ->select();
        $brandsss=Db::table('brand')
            ->where(['b_id'=>3,'is_show'=>1])
            ->select();
        $computer_s=Db::table('goods')
            ->where(['cat_id'=>3,'is_show'=>1])
            ->limit(8)
            ->select();
        return $this->fetch('index',['iphone'=>$iphone,'brand'=>$brand,'content' => $content,'bd'=>$brands,'cp'=>$computer,'bdb'=>$brandss,'ips'=>$iphone_s,'bdbd'=>$brandsss,'cps'=>$computer_s]);
    }

    /**
     * 显示商品详情
     *
     * @return \think\Response
     */
    public function each($id){
        $data=Db::name('goods')->find($id);
//        var_dump($data);die;
        $brand=Db::name('brand')->find($data['brand_id']);
        $run=Db::name('processor')->find($data['runme_id']);
        $pro=Db::name('processor')->find($data['pro_id']);
        $mem=Db::name('running_memory')->find($data['memory_id']);
        return $this->fetch('each',['data'=>$data,'brand'=>$brand,'pro'=>$pro,'run'=>$run,'mem'=>$mem]);
    }



    /*
     * $id:品牌id
     * */
    public function saler($id)
    {
        $mobile=Db::table('brand')->where(['id'=>$id,'is_show'=>1])->find();
        if($mobile['b_id']==1){
            $mobile['b_id']='电脑';
        }elseif ($mobile['b_id']==2){
            $mobile['b_id']='手机';
        }elseif ($mobile['b_id']==3) {
            $mobile['b_id'] = '电脑配件';
        }elseif ($mobile['b_id']==4) {
            $mobile['b_id'] = '手机配件';
        }
        $ips=Db::table('goods')->where(['brand_id'=>$id])->paginate(8);
        $parts=Db::table('goods')
            ->alias('a')
            ->join('brand w','a.cat_id = w.b_id')
            ->where(['w.b_id'=>4])
            ->paginate(2);
//        var_dump($parts);die;
        return $this->fetch('saler',['mobile'=>$mobile,'ips'=>$ips,'parts'=>$parts]);
    }

    /**
     * 综合排序
     */
    public function click($id)
    {
        $mobile=Db::table('brand')->where(['id'=>$id,'is_show'=>1])->find();
        if($mobile['b_id']==1){
            $mobile['b_id']='电脑';
        }elseif ($mobile['b_id']==2){
            $mobile['b_id']='手机';
        }elseif ($mobile['b_id']==3) {
            $mobile['b_id'] = '配件';
        }

        $ips=Db::table('goods')
            ->where(['brand_id'=>$id])
            ->order('click_name','desc')
            ->paginate(8);

        $parts=Db::table('goods')
            ->alias('a')
            ->join('brand w','a.cat_id = w.b_id')
            ->where(['w.b_id'=>4])
            ->paginate(2);

        return $this->fetch('saler',['mobile'=>$mobile,'ips'=>$ips,'parts'=>$parts]);
    }

    /**
     * 按销量排序
     */
    public function sale($id)
    {
        $mobile=Db::table('brand')->where(['id'=>$id,'is_show'=>1])->find();
        if($mobile['b_id']==1){
            $mobile['b_id']='电脑';
        }elseif ($mobile['b_id']==2){
            $mobile['b_id']='手机';
        }elseif ($mobile['b_id']==3) {
            $mobile['b_id'] = '配件';
        }

        $ips=Db::table('goods')
            ->where(['brand_id'=>$id])
            ->order('sale_number','desc')
            ->paginate(8);

        $parts=Db::table('goods')
            ->alias('a')
            ->join('brand w','a.cat_id = w.b_id')
            ->where(['w.b_id'=>4])
            ->paginate(2);

        return $this->fetch('saler',['mobile'=>$mobile,'ips'=>$ips,'parts'=>$parts]);
    }

    /**
     * 按价格排序
     */
    public function price($id)
    {
        $mobile=Db::table('brand')->where(['id'=>$id,'is_show'=>1])->find();
        if($mobile['b_id']==1){
            $mobile['b_id']='电脑';
        }elseif ($mobile['b_id']==2){
            $mobile['b_id']='手机';
        }elseif ($mobile['b_id']==3) {
            $mobile['b_id'] = '配件';
        }

        $ips=Db::table('goods')
            ->where(['brand_id'=>$id,'is_show'=>1])
            ->order('shop_price','esc')
            ->paginate(8);

        $parts=Db::table('goods')
            ->alias('a')
            ->join('brand w','a.cat_id = w.b_id')
            ->where(['w.b_id'=>4])
            ->paginate(2);

        return $this->fetch('saler',['mobile'=>$mobile,'ips'=>$ips,'parts'=>$parts]);
    }

    /*
     * 按评论排序
     */
    public function tell($id)
    {
        $mobile=Db::table('brand')->where(['id'=>$id,'is_show'=>1])->find();
        if($mobile['b_id']==1){
            $mobile['b_id']='电脑';
        }elseif ($mobile['b_id']==2){
            $mobile['b_id']='手机';
        }elseif ($mobile['b_id']==3) {
            $mobile['b_id'] = '配件';
        }
//        var_dump($mobile);die;

        $ips=Db::table('goods')
            ->alias('a')
            ->join('brand w','a.brand_id = w.id')
            ->join('comment c','a.goods_id = c.goods_id')
            ->where(['a.brand_id'=>$id])
            ->order('comment_rank')
            ->paginate(8);
//        var_dump($ips);die;

        $parts=Db::table('goods')
            ->alias('a')
            ->join('brand w','a.cat_id = w.b_id')
            ->where(['w.b_id'=>4])
            ->paginate(2);

        return $this->fetch('saler',['mobile'=>$mobile,'ips'=>$ips,'parts'=>$parts]);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function isLog()
    {
        if(Session::has('user_name')){
            $this->success('订单生成中',url('Order/index'));
        }else{
            $this->success('未登录，请登录后购买！',url('Login/login'));
        }
    }
}
