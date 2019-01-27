<?php
/**
 * 上传静态文件到云
 *
 * User: wangkaihui
 * Date: 2018/1/23
 * Time: 15:51
 */

namespace Lib\Command;

use Trensy\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Trensy\Di;
use Trensy\Log;
use Trensy\Support\Dir;
class Assets extends Base
{

    protected function configure()
    {
        $this->setName('tool:assets')
            ->setDescription('upload resource to yun');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try{
            $path = RESOURCE_PATH."/public/static";
            $files = Dir::scan($path, Dir::SCAN_BFS);
            $fileService = Di::get('\Lib\Service\FileService');
            $version = Config::get("app.view.static_version");
            $groupCode = "assets";
            if($files){
                foreach ($files as $v){
                    $localFilePath = $v;
                    $nextpath = substr($v,strlen($path));
                    $remoteFilePath = $groupCode."/".$version."/static".$nextpath;
                    $originalzName = pathinfo($v, PATHINFO_FILENAME);
                    $fileService->push($localFilePath, $remoteFilePath, $groupCode,0, $originalzName);
                    Log::show('upload: ' . $localFilePath." success!");
                }
            }
            Log::show("done Success!");
        }catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
    }

}