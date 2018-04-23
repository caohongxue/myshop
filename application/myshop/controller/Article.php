<?php

namespace app\myshop\controller;

use think\Controller;
use think\Db;
use think\Request;

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
            ->where(['cat_id'=>1,'is_show'=>1])
            ->limit(8)
            ->select();
        $brand=Db::table('brand')
            ->where(['is_show'=>1])
            ->limit(6)
            ->select();
        $content=Db::table('article')->where('is_show','1')->select();
        foreach ($content as & $v) {
            $v['tab_name'] = Db::table($v['table_name'])->where('tab_id',1)->select();
            $v['caputer']=Db::table($v['table_name'])->where('tab_id',2)->select();
        }
        $brands=Db::table('brand')->where('b_id',2)->select();
        $brandd=Db::table('brand')->where('b_id',1)->select();
        $brandp=Db::table('brand')->where('b_id',3)->select();
        $rexo=Db::table('goods')->where('click_name','>','10')->limit(3)->select();
        return $this->fetch('index',['iphone'=>$iphone,'brand'=>$brand,'content' => $content,'bd'=>$brands,'bdd'=>$brandd,'bdp'=>$brandp,'rexo'=>$rexo]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function each($id){
        $data=Db::name('goods')->find($id);
        $brand=Db::name('brand')->find($data['brand_id']);
        $run=Db::name('processor')->find($data['runme_id']);
        $pro=Db::name('processor')->find($data['pro_id']);
        $mem=Db::name('running_memory')->find($data['memory_id']);
        $you=Db::table('goods')->where('click_name','>',10)->limit(5)->select();
        return $this->fetch('each',['data'=>$data,'brand'=>$brand,'pro'=>$pro,'run'=>$run,'mem'=>$mem,'you'=>$you]);
    }

    public function search()
    {
         $content=$_POST['index_none_header_sysc'];
         $sql="select `brand_name` from `brand` where `brand_name` like '%".$content."%'";
         $brand=Db::table('brand')->query($sql);
         $number="select count(*) from `goods` where `goods_name` like '%".$content."%'" ;
         $num=Db::table('goods')->query($number);
         $cat="select goods_name from `goods` where `goods_name` like '%".$content."'" ;
         $cate=Db::table('goods')->query($cat);
         $redn=Db::table('goods')->where('goods_name',['like','$content%'],['like','%$content'])->where('click_name',['>',10],['<>',20],'or')->select();


         return $this->fetch('search',['content'=>$content,'brand'=>$brand,'num'=>$num,'cate'=>$cate,'redn'=>$redn]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function table($id,$table)
    {
        //
        $tabl=Db::table($table)->where('tab_id',$id)->select();
//        $goo=Db::table('correlation')->find('id',$tabl['id'])['goods_id'];
//        $goos=Db::table('goods')->where('goods_id',$goo)->select();
//        var_dump($goo);
//        die;
        return $this->fetch('sch',['table'=>$tabl]);

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
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
