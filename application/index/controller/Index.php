<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Cache;

class Index extends Controller
{
    /**
     * @return array 城市
     */
//    public function city()
//    {
//        //判断缓存是否存在
//        if (cache('code')){
//            $arr = cache('code');
//        }else{
//            $arr = [];
//            $data = Db::table('city')->field('id,code,name,pz,path')->where('')->order('code asc')->select();
//            foreach ($data as $k => $v) {
//                if ($v['path'] == 0) {
//                    $arr[] = $v;
//                }
//            }
//            //数组重新组装
//            for ($i = 0; $i < count($arr); $i++) {
//                for ($j=1;$j<count($data);$j++) {
//                    if ($arr[$i]['id'] == $data[$j]['path']){
//                        $arr[$i]['son'][] = $data[$j];
//                    }
//                }
//            }
//            cache('code',$arr,3600);       //设置缓存
//        }
//        return $arr;
//    }

    /**
     * 车型
     * @return array 输出车型
     */
    function car()
    {
        $data = Db::table('brands')->where('')->order('letter asc')->select();
        $car = [];
        $hot = [];
        $Car = [];
        $i = 0;
        foreach ($data as $k => $v) {
            $car[$v['letter']][$v['brand_name']] = $v;
            //热门判断
            if ($v['hot'] == 1) {
                $hot[$i] = $v;
                $i++;
            }
        }
        $Car['car'] = $car;
        $Car['hot'] = $hot;
        return $Car;
    }

    /**车型
     * @return false|mixed|\PDOStatement|string|\think\Collection
     */
    function choose()
    {
        $code = $_POST['code'];
        $data = Db::table('brands2')->where('brand_code', $code)->select();
        return $data;
    }

    /**车型
     * @return array
     */
    function choose2()
    {
        $uuid = $_POST['uuid'];
        $data = Db::table('brands3')->where('family_uuid', $uuid)->select();
        $type = [];
        $i = 0;
        foreach ($data as $k => $v) {
            $type[$v['displacement']][$i] = $v;
            $i++;
        }
        return $type;
    }
}
