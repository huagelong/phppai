<?php

namespace Lib\Support\Xtrait;

use Trensy\Support\Dir;

trait Cmd
{
    protected $user = null;

    /**
     * 设置执行命令的用户
     *
     * @param $gitUser
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * 系统执行命令路径
     * @param $cms
     * @param $bin
     */
    public function whichBinPath($binName)
    {
        $binPath = $this->whichBin($binName);
        return substr($binPath, 0, (strlen($binPath)-strlen($binName)-1));
    }

    /**
     * 普通命令执行
     * @param $command
     * @param null $binPath
     * @param string $user
     * @return bool
     * @throws \Exception
     */
    public function exec($command, $binPath=null, $user=null){
        if($binPath) $command = Dir::formatPath($binPath) .$command;
        $command = $this->sudoCommandAsDaemonUser($command, $user);
        exec($command , $outRs, $rs);
        return $outRs?$outRs:false;
    }

    /**
     * @param $command
     * @param null $binPath
     * @param null $user
     * @return string
     * @throws \Exception
     */
    public function popenRead($command, $binPath=null, $user=null, $isShow=1)
    {
        if($binPath) $command = Dir::formatPath($binPath) .$command;
        $command = $this->sudoCommandAsDaemonUser($command, $user);
        $handle = popen($command, 'r');
        $buffer = "";
        while(!feof($handle)) {
            $tmp = fread($handle,8192);
            if($isShow) echo $tmp;
            $buffer .= $tmp;
        }
        pclose($handle);
        return $buffer;
    }


    public function getStdin()
    {
        $handle = fopen("php://stdin", 'r');
        $buffer = "";
        while(!feof($handle)) {
            $buffer .= fread($handle,8192);
        }
        pclose($handle);
        return $buffer;
    }


    /**
     * 执行有管道输入的命令
     *
     * @param $command
     * @param null $input 输入数据
     * @param null $cwd 当前执行路径
     * @param null $binPath 执行命令的路径
     * @param null $env 执行环境
     * @param null $user 执行用户
     * @return mixed
     * @throws \Exception
     */
    public function execCommand($command, $input=null, $cwd=null, $binPath=null, $env=null, $user=null)
    {
        if($binPath) $command = Dir::formatPath($binPath) .$command;
        $user = $user?$user:$this->user;

        $command = $this->sudoCommandAsDaemonUser($command, $user);
        $descriptorspec = array(
            0 => array("pipe", "r"),  // STDIN
            1 => array("pipe", "w"), //STDOUT
            2 => array('pipe', 'w')  // STDERR
        );
        $cwd = $cwd?$cwd:sys_get_temp_dir();

        $proc = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

        if(is_resource($proc)){
            if ($input){
                fwrite($pipes[0], $input);
            }
        }else{
            throw new \Exception('Could not execute process');
        }

        //todo timeout
        $buffer = $this->timeOutGetStream(120, $proc, $pipes[1]);
        $stderr = $this->timeOutGetStream(20, $proc, $pipes[2]);
        if($stderr){
            dump($stderr);
            throw new \Exception($stderr);
        }

        // close used resources
        foreach($pipes as $pipe){
            fclose($pipe);
        }

        @proc_terminate($proc, 9);

        proc_close($proc);

        return $buffer;
    }

    public function execCommand2($command, $input=null, $cwd=null, $binPath=null, $env=null, $user=null)
    {
        if($binPath) $command = Dir::formatPath($binPath) .$command;
        $user = $user?$user:$this->user;

        $command = $this->sudoCommandAsDaemonUser($command, $user);
        $descriptorspec = array(
            0 => array("pipe", "r"),  // STDIN
            1 => array("pipe", "w"), //STDOUT
            2 => array('pipe', 'w')  // STDERR
        );
        $cwd = $cwd?$cwd:sys_get_temp_dir();

        $proc = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

        if(is_resource($proc)){
            if ($input){
                fwrite($pipes[0], $input);
            }
        }else{
            throw new \Exception('Could not execute process');
        }

        $buffer = "";
        while (!feof($pipes[1])) {
            $data = fread($pipes[1],8192);
            $buffer .= $data;
            echo $data;
        }

        $stderr = $this->timeOutGetStream(20, $proc, $pipes[2]);
        if($stderr){
            dump($stderr);
            throw new \Exception($stderr);
        }

        // close used resources
        foreach($pipes as $pipe){
            fclose($pipe);
        }

        @proc_terminate($proc, 9);

        proc_close($proc);

        return $buffer;
    }

    protected function timeOutGetStream($timeOut, $proc, $pipes)
    {
        stream_set_blocking($pipes, 0);
        $timeout = $timeOut * 1000000;

        $buffer = '';

        while ($timeout > 0) {
            $start = microtime(true);

            $read  = array($pipes);
            $other = array();
            stream_select($read, $other, $other, 0, $timeout);
            $status = proc_get_status($proc);
            $buffer .= stream_get_contents($pipes);

            if (!$status['running']) {
                break;
            }
            $timeout -= (microtime(true) - $start) * 1000000;
        }
        return $buffer;
    }

    /**
     * 根据用户执行
     *
     * @param $command
     * @param null $user
     * @return string
     * @throws \Exception
     */
    public function sudoCommandAsDaemonUser($command, $user=null) {

        if (!$user) {
            // No daemon user is set, so just run this as ourselves.
            return $command;
        }
        if (function_exists('posix_getuid')) {
            $uid = posix_getuid();
            $info = posix_getpwuid($uid);
            if ($info && $info['name'] == $user) {
                return $command;
            }
        }
        $sudo = $this->whichBin("sudo");
        if (!$sudo) {
            throw new \Exception("Unable to find 'sudo'!");
        }
        $str = $sudo . " -E -n -u {$user} -- {$command}";
        return $str;
    }

    /**
     * 查询命令全部路径
     * @param $str
     * @return bool
     */
    public function whichBin($str){
        exec("which {$str}", $result);
        if($result) return current($result);
        return false;
    }

    /**
     * 检查命令是否存在
     * @param $cmd
     * @return bool
     */
    public function checkCmd($cmd)
    {
        $cmdStr = "command -v " . $cmd;
        $check = $this->exec($cmdStr);
        if (!$check) {
            return false;
        } else {
            return current($check);
        }
    }


}