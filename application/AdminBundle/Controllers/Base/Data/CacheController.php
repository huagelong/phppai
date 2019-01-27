<?php
/**
 * 清空缓存
 *
 * User: wangkaihui
 * Date: 2018/1/23
 * Time: 11:59
 */

namespace Admin\Controllers\Base\Data;


use Admin\Controllers\BaseController;

final class CacheController extends BaseController
{


    /**
     * @var \Admin\Service\Base\CacheService
     */
    public $cacheService;

    public function clear()
    {
        $this->view->redisNum = $this->cacheService->getRedisCacheNum();
        $this->view->compileNum = $this->cacheService->getCompileCacheNum();
        $this->view->fileNum = $this->cacheService->getFileCacheNum();

        $this->display("admin::base/data/cache/index");
    }

    public function doClear()
    {
        $this->cacheService->clearRedisCache();

        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@cache/clear'));
    }

    public function doFileClear()
    {
        $this->cacheService->clearFileCache();
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@cache/clear'));
    }

    public function doCompileClear()
    {
        $this->cacheService->clearCompileCache();
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@cache/clear'));
    }

}