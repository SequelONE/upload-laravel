<?php

namespace Upload;

use Illuminate\Support\Facades\Redis;

class RedisClient
{

    public function write($field, $content)
    {
        $result = Redis::hset('upload_header', $field, $content);

        if ( $result !== 0 && $result !== 1 ) {
            throw new \Exception('write error');
        }

    }


    public function read($field)
    {
        $result = Redis::hget('upload_header', $field);

        if ( $result === null ) {
            throw new \Exception('read error');
        }

        return $result;
    }


    public function delete($field)
    {
        $result = Redis::hdel('upload_header', $field);

        if ( $result === 0 ) {
            throw new \Exception('delete error');
        }
    }

    public function exists($field)
    {
        $result = Redis::hexists('upload_header', $field);

        if ( $result === 1 ) {
            return true;
        } elseif ( $result === 0 ) {
            return false;
        } else {
            throw new \Exception('exists error');
        }
    }

    public function listContents($directory)
    {
        $result = [];
        $contents = Redis::hkeys('upload_header');

        if ( $contents === 0 ) {
            throw new \Exception('list error');
        }

        foreach ( $contents as $content ) {
            $arr['path'] = $directory . DIRECTORY_SEPARATOR . $content;
            $arr['type'] = 'file';
            $result[] = $arr;
        }

        return $result;
    }


}