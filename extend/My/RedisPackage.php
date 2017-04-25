<?php
/**
 * Created by PhpStorm.
 * User: luxiao
 * Date: 2017/4/19
 * Time: 16:21
 */

namespace My;

class RedisPackage
{
    protected static $handler = null;
    protected static $options = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'timeout' => 0,
        'expire' => 0,
        'persistent' => false,
        'prefix' => '',
    ];

    public function __construct($options = [])
    {
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('not support: redis');      //判断是否有扩展
        }
        if (!empty($options)) {
            self::$options = array_merge(self::$options, $options);
        }
        $func = self::$options['persistent'] ? 'pconnect' : 'connect';     //长链接
        self::$handler = new \Redis;
        self::$handler->$func(self::$options['host'],self::$options['port'], self::$options['timeout']);

        if ('' != self::$options['password']) {
            self::$handler->auth(self::$options['password']);
        }

        if (0 != self::$options['select']) {
            self::$handler->select(self::$options['select']);
        }
    }

    /**
     * 写入缓存
     * @param string $key 键名
     * @param string $value 键值
     * @param int $exprie 过期时间 0:永不过期
     * @return bool
     */
    public static function set($key, $value, $exprie = 0)
    {
        if ($exprie == 0) {
            $set = self::$handler->set($key, $value);
        } else {
            $set = self::$handler->setex($key, $exprie, $value);
        }
        return $set;
    }

    /**
     * 读取缓存
     * @param string $key 键值
     * @return mixed
     */
    public static function get($key)
    {
        $fun = is_array($key) ? 'Mget' : 'get';
        return self::$handler->{$fun}($key);
    }

    /**
     * 获取值长度
     * @param string $key
     * @return int
     */
    public static function lLen($key)
    {
        return self::$handler->lLen($key);
    }

    /**
     * 将一个或多个值插入到列表头部
     * @param $key
     * @param $value
     * @return int
     */
    public static function LPush($key, $value, $value2 = null, $valueN = null)
    {
        return self::$handler->lPush($key, $value, $value2, $valueN);
    }

    /**
     * 移出并获取列表的第一个元素
     * @param string $key
     * @return string
     */
    public static function lPop($key)
    {
        return self::$handler->lPop($key);
    }
}