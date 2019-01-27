<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2018/1/8
 * Time: 13:01
 */

namespace Admin\Service\Base;


use Lib\Base\BaseService;
use Lib\Service\FileService;
use Lib\Support\Error;
use Admin\Dao\System\BackupDao;
use Trensy\Di;
use Trensy\Log;

final class BackupService extends BaseService
{

    /**
     * @var \Admin\Dao\System\BackupDao
     */
    public $backupDao;

    /**
     * @var \Lib\Service\FileService
     */
    public $fileService;


    public function getList($searchField, $searchValue, $page, $pageSize)
    {
        $data = [];
        if($searchValue) $data[$searchField] = ["like", "%".$searchValue."%"];
        list($list,$count, $totalPage) =  $this->backupDao->pager($data, $page, $pageSize, "created_at DESC");

        return [$list, $totalPage];
    }


    public function checkGroupKey($name, $id=0)
    {
        $data = [];
        $data['name'] = $name;
        if($id) $data['id'] = ["!=", $id];
        return $this->backupDao->get($data);
    }

    public function getById($id)
    {
        $data = [];
        $data['id'] = $id;
        return $this->backupDao->get($data);
    }

    public function add($name, $tables)
    {
        $idata = [];
        $idata['name'] = $name;
        $idata['tables'] = implode(",", $tables);
        return $this->backupDao->autoAdd($idata);
    }

    public function deleteGroup($id)
    {
        return $this->backupDao->delete(['id'=>$id]);
    }

    public function getTables()
    {
        $sql = "show table status";
        return $this->backupDao->selectAll($sql);
    }

    public function backup($tables)
    {
        $idata = [];
        $idata['name'] = date('YmdHis');
        $idata['status'] = 1;
        $idata['tables'] = implode(',', $tables);
        $id = $this->backupDao->autoAdd($idata);
        //异步备份
        \Task::backup($tables, $id);
    }

    public function doBackup($tables, $id)
    {
        if(!$tables) return "";
        $backupDirConfig = $this->getDbOption('base', 'backup_dir');

        try{
            $backupDirTmp = "/".date('Y/m')."/";
            $backupDir = $backupDirConfig.$backupDirTmp;
            if(!is_dir($backupDir)){
                mkdir($backupDir, 0777 , true);
            }
            $backupDirTmp = $backupDirTmp.date('YmdHis').".sql";
            $backPath = $backupDirConfig.$backupDirTmp;

            $db = $this->backupDao->getConnect();
            foreach($tables as $table) {
                $stmt = $db->query("DESC $table");
                $tableFields = $stmt->fetchAll(\PDO::FETCH_COLUMN);
                $numColumns = count($tableFields);

                $return = "DROP TABLE $table;";

                $result2 = $db->query("SHOW CREATE TABLE $table");
                $row2 = $result2->fetch();
                $row2 = array_values($row2);
                $return .= "\n\n" . $row2['1'] . ";\n\n";
//                Log::debug($return);
                file_put_contents($backPath, $return, FILE_APPEND);

                $sql = "SELECT * FROM $table";

                foreach ($db->query($sql) as $row) {
                    $row = array_values($row);
                    $return = "INSERT INTO `$table` VALUES(";
                    for ($j = 0; $j < $numColumns; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($numColumns - 1)) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                    file_put_contents($backPath, $return, FILE_APPEND);
                }

                $return = "\n\n\n";

                file_put_contents($backPath, $return, FILE_APPEND);
            }

            $udata = [];
            $udata['status'] = 2;
            $udata['path'] = $backupDirTmp;
            $this->backupDao->autoUpdate($udata, ['id'=>$id]);
            return true;
        }catch(\Exception $e){
            $udata = [];
            $udata['status'] = 0;
            $udata['note'] = "【备份失败】".$e->getMessage()."<br>".$e->getTraceAsString();
            $this->backupDao->autoUpdate($udata, ['id'=>$id]);
            return true;
        }
    }

    public function upyun($id, $uid)
    {
        $data = [];
        $data['id'] = $id;
        $info = $this->backupDao->get($data);
        if(!$info) return false;
        $backupDirConfig = $this->getDbOption('base', 'backup_dir');
        $path = $backupDirConfig.$info['path'];
        $groupCode = "backupsql";
        $originalName = pathinfo($path, PATHINFO_BASENAME);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $newFilename = sha1(uniqid() . $originalName);
        $remoteFilePath = $groupCode."/".date('Y/m/d')."/".$newFilename.".".$ext;
        try{
            list($fileId, $uri) = $this->fileService->push($path, $remoteFilePath, $groupCode, $uid, $originalName);
            $this->fileService->bindTarget($fileId, "backupsql", 0);
            $udata = [];
            $udata['yun_file_id'] = $fileId;
            $udata['note'] = "【上传云成功】地址:".$uri;
            $this->backupDao->autoUpdate($udata, ['id'=>$id]);
            return true;
        }catch(\Exception $e)
        {
            $udata = [];
            $udata['note'] = "【上传云失败】".$e->getMessage()."<br>".$e->getTraceAsString();
            $this->backupDao->autoUpdate($udata, ['id'=>$id]);
            return Error::add($e->getMessage());
        }
    }

    public function import($id)
    {
        try{
            $data = [];
            $data['id'] = $id;
            $info = $this->backupDao->get($data);
            if(!$info) return false;
            $backupDirConfig = $this->getDbOption('base', 'backup_dir');
            $path = $backupDirConfig.$info['path'];
            if(!is_file($path)) return Error::add("数据文件[$path]不存在!");
            $this->backupDao->import($path);
            return true;
        }catch(\Exception $e){
            $udata = [];
            $udata['note'] = "【还原失败】".$e->getMessage()."<br>".$e->getTraceAsString();
            $this->backupDao->autoUpdate($udata, ['id'=>$id]);
            return Error::add($e->getMessage());
        }

    }

}