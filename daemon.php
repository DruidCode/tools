<?php

function createProcess($time)
{
    $parentPid = getmypid();
    $pid = pcntl_fork();
    if ($pid == -1) {
        dir('fork process failed');
    } else if ($pid == 0) {
        $myPid = getmypid();
        log_write('i am child my pid = ' . $myPid . chr(10));
        work($time);
    } else { 
        log_write('i am parent ->' . $parentPid . ' and child is ' . $pid);
		exit(0);
    }
}

function createWork()
{
    for ($i = 0; $i < 2; $i++) {
        $time = gettimeofday(true);
        createProcess($time);
    }
}

function signalHandler($signal)
{
    switch ($signal) {
        case SIGINT:
            echo 'signal received' . chr(10);
            break;
        default:
            break;
    }
}

function log_write($contents)
{
    file_put_contents('daemon.log', $contents, FILE_APPEND);
}
//pcntl_signal(SIGINT, 'signalHandler');

function work($time)
{
    while (true) {
        log_write($time . chr(10));
		sleep(2);
    }
}

function processHolder()
{
    $pid = pcntl_waitpid(-1, $status, WNOHANG);
    log_write($status . chr(10));
    if ($pid > 0) {
        createWork();
    } else if ($pid === 0) {
        #没有可用子进程
        sleep(10);
    }
    unset($pid, $status);
}

createWork();
while (true) {
    processHolder();
}
