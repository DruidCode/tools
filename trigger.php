<?php
/* 生成trigger语句
 *
 *
 *
 */

define('POST_URL', 'http://192.168.2.104:8018/index.php?/api_privcache/trigger_push'); 

define('DELIMITER'      ,  '|');
define('TABLE_SEPARATOR',  '_');
define('LINE_SEPARATOR' ,  "\r\n");
define('EVENT_UPDATE'   ,  "UPDATE");
define('EVENT_INSERT'   ,  "INSERT");
define('EVENT_DELETE'   ,  "DELETE");
define('ALIAS_OLD'      ,  "OLD");
define('ALIAS_NEW'      ,  "NEW");
define('CACHE_VARIABLE' ,  "ts_group_weibo");
define('KEY_VARIABLE'   ,  'weibo_id');
define('TIME_BEFORE'    ,  'BEFORE');
define('TIME_AFTER'     ,  'AFTER');

function triggerName($table, $event, $triggerName)
{
    return $triggerName ? $triggerName : $table . '_' . $event;
}

function triggerStmt($stmt, $alias, $table)
{
    $str = '';
    if ( empty($stmt) ) {
		$post = array();
		$post[] = " CONCAT_WS( '=', '__table', '$table') ";
		$vars = explode(',', KEY_VARIABLE);
		foreach($vars as $var){
			$post[] = " CONCAT_WS( '=', '$var', $alias.$var) ";
		}
        $str .= 'SET @' . CACHE_VARIABLE . '=(';
        $str .= 'select(';
        $str .= "http_post('";
        $str .= POST_URL . "',";
        $str .= 'CONCAT_WS(';
        $str .= "'&', ".join(',', $post). '))));';
        return $str;
    }
    return $stmt;
}

function getAlias($event, $alias)
{
    if ( !empty($alias) ) return strtoupper($alias);
    switch ( strtoupper($event) ) {
        case EVENT_DELETE:
            return ALIAS_OLD;
        case EVENT_INSERT:
            return ALIAS_NEW;
        case EVENT_UPDATE:
            return ALIAS_NEW;
        default:
            break;
    }
}

function getTime($time)
{
    $time = strtoupper($time);
    switch ( $time ) {
        case TIME_BEFORE:
            return TIME_BEFORE;
        case TIME_AFTER:
            return TIME_AFTER;
        default:
            return TIME_AFTER;
    }
}

function createTrigger($table, $event, $alias, $time, $stmt, $triggerName)
{
    $triggerName = triggerName($table, $event, $triggerName);
    $time        = getTime($time);
    $alias       = getAlias($event, $alias);
    $stmt        = triggerStmt($stmt, $alias, $table);

    $str  = "DELIMITER " . DELIMITER . LINE_SEPARATOR;
    $str .= "DROP TRIGGER IF EXISTS " . $triggerName . DELIMITER . LINE_SEPARATOR;
    $str .= "CREATE TRIGGER " . $triggerName . LINE_SEPARATOR; 
    $str .= $time . ' ' . $event . ' ON ' . $table . LINE_SEPARATOR; 
    $str .= "FOR EACH ROW BEGIN" . LINE_SEPARATOR;
    $str .= $stmt . LINE_SEPARATOR; 
    $str .= "END " . DELIMITER . LINE_SEPARATOR;
    $str .= "DELIMITER ;";

    return $str;
}

function dropTrigger($triggerName)
{
    return 'DROP TRIGGER '. $triggerName;
}

/*
 * table 表名
 * event update,delete
 * alias old,new
 * time  before,after
 * stmt  执行的操作
 * triggerName 触发器名称 
 */
function getTrigger($table, $event, $alias=null, $time=null, $stmt=null, $triggerName=null)
{
    return createTrigger($table, $event, $alias, $time, $stmt, $triggerName);
}

#example
$drop = dropTrigger('lf_test_update');

$trigger = getTrigger(CACHE_VARIABLE, 'delete');
echo $trigger;
echo "\n\r";
$trigger = getTrigger(CACHE_VARIABLE, 'update');
echo $trigger;
echo "\n\r";
$trigger = getTrigger(CACHE_VARIABLE, 'insert');
echo $trigger;
echo "\n\r";
