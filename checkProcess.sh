#!/bin/sh
#该进程只适合单个进程的重启

#查找进程是否存在
#参数为查找进程的条件
checkProgress()
{
PID=`ps -ef |grep $1 |grep -v "grep" | awk '{print $2}'`
PID2=`ps -efl |grep $1 |grep -v "grep" | awk '{print $4}'`
if [ -n $PID3 -o -n $PID4 ]
then
    echo "start succeed"
else
    echo "start failed"
fi
}

#第一个参数为要查找进程的条件
#第二个参数为重启的命令
#第三个参数为kill的信号
restartProgress()
{
PID=`ps -ef |grep $1 |grep -v "grep" | awk '{print $2}'`
condition=$1
COMMAND=$2
SIGNAL=$3
if [ -z $PID ]
then
    PID2=`ps -efl |grep $condition |grep -v "grep" | awk '{print $4}'`
    if [ -z $PID2 ]
    then
        echo "this progress not exist, so starting"
        $2
        checkProgress $condition
    else 
        echo "progress exist and number = $PID2"
        kill -$SIGNAL $PID2 
        echo "progress has killed and starting"
        sleep 1s
        $COMMAND
        checkProgress $condition
    fi
else
    echo "progress exist and number = $PID"
    kill -$SIGNAL $PID
    echo "progress has killed and starting"
    sleep 1s
    $COMMAND
    checkProgress $condition
fi
}
restartProgress redis-server '/usr/local/bin/redis-server /usr/local/redis/etc/redis.conf' TERM  

