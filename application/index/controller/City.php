<?php
namespace app\index\controller;

use think\Controller;

class City extends Controller
{
    public function selectCity()
    {
        if (cache('code')){
            $arr = cache('code');
        }else{
            $user = model('city');
            $arr=$user->getCity();  //调用方法
            cache('code',$arr,3600); //设置缓存
        };
        return $arr;
    }
}