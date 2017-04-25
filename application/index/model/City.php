<?php
namespace app\index\model;

use think\Model;
use think\Db;

class City extends Model
{
    protected $pk = 'id';
    protected $resultSetType = '';

    protected static function init()
    {

    }

    /**
     * 获取城市名称
     * @return static
     */
    function getCity()
    {
        $arr = [];
        $data = Db::table('city')->field('id,code,name,pz,path')->where('')->order('code asc')->select();
        foreach ($data as $k => $v) {
            if ($v['path'] == 0) {
                $arr[] = $v;
            }
        }
        //数组重新组装
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 1; $j < count($data); $j++) {
                if ($arr[$i]['id'] == $data[$j]['path']) {
                    $arr[$i]['son'][] = $data[$j];
                }
            }
        }
        return $arr;
    }
}