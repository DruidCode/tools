<?php
/**
 * 捕捉进程退出原因
 * 参数为文件路径
 */

function shutdown_func($file)
{
    $e = error_get_last();
    if ($e) {
        $content = "Pid:[" . getmypid() . "]\tTime:[" . date('Y-m-d H:i:s') . "]|" . $e['message'] . " in " . $e['file'] . ' line ' . $e['line'].chr(10);
        file_put_contents($file, $content, FILE_APPEND);
    }
}

//将以下一行代码放入进程所在函数
register_shutdown_function('shutdown_func', 'progress_error.log');
