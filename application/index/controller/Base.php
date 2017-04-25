<?php
/**
 * Created by PhpStorm.
 * User: luxiao
 * Date: 2017/4/20
 * Time: 14:39
 */

namespace app\index\controller;
use think\Controller;
use My\RedisPackage;

class Base extends Controller
{
    protected static $redis;

    public function __construct()
    {
        parent::__construct();
        if(!self::$redis) {
            self::$redis= new RedisPackage();
        }
    }

}