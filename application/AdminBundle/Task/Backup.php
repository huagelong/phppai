<?php
/**
 *  备份表
 *
 * Trensy Framework
 *
 * PHP Version 7
 *
 * @author          kaihui.wang <hpuwang@gmail.com>
 * @copyright      trensy, Inc.
 * @package         trensy/framework
 * @version         1.0.7
 */

namespace Admin\Task;

use Lib\Support\Xtrait\Helper;
use Admin\Service\BackupService;
use Trensy\Config;
use Trensy\Foundation\Exception\ConfigNotFoundException;
use Trensy\TaskAbstract;
use Trensy\Log;

final class Backup extends TaskAbstract
{
    use Helper;

    /**
     * @var \Admin\Service\Base\BackupService
     */
    public $backupService;


    /**
     * @param $tables
     * @param $id
     * @return bool
     */
    public function perform($tables, $id)
    {
        $this->backupService->doBackup($tables, $id);
        return true;
    }
}