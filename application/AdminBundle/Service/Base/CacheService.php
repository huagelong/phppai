<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2018/1/8
 * Time: 22:24
 */

namespace Admin\Service\Base;


use Lib\Base\BaseService;
use Trensy\Support\Dir;

final class CacheService extends BaseService
{


    public function clearRedisCache()
    {
        $this->cache()->clearAll();
    }

    public function getRedisCacheNum()
    {
        return $this->cache()->getCacheCount();
    }


    public function getFileCacheNum()
    {
        $allkey = $this->fileCache()->getAllKey();
        return $allkey?count($allkey):0;
    }

    public function getCompileCacheNum()
    {
        $files = Dir::scan(STORAGE_PATH."/compile", Dir::SCAN_BFS);

        return count($files);
    }

    public function clearCompileCache()
    {
        $files = Dir::scan(STORAGE_PATH."/compile", Dir::SCAN_BFS);
        if($files){
            foreach ($files as $v){
                unlink($v);
            }
        }
        return true;
    }

    public function clearFileCache()
    {
        $this->fileCache()->clear();
        return true;
    }
}
