<?php

namespace Upload;

use Illuminate\Support\Facades\Redis;

class RedisSavedPath
{

    public static function exists($key)
    {
        $result = Redis::hexists('upload_resource', $key);

        if ( $result === 1 ) {
            return true;
        } elseif ( $result === 0 ) {
            return false;
        } else {
            throw new \Exception('exists error');
        }
    }

    public static function get($key)
    {
        $result = Redis::hget('upload_resource', $key);

        if ( $result === null ) {
            throw new \Exception('read error');
        }

        return $result;
    }

    public static function set($key, $savedPath)
    {
        $result = Redis::hset('upload_resource', $key, $savedPath);

        if ( $result !== 0 && $result !== 1 ) {
            throw new \Exception('write error');
        }

        return true;
    }

    public static function setMulti($keyArr)
    {
        Redis::hmset('upload_resource', $keyArr);

        return true;
    }

    public static function delete($key)
    {
        $result = Redis::hdel('upload_resource', $key);

        if ( $result === 0 ) {
            throw new \Exception('delete error');
        }

        return true;
    }

    public static function deleteAll()
    {
        Redis::del('upload_resource');

        return true;
    }

    public static function getKey($group, $hash)
    {
        return $group . '_' . $hash;
    }


}
