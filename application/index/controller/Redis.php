<?php
/**
 * Created by PhpStorm.
 * User: luxiao
 * Date: 2017/4/19
 * Time: 14:39
 */

namespace app\index\controller;

use app\index\controller\Base;

class Redis extends Base
{
    function redis()
    {
        self::$redis->set('zuiai','you');
        echo self::$redis->get('zuiai');
    }
}